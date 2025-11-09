@extends('frontend.layouts.app')

@section('title', 'New Arrivals - Auto Parts Market')

@section('style')
    <style>
        MAIN {
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

        .btn-add-to-cart {
            background-color: #ffc107;
            color: #333;
            border: none;
            padding: 10px 15px;
            width: 100%;
            margin-top: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
        }

        .btn-add-to-cart:hover {
            background-color: #e0a800;
        }

        .listing-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }

        .sidebar h3 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 10px;
            border-bottom: 1px solid #eee;
            padding-bottom: 5px;
            text-transform: uppercase;
        }

        .filter-section {
            margin-bottom: 25px;
        }

        .filter-list {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .filter-list a {
            text-decoration: none;
            color: #666;
            display: block;
            padding: 3px 0;
        }

        .featured-item {
            display: flex;
            margin-bottom: 15px;
            padding-bottom: 10px;
            border-bottom: 1px dashed #eee;
        }

        .featured-item img {
            width: 50px;
            height: 50px;
            margin-right: 10px;
            object-fit: contain;
        }

        .featured-details .name {
            margin: 0;
            font-size: 13px;
            font-weight: 600;
        }

        .featured-details .price {
            color: #ff5722;
            font-weight: 700;
            margin: 3px 0 0 0;
        }

        .featured-details .old-price {
            color: #999;
            text-decoration: line-through;
            font-weight: 400;
            margin-left: 5px;
            font-size: 12px;
        }

        .listing-toolbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 10px 15px;
            border: 1px solid #eee;
            background: #f7f7f7;
            margin-bottom: 20px;
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

        .pagination-wrapper {
            display: flex;
            justify-content: center;
            margin-top: 30px;
        }

        @media (max-width: 992px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width: 768px) {
            .listing-layout {
                grid-template-columns: 1fr;
            }

            .sidebar {
                border-bottom: 1px solid #eee;
                padding-bottom: 15px;
            }

            .product-grid {
                grid-template-columns: repeat(2, 1fr);
            }

            .listing-toolbar {
                flex-direction: column;
                align-items: flex-start;
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
        <h1>NEW ARRIVALS</h1>

        <div class="listing-layout">
            {{-- Sidebar --}}
            <aside class="sidebar">
                <div class="filter-section filter-categories">
                    {{-- Categories --}}
                    <div class="filter-section filter-categories">
                        <h3>CATEGORIES</h3>
                        <ul class="filter-list">
                            @foreach ($categories as $category)
                                <li>
                                    <a href="{{ route('product.index', ['category' => $category->slug]) }}">
                                        {{ $category->name }} ({{ $category->products->count() }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    {{-- Brands --}}
                    <div class="filter-section filter-brands">
                        <h3>BRANDS</h3>
                        <ul class="filter-list">
                            @foreach ($brands as $brand)
                                <li>
                                    <a href="{{ route('product.index', ['brand' => $brand->slug]) }}">
                                        {{ $brand->name }} ({{ $brand->products->count() }})
                                    </a>
                                </li>
                            @endforeach
                        </ul>
                    </div>


                    <div class="filter-section featured-products">
                        <h3>FEATURED PRODUCTS</h3>
                        @foreach ($featuredProducts as $featured)
                            <a href="{{ route('products.view', $featured->slug) }}"
                                style="text-decoration:none; color:inherit;">
                                <div class="featured-item">
                                    <img src="{{ asset($featured->thumbnail ?? 'images/default.jpg') }}"
                                        alt="{{ $featured->name }}">
                                    <div class="featured-details">
                                        <p class="name">{{ $featured->name }}</p>
                                        <p class="price">
                                            ${{ number_format($featured->discount_price ?? $featured->price, 2) }}
                                            @if ($featured->discount_price)
                                                <span class="old-price">${{ number_format($featured->price, 2) }}</span>
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </a>
                        @endforeach
                    </div>
            </aside>

            {{-- Product Listing --}}
            <section class="product-listing">
                <div class="listing-toolbar">
                    <p class="item-count">Items: {{ $products->total() }}</p>
                    <div class="sort-options">
                        <span>Sort By:</span>
                        <select id="sortSelect">
                            <option value="position" {{ request('sort') == 'position' ? 'selected' : '' }}>Position
                            </option>
                            <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                            <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                        </select>
                    </div>
                </div>

                <div class="product-grid">
                    @forelse ($products as $product)
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
                    @empty
                        <p>No new arrivals found.</p>
                    @endforelse
                </div>

                <div class="pagination-wrapper d-flex justify-content-center flex-wrap mt-4">
                    {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
                </div>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
    <script>
        document.getElementById('sortSelect').addEventListener('change', function() {
            const params = new URLSearchParams(window.location.search);
            params.set('sort', this.value);
            params.delete('page');
            window.location.search = params.toString();
        });
    </script>
@endsection
