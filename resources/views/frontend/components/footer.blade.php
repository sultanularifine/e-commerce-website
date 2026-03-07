<footer class="bg-black border-t border-white/10 pt-20 pb-10 px-10 relative z-10">

@php
    $logo = \App\Models\FooterSetting::where('type','logo')->first();
    $menus = \App\Models\FooterSetting::where('type','menu')->where('status',1)->orderBy('order')->get();
    $socials = \App\Models\FooterSetting::where('type','social')->where('status',1)->get();
    $contact = \App\Models\FooterSetting::where('type','contact')->get();
    $footer_text = \App\Models\FooterSetting::where('type','text')->first();
@endphp

<div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-16 max-w-7xl mx-auto">

    {{-- LOGO + TEXT --}}
    <div class="col-span-1 md:col-span-1">

        <div class="mb-6">
            @if($logo && file_exists(public_path('uploads/footer/'.$logo->logo)))
                <img src="{{ asset('uploads/footer/'.$logo->logo) }}" style="height:30px;width:auto;">
            @else
                <img src="{{ asset('frontend/images/logo.png') }}" style="height:30px;width:auto;">
            @endif
        </div>

        <p class="text-gray-500 leading-relaxed text-sm">
            {{ $contact->where('name','address')->first()->value ?? 'Your address here' }}
        </p>

    </div>


    {{-- MENU --}}
    <div>

        <h4 class="font-bold mb-6 uppercase text-xs tracking-widest text-blue-500">
            Menu
        </h4>

        <ul class="text-gray-500 space-y-4 text-sm">

            @foreach ($menus as $menu)
                <li>
                    <a href="{{ $menu->value }}" class="hover:text-white transition">
                        {{ strtoupper($menu->name) }}
                    </a>
                </li>
            @endforeach

        </ul>

    </div>


    {{-- CONTACT --}}
    <div>

        <h4 class="font-bold mb-6 uppercase text-xs tracking-widest text-blue-500">
            Contact
        </h4>

        <ul class="text-gray-500 space-y-4 text-sm">

            <li>
                <a href="mailto:{{ $contact->where('name','email')->first()->value ?? '#' }}"
                   class="hover:text-white transition">
                    {{ $contact->where('name','email')->first()->value ?? 'contact@market.com' }}
                </a>
            </li>

            <li>
                <span class="hover:text-white transition">
                    {{ $contact->where('name','phone')->first()->value ?? '(000) 000 0000' }}
                </span>
            </li>

        </ul>

    </div>


    {{-- NEWSLETTER --}}
    <div>

        <h4 class="font-bold mb-6 uppercase text-xs tracking-widest text-blue-500">
            Newsletter
        </h4>

        <div class="flex">
            <input type="email"
                placeholder="Your email address"
                class="bg-white/5 border border-white/10 px-4 py-3 rounded-l-xl focus:outline-none focus:border-blue-500 w-full text-sm">

            <button class="bg-blue-600 px-6 py-3 rounded-r-xl hover:bg-blue-700 transition">
                ➤
            </button>
        </div>

    </div>

</div>


<div class="border-t border-white/5 pt-10 flex flex-col md:flex-row justify-between items-center text-gray-600 text-[10px] uppercase tracking-widest max-w-7xl mx-auto text-[15px]">

    <p>
        {!! $footer_text->value ?? '© 2025 Your Company. All rights reserved.' !!}
    </p>

    <div class="flex gap-8 mt-6 md:mt-0 text-2xl">

        @foreach ($socials as $social)
            <a href="{{ $social->value }}" target="_blank" class="hover:text-white transition">
                <i class="fab fa-{{ strtolower($social->name) }}"></i>
            </a>
        @endforeach

    </div>

</div>

</footer>