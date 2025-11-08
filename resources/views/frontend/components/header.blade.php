<!-- TOP BAR -->

<div class="top-bar">
    <div class="social">
        @foreach(\App\Models\HeaderSetting::where('type', 'social')->where('status', 1)->orderBy('order')->get() as $social)
            <a href="{{ $social->value }}"><i class="{{ $social->icon }}"></i></a>
        @endforeach
    </div>
    <div class="contact">
        @foreach(\App\Models\HeaderSetting::where('type', 'contact')->where('status', 1)->orderBy('order')->get() as $contact)
            <i class="{{ $contact->icon }}"></i> <span class="call">{{ $contact->value }}</span>
        @endforeach
    </div>
    <div class="right-icons">
        <a href="{{ route('login') }}"><i class="fa-solid fa-user"></i></a>
        <a href="{{ route('cart') }}"><i class="fa-solid fa-cart-shopping"></i></a>
    </div>
</div>

<!-- NAVBAR -->
<div class="navbar">
   <a href="{{ route('home') }}">
        <div class="logo">
            <img src="{{ asset('frontend/images/logo.png') }}" alt="Market Logo" style="height:30px; width:auto; vertical-align:middle;">
           
        </div>
    </a>
   
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="nav-links" id="navLinks">
        @foreach(\App\Models\HeaderSetting::where('type', 'menu')->where('status', 1)->orderBy('order')->get() as $menu)
            <li><a href="{{ $menu->value }}">{{ $menu->name }}</a></li>
        @endforeach
    </ul>
    <div class="nav-right">
        <input type="text" class="search" placeholder="Search...">
    </div>
</div>

<script>
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('active');
    hamburger.innerHTML = navLinks.classList.contains('active') ? '<i class="fas fa-times"></i>' : '<i class="fas fa-bars"></i>';
});
</script>
