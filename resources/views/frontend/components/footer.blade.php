<footer class="market-footer">
    <div class="market-footer-top">
        <!-- Logo -->
        @php
            $logo = \App\Models\FooterSetting::where('type', 'logo')->first();
            $menus = \App\Models\FooterSetting::where('type', 'menu')->where('status', 1)->orderBy('order')->get();
            $socials = \App\Models\FooterSetting::where('type', 'social')->where('status', 1)->get();
            $contact = \App\Models\FooterSetting::where('type', 'contact')->get();
            $footer_text = \App\Models\FooterSetting::where('type', 'text')->first();
        @endphp

        <div class="market-footer-logo">
            @if($logo && file_exists(public_path('uploads/footer/' . $logo->logo)))
        <img src="{{ asset('uploads/footer/' . $logo->logo) }}" alt="Market Logo"
             style="height:30px; width:auto; vertical-align:middle;">
    @else
        <img src="{{ asset('frontend/images/logo.png') }}" alt="Default Logo"
             style="height:30px; width:auto; vertical-align:middle;">
    @endif
        </div>


        <!-- Menu -->
        <ul class="market-footer-menu">
            @foreach ($menus as $menu)
                <li><a href="{{ $menu->value }}">{{ strtoupper($menu->name) }}</a></li>
            @endforeach
        </ul>

        <!-- Newsletter -->
        <div class="market-footer-newsletter">
            <input type="email" placeholder="Your email address">
            <button>➤</button>
        </div>
    </div>

    <hr class="market-footer-divider">

    <div class="market-footer-bottom">
        <div>
            <p>
                {{ $contact->where('name', 'address')->first()->value ?? 'Your address here' }} -
                <a href="mailto:{{ $contact->where('name', 'email')->first()->value ?? '#' }}">
                    {{ $contact->where('name', 'email')->first()->value ?? 'contact@market.com' }}
                </a> -
                {{ $contact->where('name', 'phone')->first()->value ?? '(000) 000 0000' }}
            </p>
            <p>{!! $footer_text->value ?? '© 2025 Your Company. All rights reserved.' !!}</p>
        </div>

        <div class="market-footer-social">
            @foreach ($socials as $social)
                <a href="{{ $social->value }}" target="_blank">
                    <i class="fab fa-{{ strtolower($social->name) }}"></i>
                </a>
            @endforeach
        </div>
    </div>
</footer>
