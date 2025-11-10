<!-- TOP BAR -->

<div class="top-bar">
    <div class="social">
        @foreach (\App\Models\HeaderSetting::where('type', 'social')->where('status', 1)->orderBy('order')->get() as $social)
            <a href="{{ $social->value }}"><i class="{{ $social->icon }}"></i></a>
        @endforeach
    </div>
    <div class="contact">
        @foreach (\App\Models\HeaderSetting::where('type', 'contact')->where('status', 1)->orderBy('order')->get() as $contact)
            <i class="{{ $contact->icon }}"></i> <span class="call">{{ $contact->value }}</span>
        @endforeach
    </div>
    <div class="right-icons">
        <a href="{{ route('dashboard') }}"><i class="fa-solid fa-user"></i></a>
        <a href="{{ route('cart.index') }}" class="cart-link">
            <i class="fa-solid fa-cart-shopping"></i>
            @if (session('cart') && count(session('cart')) > 0)
                <span class="cart-count">{{ count(session('cart')) }}</span>
            @endif
        </a>
    </div>
</div>

<!-- NAVBAR -->
<div class="navbar">
    <a href="{{ route('home') }}">
        @php
            $logo = \App\Models\FooterSetting::where('type', 'logo')->first();
        @endphp

        <div class="logo">
            @if ($logo && file_exists(public_path('uploads/footer/' . $logo->logo)))
                <img src="{{ asset('uploads/footer/' . $logo->logo) }}" alt="Market Logo"
                    style="height:30px; width:auto; vertical-align:middle;">
            @else
                <img src="{{ asset('frontend/images/logo.png') }}" alt="Default Logo"
                    style="height:30px; width:auto; vertical-align:middle;">
            @endif
        </div>
    </a>
    <div class="hamburger" id="hamburger">
        <i class="fas fa-bars"></i>
    </div>
    <ul class="nav-links" id="navLinks">
        @foreach (\App\Models\HeaderSetting::where('type', 'menu')->where('status', 1)->orderBy('order')->get() as $menu)
            <li><a href="{{ $menu->value }}">{{ $menu->name }}</a></li>
        @endforeach
    </ul>

   <div class="nav-right">
    <form action="{{ route('search') }}" method="GET" class="search-form">
        <input type="text" name="query" class="search" placeholder="Search..." required>
        <button type="submit"><i class="fas fa-search btn-design"></i></button>
    </form>
</div>

</div>

<script>
    const hamburger = document.getElementById('hamburger');
    const navLinks = document.getElementById('navLinks');

    hamburger.addEventListener('click', () => {
        navLinks.classList.toggle('active');
        hamburger.innerHTML = navLinks.classList.contains('active') ? '<i class="fas fa-times"></i>' :
            '<i class="fas fa-bars"></i>';
    });
</script>
