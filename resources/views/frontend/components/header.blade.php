{{-- ================= NAVBAR ================= --}}
<nav class="fixed top-0 left-0 w-full z-50 glass px-6 md:px-12 py-3 flex flex-col">

    {{-- ===== TOP BAR ===== --}}
    <div class="flex justify-between items-center text-xs mb-2">

        {{-- Social --}}
        <div class="flex gap-4">
            @foreach (\App\Models\HeaderSetting::where('type','social')->where('status',1)->orderBy('order')->get() as $social)
                <a href="{{ $social->value }}" class="opacity-70 hover:opacity-100 transition">
                    <i class="{{ $social->icon }}"></i>
                </a>
            @endforeach
        </div>

        {{-- Contact --}}
        <div class="hidden md:flex gap-6">
            @foreach (\App\Models\HeaderSetting::where('type','contact')->where('status',1)->orderBy('order')->get() as $contact)
                <span class="flex items-center gap-2">
                    <i class="{{ $contact->icon }}"></i>
                    <span class="call">{{ $contact->value }}</span>
                </span>
            @endforeach
        </div>

        {{-- Right Icons --}}
        <div class="flex items-center gap-6">

            <a href="{{ route('dashboard') }}">
                <i class="fa-solid fa-user"></i>
            </a>

            <a href="{{ route('cart.index') }}" class="relative">
                <i class="fa-solid fa-cart-shopping"></i>

                @if (session('cart') && count(session('cart')) > 0)
                    <span class="absolute -top-2 -right-3 bg-blue-500 text-white text-[10px] px-1.5 py-0.5 rounded-full">
                        {{ count(session('cart')) }}
                    </span>
                @endif
            </a>

        </div>
    </div>


    {{-- ===== MAIN NAVBAR ===== --}}
    <div class="flex justify-between items-center">

        {{-- Logo --}}
        <a href="{{ route('home') }}">
            @php
                $logo = \App\Models\FooterSetting::where('type','logo')->first();
            @endphp

            <div class="text-2xl font-black tracking-tighter italic flex items-center gap-2">

                @if ($logo && file_exists(public_path('uploads/footer/'.$logo->logo)))
                    <img src="{{ asset('uploads/footer/'.$logo->logo) }}" style="height:30px;width:auto;">
                @else
                    <img src="{{ asset('frontend/images/logo.png') }}" style="height:30px;width:auto;">
                @endif

            </div>
        </a>


        {{-- Menu --}}
        <div class="hidden md:flex gap-10 text-xs uppercase tracking-widest font-bold">

            @foreach (\App\Models\HeaderSetting::where('type','menu')->where('status',1)->orderBy('order')->get() as $menu)
                <a href="{{ $menu->value }}" class="nav-link transition">
                    {{ $menu->name }}
                </a>
            @endforeach

        </div>


        {{-- Right Section --}}
        <div class="flex items-center gap-6">

            {{-- Search --}}
            <form action="{{ route('search') }}" method="GET" class="hidden md:flex items-center border border-white/20 rounded-full px-3 py-1">
                <input type="text" name="query" placeholder="Search..." required
                       class="bg-transparent outline-none text-xs px-2">
                <button type="submit">
                    <i class="fas fa-search"></i>
                </button>
            </form>

            {{-- Hamburger --}}
            <button id="hamburger" class="md:hidden text-xl">
                <i class="fas fa-bars"></i>
            </button>

        </div>

    </div>


   {{-- ===== MOBILE MENU ===== --}}
<div id="navLinks" class="mobile-menu md:hidden">

    <div class="mobile-content">
        @foreach (\App\Models\HeaderSetting::where('type','menu')->where('status',1)->orderBy('order')->get() as $menu)
            <a href="{{ $menu->value }}" class="mobile-link transition">
                {{ $menu->name }}
            </a>
        @endforeach
    </div>

</div>

</nav>
<style>
    /* Mobile dropdown */
.mobile-menu {
    max-height: 0;
    overflow: hidden;
    transition: max-height 0.4s ease, opacity 0.4s ease;
    background: rgba(0,0,0,0.95);
    backdrop-filter: blur(15px);
    border-top: 1px solid rgba(255,255,255,0.1);
    width: 100%;
}

.mobile-menu.open {
    max-height: 500px; /* Adjust based on number of links */
}

.mobile-content {
    display: flex;
    flex-direction: column;
    padding: 15px 20px;
    gap: 10px;
}

.mobile-link {
    padding: 12px 15px;
    font-size: 14px;
    letter-spacing: 1px;
    border-radius: 8px;
    transition: all 0.3s;
    color: #fff;
}

.mobile-link:hover {
    background: rgba(59, 130, 246, 0.2); /* subtle blue highlight */
    padding-left: 20px;
    color: #3b82f6; /* Tailwind blue-500 */
}
</style>

<script>
const hamburger = document.getElementById('hamburger');
const navLinks = document.getElementById('navLinks');

hamburger.addEventListener('click', () => {
    navLinks.classList.toggle('open');

    hamburger.innerHTML =
        navLinks.classList.contains('open')
        ? '<i class="fas fa-times"></i>'
        : '<i class="fas fa-bars"></i>';
});
</script>