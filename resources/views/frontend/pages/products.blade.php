@extends('frontend.layouts.app')

@section('title', 'All Products - Auto Parts Market')

@section('style')
    <style>
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
            width: 90%;
            margin-top: 10px;
            cursor: pointer;
            font-weight: 700;
            transition: 0.3s;
        }

        .listing-layout {
            display: grid;
            grid-template-columns: 250px 1fr;
            gap: 30px;
        }

        .sidebar h3 {
            font-size: 16px;
            font-weight: 700;
            margin: 0 0 10px 0;
            padding-bottom: 5px;
            border-bottom: 1px solid #eee;
            text-transform: uppercase;
        }

        .filter-section {
            margin-bottom: 25px;
            padding-bottom: 15px;
            border-bottom: 1px solid #eee;
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

        .color-options {
            display: flex;
            gap: 5px;
        }

        .color-swatch {
            width: 20px;
            height: 20px;
            border-radius: 50%;
            border: 1px solid #ccc;
            cursor: pointer;
        }

        .color-swatch.red {
            background-color: #ff0000;
        }

        .size-options {
            display: flex;
            gap: 5px;
            flex-wrap: wrap;
        }

        .size-swatch {
            border: 1px solid #ccc;
            padding: 5px 10px;
            font-size: 12px;
            cursor: pointer;
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
            position: relative;
            margin-bottom: 10px;
        }

        .product-image-container img {
            max-width: 100%;
            height: auto;
            display: block;
            margin: 0 auto;
        }

        .product-name {
            font-size: 14px;
            font-weight: 500;
            height: 3em;
            overflow: hidden;
        }

        .product-price {
            font-size: 18px;
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

        .listing-pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            margin-top: 30px;
        }

        .listing-pagination span,
        .page-numbers span {
            margin: 0 5px;
            padding: 5px 10px;
            border: 1px solid #eee;
            cursor: pointer;
        }

        .page-numbers .active {
            background: #ffc107;
            border-color: #ffc107;
        }

        @media (max-width:992px) {
            .product-grid {
                grid-template-columns: repeat(3, 1fr);
            }
        }

        @media (max-width:768px) {
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

            .item-count {
                margin-bottom: 10px;
            }

            .listing-pagination {
                justify-content: center;
            }
        }

        .product-image-container {
            width: 100%;
            height: 200px;
            /* fixed height for all images */
            overflow: hidden;
            border-radius: 8px;
            position: relative;
        }

        .product-image-container img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            /* maintain aspect ratio and crop if necessary */
            display: block;
        }

        @media (max-width: 600px) {
            .product-image-container {
                height: 150px;
            }
        }

        .old-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
            margin-left: 5px;
        }
    </style>
@endsection

@section('content')
    <main class="container">
        <h1>ALL PRODUCTS</h1>

        <div class="listing-layout">
            {{-- Sidebar --}}
            <aside class="sidebar">
                {{-- Categories --}}
                <div class="filter-section filter-categories">
                    <h3>CATEGORIES</h3>
                    <ul class="filter-list">
                        @foreach ($categories as $category)
                            <li><a href="#">{{ $category->name }} ({{ $category->products->count() }})</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Brands --}}
                <div class="filter-section filter-manufacturer">
                    <h3>Brands</h3>
                    <ul class="filter-list">
                        @foreach ($brands as $brand)
                            <li><a href="#">{{ $brand->name }} ({{ $brand->products->count() }})</a></li>
                        @endforeach
                    </ul>
                </div>

                {{-- Featured Products --}}
                <div class="featured-products">
                    <h3>FEATURED PRODUCTS</h3>
                    @foreach ($featuredProducts as $featured)
                     <a href="{{ route('products.view', $featured->slug) }}" class="product-card" style="text-decoration: none; color: inherit;">
                        <div class="featured-item">
                            <img src="{{ asset($featured->thumbnail ?? 'images/default.jpg') }}"
                                alt="{{ $featured->name }}">
                            <div class="featured-details">
                                <p class="name">{{ $featured->name }}</p>
                                <p class="price">${{ number_format($featured->discount_price ?? $featured->price, 2) }}
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

            {{-- Products --}}
            <section class="product-listing">
                <div class="listing-toolbar">
                    <p class="item-count">Items {{ $products->count() }} </p>
                    <div class="sort-options">
                        <span>Sort By</span>
                        <select>
                            <option>Position</option>
                            <option>Name</option>
                            <option>Price</option>
                        </select>
                    </div>
                </div>

                <div class="product-grid">
                    @foreach ($products as $product)
                        <a href="{{ route('products.view', $product->slug) }}" class="product-card"
                            style="text-decoration: none; color: inherit;">
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
                            <button class="btn btn-add-to-cart">ADD TO CART</button>
                        </a>
                    @endforeach
                </div>


               {{-- Pagination --}}
            <div class="listing-pagination">
                {{ $products->links() }}
            </div>
            </section>
        </div>
    </main>
@endsection

@section('scripts')
@endsection
