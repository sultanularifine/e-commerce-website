@extends('frontend.layouts.app')

@section('title', 'Product - Auto Parts Market')

@section('style')
<style>
  * {
    margin: 0;
    padding: 0;
    box-sizing: border-box;
    font-family: "Poppins", sans-serif;
  }

  body {
    background: #fff;
    color: #333;
    line-height: 1.5;
  }

  /* PRODUCT SECTION */
  .product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 40px 60px;
    gap: 30px;
  }

  .product-images {
    flex: 1 1 40%;
    max-width: 500px;
  }

  .product-images img.main-image {
    width: 100%;
    border-radius: 10px;
    transition: 0.3s;
  }

  .product-thumbs {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
  }

  .product-thumbs img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 1px solid #ccc;
    border-radius: 6px;
    cursor: pointer;
    transition: 0.3s;
  }

  .product-thumbs img:hover {
    border-color: #ff6600;
  }

  .product-details {
    flex: 1 1 50%;
  }

  .product-details h1 {
    font-size: 26px;
    margin-bottom: 10px;
  }

  .product-details .price {
    font-size: 22px;
    font-weight: bold;
    color: #222;
    margin: 10px 0;
  }

  .old-price {
    text-decoration: line-through;
    color: #888;
    font-weight: normal;
    margin-left: 8px;
    font-size: 16px;
  }

  .in-stock {
    color: green;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .text-danger {
    color: red;
    font-weight: 600;
    margin-bottom: 8px;
  }

  .stars {
    color: #f1c40f;
    margin-bottom: 10px;
  }

  .product-details p {
    margin: 15px 0;
    color: #555;
  }

  .product-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 15px 0;
    flex-wrap: wrap;
  }

  .product-actions input {
    width: 60px;
    padding: 6px;
    text-align: center;
    border: 1px solid #ccc;
    border-radius: 4px;
  }

  .btn {
    background: #ff6600;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
  }

  .btn:hover {
    background: #e55500;
  }

  /* PRODUCT TABS */
  .tabs {
    margin: 40px 60px;
  }

  .tab-buttons {
    display: flex;
    border-bottom: 2px solid #eee;
    flex-wrap: wrap;
  }

  .tab-buttons button {
    background: none;
    border: none;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    transition: 0.3s;
  }

  .tab-buttons button.active {
    border-color: #ff6600;
    color: #ff6600;
  }

  .tab-content {
    padding: 20px 0;
  }

  /* RELATED PRODUCTS */
  .related-products {
    background: #f9f9f9;
    padding: 40px 60px;
  }

  .related-products h2 {
    text-align: center;
    margin-bottom: 30px;
    font-size: 24px;
  }

  .product-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 20px;
  }

  .product-card {
    background: #fff;
    border-radius: 10px;
    padding: 15px;
    text-align: center;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
    transition: 0.3s;
  }

  .product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 5px 12px rgba(0, 0, 0, 0.15);
  }

  .product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
  }

  .product-card h3 {
    font-size: 16px;
    margin: 10px 0;
  }

  .product-card .price {
    color: #ff6600;
    font-weight: bold;
  }

  footer {
    background: #222;
    color: #ccc;
    padding: 40px 20px;
    text-align: center;
  }

  footer a {
    color: #ff6600;
    text-decoration: none;
    margin: 0 8px;
  }

  footer a:hover {
    text-decoration: underline;
  }

  /* RESPONSIVE DESIGN */
  @media (max-width: 992px) {
    .product-container {
      flex-direction: column;
      align-items: center;
      padding: 30px;
    }
    .product-details,
    .product-images {
      max-width: 100%;
    }
  }

  @media (max-width: 600px) {
    .tab-buttons {
      flex-direction: column;
      align-items: center;
    }

    .product-actions {
      flex-direction: column;
      align-items: flex-start;
    }

    .product-card img {
      height: 150px;
    }

    .related-products,
    .tabs {
      padding: 20px;
    }
  }
</style>
@endsection

@section('content')
<main>
  <section class="product-container">
    <div class="product-images">
      <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" 
           alt="{{ $product->name }}" 
           class="main-image">

      @if(!empty($product->images) && count($product->images))
      <div class="product-thumbs">
        @foreach($product->images as $img)
          <img src="{{ asset($img->gallery) }}" alt="{{ $product->name }}">
        @endforeach
      </div>
      @endif
    </div>

    <div class="product-details">
      <h1>{{ $product->name }}</h1>
      <div class="{{ $product->stock > 0 ? 'in-stock' : 'text-danger' }}">
        {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
      </div>
      <div class="stars">★★★★★</div>

      <div class="price">
        ${{ number_format($product->discount_price ?? $product->price, 2) }}
        @if($product->discount_price)
          <span class="old-price">${{ number_format($product->price, 2) }}</span>
        @endif
      </div>

      <p>{{ $product->description }}</p>

      <div class="product-actions">
        <label>Qty</label>
        <input type="number" value="1" min="1">
        <button class="btn">Add to Cart</button>
        <button class="btn">Buy Now</button>
      </div>
    </div>
  </section>

  <section class="tabs">
    <div class="tab-buttons">
      <button class="active">Details</button>
    </div>
    <div class="tab-content">
      <p>{{ $product->meta_description ?? 'No additional details.' }}</p>
    </div>
  </section>

  <section class="related-products">
    <h2>We Found Other Products You Might Like!</h2>
    <div class="product-grid">
      @foreach($relatedProducts as $related)
      <a href="{{ route('products.show', $related->slug) }}" class="product-card" style="text-decoration:none; color:inherit;">
        <img src="{{ asset($related->thumbnail ?? 'images/default.jpg') }}" alt="{{ $related->name }}">
        <h3>{{ $related->name }}</h3>
        <div class="price">
          ${{ number_format($related->discount_price ?? $related->price, 2) }}
          @if($related->discount_price)
            <span class="old-price">${{ number_format($related->price, 2) }}</span>
          @endif
        </div>
        <button class="btn">Add to Cart</button>
      </a>
      @endforeach
    </div>
  </section>
</main>
@endsection

@section('scripts')
<script>
  // Thumbnail image switch
  document.addEventListener('DOMContentLoaded', function () {
    const thumbs = document.querySelectorAll('.product-thumbs img');
    const mainImg = document.querySelector('.product-images .main-image');

    thumbs.forEach(thumb => {
      thumb.addEventListener('click', () => {
        mainImg.src = thumb.src;
      });
    });
  });
</script>
@endsection
