@extends('frontend.layouts.app')

@section('title', 'Search Results - Auto Parts Market')

@section('style')
    <style>
        main {
            background: #f8f8f8;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px 15px;
        }

        h1 {
            font-size: 24px;
            font-weight: 700;
            margin-bottom: 25px;
            border-bottom: 1px solid #eee;
            padding-bottom: 15px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 20px;
        }

        .product-card {
            text-align: center;
            padding: 15px;
            border: 1px solid #eee;
            position: relative;
            transition: 0.3s;
        }

        .product-card:hover {
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .product-image-container {
            width: 100%;
            height: 200px;
            overflow: hidden;
            border-radius: 8px;
            position: relative;
            margin-bottom: 10px;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            height: 3em;
            overflow: hidden;
        }

        .product-price {
            font-size: 16px;
            font-weight: 700;
            color: #333;
            margin: 5px 0 10px 0;
        }

        .sale-tag {
            position: absolute;
            top: 5px;
            left: 5px;
            background: #ff5722;
            color: #fff;
            padding: 3px 6px;
            font-size: 12px;
            font-weight: 700;
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
            margin-left: 5px;
        }

        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 600px) {
            .product-image-container {
                height: 150px;
            }
        }
    </style>
@endsection

@section('content')
    <main class="container">
        <h1>Search Results for: "{{ $query }}"</h1>

        @if ($products->count() > 0)
            <div class="product-grid">
                @foreach ($products as $product)
                    <div class="product-card">
                        <a href="{{ route('products.view', $product->slug) }}">
                            <div class="product-image-container">
                                @if ($product->discount_price)
                                    <span class="sale-tag">
                                        -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                    </span>
                                @endif
                                <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}"
                                    alt="{{ $product->name }}">
                            </div>
                            <h4 class="product-name">{{ $product->name }}</h4>
                            <p class="product-price">
                                ${{ number_format($product->discount_price ?? $product->price, 2) }}
                                @if ($product->discount_price)
                                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                                @endif
                            </p>
                        </a>

                        <form action="{{ route('cart.add', $product->id) }}" method="POST">
                            @csrf
                            <input type="hidden" name="quantity" value="1">
                            <button type="submit" class="btn btn-add-to-cart">ADD TO CART</button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Pagination --}}
            <div class="pagination-wrapper d-flex justify-content-center flex-wrap mt-4">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        @else
            <p>No products found matching your search.</p>
        @endif
    </main>
@endsection
