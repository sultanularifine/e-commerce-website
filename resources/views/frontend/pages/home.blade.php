@extends('frontend.layouts.app')

@section('title', 'Home - Auto Parts Market')

@section('style')
    <style>
        /* GENERAL */
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #fff;
            color: #333;
            line-height: 1.5;
        }

        a {
            text-decoration: none;
            color: inherit;
        }

        /* HERO SLIDER */
        .hero-slider {
            position: relative;
            width: 100%;
            height: 400px;
            overflow: hidden;
        }

        .hero-slider img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* .hero-text {
                                        position: absolute;
                                        bottom: 30px;
                                        left: 50px;
                                        color: #fff;
                                        background: rgba(0, 0, 0, 0.5);
                                        padding: 20px;
                                        border-radius: 8px;
                                    } */

        .slider-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            background: rgba(0, 0, 0, 0.4);
            color: #fff;
            border: none;
            padding: 10px;
            cursor: pointer;
            font-size: 18px;
            border-radius: 50%;
        }

        .slider-btn:hover {
            background: rgba(0, 0, 0, 0.7);
        }

        .prev-btn {
            left: 20px;
        }

        .next-btn {
            right: 20px;
        }

        .slider-dots {
            position: absolute;
            bottom: 15px;
            left: 50%;
            transform: translateX(-50%);
            display: flex;
            gap: 8px;
        }

        .slider-dots span {
            display: block;
            width: 12px;
            height: 12px;
            background: rgba(255, 255, 255, 0.6);
            border-radius: 50%;
            cursor: pointer;
        }

        .slider-dots span.active {
            background: #ff4d30;
        }

        /* FILTER BAR */
        .filter-bar {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 30px 0;
            flex-wrap: wrap;
        }

        .filter-bar select,
        .filter-bar button {
            padding: 8px 12px;
            border-radius: 5px;
            border: 1px solid #ccc;
        }

        .filter-bar button {
            background-color: #ff4d30;
            color: #fff;
            border: none;
            cursor: pointer;
            transition: 0.3s;
        }

        .filter-bar button:hover {
            background-color: #d93b25;
        }

        /* CATEGORIES */
        .categories {
            display: flex;
            justify-content: center;
            gap: 20px;
            padding: 40px 20px;
            flex-wrap: wrap;
            justify-content: space-evenly;
        }

        .category-card {
            width: 150px;
            text-align: center;
            padding: 15px;
            border-radius: 10px;
            transition: 0.3s;
            cursor: pointer;
            background: #f8f8f8;
        }

        .category-card img {
            width: 60px;
            margin-bottom: 10px;
        }

        .category-card:hover,
        .category-card.active {
            background: #0665c7;
            color: #fff;
        }

        /* NEW ARRIVALS / PRODUCTS */
        .new-arrivals {
            text-align: center;
            padding: 60px 20px;
            background: #f8f8f8;
        }

        .new-arrivals h2 {
            font-size: 28px;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .new-arrivals p {
            color: #666;
            margin-bottom: 40px;
        }

        .product-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            justify-items: center;
        }

        .product-card {
            background: #fff;
            border-radius: 10px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
            padding: 15px;
            width: 100%;
            max-width: 220px;
            display: flex;
            flex-direction: column;
            align-items: center;
            transition: all 0.3s ease;
            text-align: center;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }

        .product-card img {
            width: 100%;
            height: 180px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-card h3 {
            font-size: 15px;
            height: 40px;
            overflow: hidden;
            margin-bottom: 8px;
        }

        .stars {
            color: #f1c40f;
            margin-bottom: 8px;
        }

        .price {
            font-size: 16px;
            margin-bottom: 10px;
        }

        .old-price {
            text-decoration: line-through;
            color: #888;
            margin-right: 5px;
        }

        .new-price {
            color: #e63946;
            font-weight: bold;
        }

        .btn {
            background-color: #ff4d30;
            color: #fff;
            border: none;
            padding: 8px 16px;
            border-radius: 5px;
            cursor: pointer;
            transition: 0.3s;
        }

        .btn:hover {
            background-color: #d93b25;
        }

        /* RESPONSIVE */
        @media (max-width: 1024px) {
            .hero-slider {
                height: 300px;
            }

            .product-card img {
                height: 160px;
            }
        }

        @media (max-width: 768px) {
            .product-grid {
                grid-template-columns: repeat(auto-fit, minmax(180px, 1fr));
            }

            .categories {
                gap: 15px;
            }

            .category-card {
                width: 120px;
            }
        }

        @media (max-width: 480px) {
            .product-card img {
                height: 140px;
            }

            .hero-slider {
                height: 200px;
            }
        }

        /* Carousel Styles */
        .carousel-wrapper {
            overflow: hidden;
            position: relative;
            margin-bottom: 50px;
        }

        .carousel {
            display: flex;
            gap: 20px;
            animation: scroll 20s linear infinite;
        }

        .carousel:hover {
            animation-play-state: paused;
        }

        .card {
            flex: 0 0 auto;
            width: 200px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: scale(1.05);
        }

        .card img {
            width: 80px;
            height: 80px;
            object-fit: contain;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        @keyframes scroll {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-100%);
            }
        }

        @media (max-width: 1200px) {
            .card {
                width: 180px;
            }
        }

        @media (max-width: 900px) {
            .card {
                width: 150px;
            }
        }

        @media (max-width: 600px) {
            .card {
                width: 120px;
            }

            .carousel {
                gap: 10px;
            }
        }

        .brands {
            margin-top: 75px;
        }
    </style>
