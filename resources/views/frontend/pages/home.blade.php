@extends('frontend.layouts.app')

@section('title', 'Home - Auto Parts Market')

@section('style')

@endsection

@section('content')

{{-- ✅ HERO SLIDER --}}
<div class="hero-slider" id="heroSlider">
  <div class="slide active">
    <img src="https://magento2.magentech.com/themes/sm_marketnew/pub/media/wysiwyg/slidershow/home-24/item-1.jpg" alt="">
    <div class="hero-text"><h2>NEW ARRIVAL <br><small>ACCESSORIES & PARTS</small></h2></div>
  </div>
  <div class="slide">
    <img src="https://magento2.magentech.com/themes/sm_marketnew/pub/media/wysiwyg/slidershow/home-24/item-2.jpg" alt="">
    <div class="hero-text"><h2>SALE UPTO 50% <br><small>CAR LIGHTS & TIRES</small></h2></div>
  </div>
  <div class="slide">
    <img src="https://magento2.magentech.com/themes/sm_marketnew/pub/media/wysiwyg/slidershow/home-24/item-3.jpg" alt="">
    <div class="hero-text"><h2>SPECIAL OFFER <br><small>ACCESSORIES SALE 70% OFF</small></h2></div>
  </div>

  <button class="slider-btn prev-btn"><i class="fa-solid fa-chevron-left"></i></button>
  <button class="slider-btn next-btn"><i class="fa-solid fa-chevron-right"></i></button>
  <div class="slider-dots" id="sliderDots"></div>
</div>

{{-- ✅ FILTER BAR --}}
<div class="filter-bar">
  <select><option>Select Manufacturer</option></select>
  <select><option>Select Model</option></select>
  <select><option>Select Year</option></select>
  <button><i class="fa-solid fa-magnifying-glass"></i> Search</button>
</div>

{{-- ✅ CATEGORIES --}}
<div class="categories">
  <div class="category-card"><img src="https://cdn-icons-png.flaticon.com/512/482/482226.png"><h4>Tires & Wheels</h4></div>
  <div class="category-card"><img src="https://cdn-icons-png.flaticon.com/512/866/866218.png"><h4>Components</h4></div>
  <div class="category-card active"><img src="https://cdn-icons-png.flaticon.com/512/476/476863.png"><h4>Steering Wheel</h4></div>
  <div class="category-card"><img src="https://cdn-icons-png.flaticon.com/512/489/489567.png"><h4>Sport Brake</h4></div>
</div>

<!-- new arivals -->
<section class="new-arrivals">
  <h2>NEW ARRIVALS</h2>
  <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>

  <div class="product-grid">
    <div class="product-card">
      <img src="https://fastradius.com/wp-content/uploads/2022/10/autos-2880-1025x576.jpg" alt="">
      <h3>20X9 WHEELS FIT GMC CHEVY GRAY COLOR</h3>
      <div class="stars">★★★★☆</div>
      <p class="price">$610.00</p>
      <button class="btn">ADD TO CART</button>
    </div>

    <div class="product-card">
      <img src="https://fastradius.com/wp-content/uploads/2022/10/autos-2880-1025x576.jpg" alt="">
      <h3>22-5 HOLE ALUMINUM WHEEL FRONT LIGHT</h3>
      <div class="stars">★★★★☆</div>
      <p class="price">$340.00</p>
      <button class="btn">ADD TO CART</button>
    </div>

    <div class="product-card">
      <img src="https://fastradius.com/wp-content/uploads/2022/10/autos-2880-1025x576.jpg" alt="">
      <h3>BLUETOOTH V4.2 RADIO ADAPTER</h3>
      <div class="stars">★★★★☆</div>
      <p class="price">$245.00</p>
      <button class="btn">ADD TO CART</button>
    </div>

    <div class="product-card">
      <img src="https://fastradius.com/wp-content/uploads/2022/10/autos-2880-1025x576.jpg" alt="">
      <h3>OUT YOUR HALOGEN LIGHT BLACK</h3>
      <div class="stars">★★★★★</div>
      <p class="price">$230.00</p>
      <button class="btn">ADD TO CART</button>
    </div>

    <div class="product-card">
      <img src="https://fastradius.com/wp-content/uploads/2022/10/autos-2880-1025x576.jpg" alt="">
      <h3>DISCOUNT STARTER AND ALTERNATOR</h3>
      <div class="stars">★★★★☆</div>
      <p class="price">$455.00</p>
      <button class="btn">ADD TO CART</button>
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

  function nextSlide() { current = (current + 1) % slides.length; showSlide(current); }
  function prevSlide() { current = (current - 1 + slides.length) % slides.length; showSlide(current); }
  function goToSlide(i) { current = i; showSlide(current); }

  setInterval(nextSlide, 5000);
  document.querySelector('.next-btn').addEventListener('click', nextSlide);
  document.querySelector('.prev-btn').addEventListener('click', prevSlide);
  showSlide(current);
</script>
@endsection
