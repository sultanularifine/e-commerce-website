@extends('frontend.layouts.app')

@section('title', 'Home - Auto Parts Market')

@section('style')
<style>
/* ================= GENERAL STYLES ================= */
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

/* ================= HERO SLIDER ================= */
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

.prev-btn { left: 20px; }
.next-btn { right: 20px; }

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

/* ================= FILTER BAR ================= */
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

/* ================= CATEGORIES ================= */
.categories {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-evenly;
    gap: 20px;
    background: #f8f8f8;
    padding: 40px 20px;
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

/* ================= NEW ARRIVALS ================= */
.new-arrivals {
    text-align: center;
    padding: 40px 20px;
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
    box-shadow: 0 2px 6px rgba(0,0,0,0.1);
    padding: 15px;
    max-width: 220px;
    display: flex;
    flex-direction: column;
    align-items: center;
    transition: all 0.3s ease;
    text-align: center;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 6px 12px rgba(0,0,0,0.2);
}

.product-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
    border-radius: 8px;
    margin-bottom: 10px;
}
.brands{
    background: #f8f8f8 ;
    padding-bottom: 60px;
    padding-top: 30px;
}
.product-card h3 {
    font-size: 15px;
    height: 40px;
    overflow: hidden;
    margin-bottom: 8px;
}

.stars { color: #f1c40f; margin-bottom: 8px; }

.price { font-size: 16px; margin-bottom: 10px; }

.old-price { text-decoration: line-through; color: #888; margin-right: 5px; }
.new-price { color: #e63946; font-weight: bold; }

/* ================= BRANDS CAROUSEL ================= */
.carousel-wrapper {
    overflow: hidden;
    position: relative;
}

.carousel {
    display: flex;
    gap: 20px;
    animation: scroll 25s linear infinite;
}

.carousel:hover {
    animation-play-state: paused;
}

/* 5 cards visible per viewport width */
.carousel .card {
    flex: 0 0 18%; /* approx 5 cards with gaps */
    min-width: 18%;
    background: #fff;
    padding: 15px;
    border-radius: 10px;
    text-align: center;
    box-shadow: 0 5px 15px rgba(0,0,0,0.05);
    transition: transform 0.3s;
}

.carousel .card:hover {
    transform: translateY(-5px);
}

.carousel .card img {
   
    height: 80px;
    display: flex;
    object-fit: contain;
    margin-bottom: 10px;
}

.carousel .card h4 {
    font-size: 14px;
    font-weight: 600;
    color: #333;
}
.section-title {
        font-size: 28px;
    font-weight: bold;
    margin-bottom: 10px;
    text-align: center;
}
.section-title-p {
       
    font-weight: bold;
    margin-bottom: 30px;
    text-align: center;
}
/* Smooth scroll animation */
@keyframes scroll {
    0% { transform: translateX(0); }
    100% { transform: translateX(-50%); }
}

/* Responsive adjustments */
@media (max-width: 1200px) { .carousel .card { flex: 0 0 22%; min-width: 22%; } } /* 4 cards */
@media (max-width: 992px) { .carousel .card { flex: 0 0 28%; min-width: 28%; } } /* 3 cards */
@media (max-width: 768px) { .carousel .card { flex: 0 0 45%; min-width: 45%; } } /* 2 cards */
@media (max-width: 576px) { .carousel .card { flex: 0 0 90%; min-width: 90%; } } /* 1 card */
</style>
@endsection

@section('content')
{{-- ================= HERO SLIDER ================= --}}
<div class="hero-slider" id="heroSlider">
    @foreach ($sliders as $key => $slider)
        <div class="slide {{ $key == 0 ? 'active' : '' }}">
            <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
            @if($slider->title)
            <div class="hero-text">
                <h2>{{ $slider->title }}<br>
                    @if($slider->subtitle)<small>{{ $slider->subtitle }}</small>@endif
                </h2>
            </div>
            @endif
        </div>
    @endforeach
    <button class="slider-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
    <button class="slider-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>
    <div class="slider-dots" id="sliderDots"></div>
</div>

{{-- ================= FILTER BAR ================= --}}
<div class="filter-bar">
    <select><option>Select Manufacturer</option></select>
    <select><option>Select Model</option></select>
    <select><option>Select Year</option></select>
    <button><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</div>

{{-- ================= CATEGORIES ================= --}}
<div class="categories">
    @forelse($categories as $category)
        <a href="{{ route('product.index', ['category' => $category->slug]) }}" class="category-card">
            <img src="{{ asset($category->image ?? 'images/default-category.png') }}" alt="{{ $category->name }}">
            <h4>{{ $category->name }}</h4>
        </a>
    @empty
        <p class="text-center">No categories available right now.</p>
    @endforelse
</div>



{{-- ================= NEW ARRIVALS ================= --}}
<section class="new-arrivals">
    <h2>NEW ARRIVALS</h2>
    <p>Check out our latest auto parts and accessories</p>
    <div class="product-grid">
        @forelse ($newArrivals as $product)
            <div class="product-card">
                <a href="{{ route('products.view', $product->slug) }}">
                    <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" alt="{{ $product->name }}">
                    <h3>{{ Str::limit($product->name, 40) }}</h3>
                </a>
                <div class="stars">★★★★☆</div>
                <p class="price">
                    @if($product->discount_price)
                        <span class="old-price">${{ number_format($product->price,2) }}</span>
                        <span class="new-price">${{ number_format($product->discount_price,2) }}</span>
                    @else
                        ${{ number_format($product->price,2) }}
                    @endif
                </p>
                <form action="{{ route('cart.add', $product->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn btn-orange open-cart">ADD TO CART</button>
                </form>
            </div>
        @empty
            <p>No products found.</p>
        @endforelse
    </div>
</section>

{{-- ================= BRANDS CAROUSEL ================= --}}
<section class="brands">
    <div class="container">
        <h2 class="section-title">Our Brands</h2>
        <p class="section-title-p">Check out our latest auto parts and accessories</p>

        <div class="carousel-wrapper">
            <div class="carousel">
                @foreach ($brands as $brand)
                    <div class="card">
                        <img src="{{ $brand->logo ? asset($brand->logo) : 'https://via.placeholder.com/80' }}" alt="{{ $brand->name }}">
                        <h4>{{ $brand->name }}</h4>
                    </div>
                @endforeach
                {{-- Duplicate for smooth scroll --}}
                @foreach ($brands as $brand)
                    <div class="card">
                        <img src="{{ $brand->logo ? asset($brand->logo) : 'https://via.placeholder.com/80' }}" alt="{{ $brand->name }}">
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

// Create dots
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

function nextSlide() { current = (current + 1) % slides.length; showSlide(current); }
function prevSlide() { current = (current - 1 + slides.length) % slides.length; showSlide(current); }
function goToSlide(i) { current = i; showSlide(current); }

setInterval(nextSlide, 5000);
document.querySelector('.next-btn').addEventListener('click', nextSlide);
document.querySelector('.prev-btn').addEventListener('click', prevSlide);
showSlide(current);
</script>
@endsection