@endsection

@section('content')
    {{-- ✅ HERO SLIDER --}}
    <div class="hero-slider" id="heroSlider">
        @foreach ($sliders as $key => $slider)
            <div class="slide {{ $key == 0 ? 'active' : '' }}">
                <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                <div class="hero-text">
                    <h2>{{ $slider->title }}<br>
                        @if ($slider->subtitle)
                            <small>{{ $slider->subtitle }}</small>
                        @endif
                    </h2>
                </div>
            </div>
        @endforeach

        <button class="slider-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
        <button class="slider-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>
        <div class="slider-dots" id="sliderDots"></div>
    </div>



    {{-- ✅ FILTER BAR --}}
    <div class="filter-bar">
        <select>
            <option>Select Manufacturer</option>
        </select>
        <select>
            <option>Select Model</option>
        </select>
        <select>
            <option>Select Year</option>
        </select>
        <button><i class="fa-solid fa-magnifying-glass"></i> Search</button>
    </div>

    {{-- ✅ CATEGORIES --}}
    <div class="categories">

        @forelse($categories as $category)
            <div class="category-card">
                <img src="{{ asset($category->image ?? 'images/default-category.png') }}" alt="{{ $category->name }}">
                <h4>{{ $category->name }}</h4>

            </div>
        @empty
            <p class="text-center">No categories available right now.</p>
        @endforelse

    </div>

    {{-- NEW ARRIVALS --}}
    <section class="new-arrivals">
        <h2>NEW ARRIVALS</h2>
        <p>Check out our latest auto parts and accessories</p>

        <div class="product-grid">
            @forelse ($newArrivals as $product)
                <a href="{{ route('products.show', $product->slug) }}" class="product-card">
                    <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" alt="{{ $product->name }}">
                    <h3>{{ Str::limit($product->name, 40) }}</h3>
                    <div class="stars">★★★★☆</div>
                    <p class="price">
                        @if ($product->discount_price)
                            <span class="old-price">${{ number_format($product->price, 2) }}</span>
                            <span class="new-price">${{ number_format($product->discount_price, 2) }}</span>
                        @else
                            ${{ number_format($product->price, 2) }}
                        @endif
                    </p>
                    <button class="btn">ADD TO CART</button>
                </a>
            @empty
                <p>No products found.</p>
            @endforelse
        </div>
        <section class="brands">
            <div class="container">
                <h2 class="section-title">Our Brands</h2>
                <p class="description">Check out our latest auto parts and accessories</p>

                <div class="carousel-wrapper">
                    <div class="carousel">
                        @foreach ($brands as $brand)
                            <div class="card">
                                @if ($brand->logo)
                                    <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}">
                                @else
                                    <img src="https://via.placeholder.com/80" alt="No Logo">
                                @endif
                                <h4>{{ $brand->name }}</h4>
                            </div>
                        @endforeach

                        {{-- Duplicate for seamless scroll --}}
                        @foreach ($brands as $brand)
                            <div class="card">
                                @if ($brand->logo)
                                    <img src="{{ asset($brand->logo) }}" alt="{{ $brand->name }}">
                                @else
                                    <img src="https://via.placeholder.com/80" alt="No Logo">
                                @endif
                                <h4>{{ $brand->name }}</h4>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>


    @endsection

    @section('scripts')
        <script>
            const slides = document.querySelectorAll('.slide');
            const dotsContainer = document.getElementById('sliderDots');
            let current = 0;

            slides.forEach((_, i) => {
                const dot = document.createElement('span');
                dot.addEventListener('click', () => goToSlide(i));
                dotsContainer.appendChild(dot);
            });

            const dots = document.querySelectorAll('#sliderDots span');

            function showSlide(i) {
                slides.forEach(s => s.classList.remove('active'));
                dots.forEach(d => d.classList.remove('active'));
                slides[i].classList.add('active');
                dots[i].classList.add('active');
            }

            function nextSlide() {
                current = (current + 1) % slides.length;
                showSlide(current);
            }

            function prevSlide() {
                current = (current - 1 + slides.length) % slides.length;
                showSlide(current);
            }

            function goToSlide(i) {
                current = i;
                showSlide(current);
            }

            setInterval(nextSlide, 5000);
            document.querySelector('.next-btn').addEventListener('click', nextSlide);
            document.querySelector('.prev-btn').addEventListener('click', prevSlide);
            showSlide(current);
        </script>
    @endsection
