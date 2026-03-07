@extends('frontend.layouts.app')

@section('title', 'Home - Auto Parts Market')

@section('style')
    <style>
        body {
            margin: 0;
            background: #000;
            color: white;
            font-family: 'Inter', sans-serif;
            overflow-x: hidden;
        }

        section {
            min-height: 100vh;
            display: flex;
            align-items: center;
            padding: 0 5%;
            position: relative;
            z-index: 2;
        }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            color: transparent;
        }

        /* HERO SLIDER */
        .slider {
            width: 100%;
            display: flex;
        }

        .slide {
            flex-shrink: 0;
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .slide img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        /* HERO IMAGE BOX */
        .flex-none {
            width: 100%;
            max-width: 600px;
            height: 400px;
            position: relative;
        }

        /* ================= MOBILE ================= */
        @media(max-width:768px) {

            section {
                flex-direction: column;
                text-align: center;
                padding: 40px 20px;
            }

            .flex-1 {
                width: 100% !important;
            }

            /* MOBILE HIDE SLIDER BUT PRESERVE SPACE */
            .flex-none {
                display: block;
                /* block রাখুন যাতে height থাকে */
                height: 200px;
                /* Mobile এর জন্য height preserve */
                overflow: hidden;
                /* content hidden */
            }

            .flex-none .slider,
            .flex-none .prev-btn,
            .flex-none .next-btn,
            .flex-none .dots {
                /* display: none; */
                /* slides, buttons, dots hide */
            }

            /* OPTIONAL: placeholder background to show space */
            .flex-none::before {
                content: "";
                /* display: block; */
                width: 100%;
                height: 100%;
                background-color: rgba(255, 255, 255, 0.05);
                border-radius: 1rem;
            }

            h3 {
                font-size: 2.2rem !important;
                line-height: 1.2;
            }

            #heroSubtitle {
                font-size: 0.95rem !important;
                margin: auto;
            }

            button {
                margin-top: 20px;
            }

        }

        /* SMALL MOBILE */
        @media(max-width:480px) {
            h3 {
                font-size: 1.8rem !important;
            }

            #heroSubtitle {
                font-size: 0.85rem !important;
            }
        }
    </style>
@endsection

@section('content')
    <div id="canvas-container" class="absolute top-0 left-0 w-full h-full z-0"></div>

    <section class="relative text-white py-20 z-10" style="margin-top:30px;">
        <div class="max-w-7xl mx-auto px-6 flex flex-col md:flex-row items-center gap-10">

            <!-- TEXT AREA -->
            <div class="flex-1">
                @if ($sliders->count() > 0)
                    @php $firstSlider = $sliders->first(); @endphp
                    @if ($firstSlider->title)
                        <span class="text-blue-500 font-mono tracking-[0.3em] uppercase text-sm">
                            Now Available
                        </span>
                        <h3 id="heroTitle" class="text-5xl md:text-7xl font-black mb-4 leading-none">
                            {{ $firstSlider->title }}
                        </h3>
                    @endif

                    @if ($firstSlider->subtitle)
                        <p id="heroSubtitle" class="text-gray-400 text-lg md:text-xl max-w-md">
                            {{ $firstSlider->subtitle }}
                        </p>
                    @endif

                    <button class="mt-8 bg-blue-600 hover:bg-blue-500 px-8 py-4 rounded-full font-bold transition">
                        Explore 3D Build
                    </button>
                @endif
            </div>

            <!-- SLIDER IMAGE -->
            <div class="flex-none relative ">
                <div class="relative overflow-hidden rounded-2xl shadow-lg w-full h-full">
                    <div class="slider flex transition-transform duration-500 ease-in-out h-full">
                        @foreach ($sliders as $slider)
                            <div class="slide flex-shrink-0 w-full h-full" data-title="{{ $slider->title }}"
                                data-subtitle="{{ $slider->subtitle }}">
                                <img src="{{ asset($slider->image) }}" alt="{{ $slider->title }}">
                            </div>
                        @endforeach
                    </div>

                    <!-- BUTTONS -->
                    <button
                        class="absolute top-1/2 left-2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full prev-btn">
                        &#10094;
                    </button>
                    <button
                        class="absolute top-1/2 right-2 transform -translate-y-1/2 bg-black/50 text-white p-2 rounded-full next-btn">
                        &#10095;
                    </button>

                    <!-- DOTS -->
                    <div class="absolute bottom-4 left-1/2 transform -translate-x-1/2 flex gap-2 dots"></div>
                </div>
            </div>

        </div>
    </section>

    {{-- ================= CATEGORIES ================= --}}
    <section class="flex-col justify-center py-20">
        <h2 class="text-4xl font-bold mb-12 border-l-4 border-blue-500 pl-6 uppercase tracking-tighter">
            Product Categories
        </h2>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 w-full max-w-6xl">
            @forelse($categories as $category)
                <a href="{{ route('product.index', ['category' => $category->slug]) }}"
                    class="glass p-8 rounded-3xl group hover:bg-white/5 transition cursor-pointer">
                    <div
                        class="h-32 mb-6 bg-blue-500/10 rounded-2xl flex items-center justify-center group-hover:scale-105 transition overflow-hidden">
                        <img src="{{ asset($category->image ?? 'images/default-category.png') }}"
                            alt="{{ $category->name }}"
                            class="h-full w-full object-cover opacity-90 group-hover:scale-110 transition duration-500">
                    </div>
                    <h3 class="text-xl font-bold">{{ $category->name }}</h3>
                    <p class="text-gray-500 text-sm mt-2">Explore our {{ $category->name }} collection.</p>
                </a>
            @empty
                <p class="text-center col-span-3 text-gray-500">No categories available right now.</p>
            @endforelse
        </div>
    </section>

    {{-- ================= NEW PRODUCTS ================= --}}
    <section class="flex-col justify-center items-center py-20">
        <div class="text-center mb-16">
            <h2 class="text-5xl font-black uppercase tracking-tighter italic">
                Our New <span
                    class="text-gradient bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">Products</span>
            </h2>
            <p class="text-gray-500 mt-4 tracking-widest font-mono text-sm uppercase">
                Engineered for the Next Gen
            </p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 w-full max-w-7xl">
            @forelse ($newArrivals as $product)
                <div
                    class="product-card glass p-6 rounded-[2rem] transition duration-500 flex flex-col items-center text-center">
                    <div
                        class="w-full aspect-square bg-gradient-to-b from-blue-500/20 to-transparent rounded-2xl mb-6 flex items-center justify-center overflow-hidden">
                        <a href="{{ route('products.view', $product->slug) }}">
                            <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" alt="{{ $product->name }}"
                                class="opacity-80 hover:scale-110 transition duration-500">
                        </a>
                    </div>
                    <a href="{{ route('products.view', $product->slug) }}">
                        <h4 class="text-lg font-bold">{{ Str::limit($product->name, 40) }}</h4>
                    </a>
                    <p class="text-blue-400 font-mono text-sm mb-4">
                        @if ($product->discount_price)
                            <span class="line-through text-gray-400 mr-2">${{ number_format($product->price, 2) }}</span>
                            ${{ number_format($product->discount_price, 2) }}
                        @else
                            ${{ number_format($product->price, 2) }}
                        @endif
                    </p>
                    <form action="{{ route('cart.add', $product->id) }}" method="POST" class="w-full">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit"
                            class="w-full py-3 bg-white/10 hover:bg-white hover:text-black rounded-xl transition text-xs font-bold uppercase tracking-widest border border-white/10">
                            Add to Cart
                        </button>
                    </form>
                </div>
            @empty
                <p class="text-center col-span-4 text-gray-500">No products found.</p>
            @endforelse
        </div>
    </section>

    {{-- ================= BRANDS CAROUSEL ================= --}}
    <section class="flex-col h-auto py-32 bg-gradient-to-b from-transparent via-blue-900/10 to-transparent">
        <p class="text-center text-gray-500 uppercase tracking-[0.5em] text-xs mb-16">
            Global Manufacturing Partners
        </p>
        <div
            class="flex flex-wrap justify-center gap-12 md:gap-24 opacity-30 grayscale hover:opacity-100 transition duration-700">
            @foreach ($brands as $brand)
                <div class="flex flex-col items-center">
                    <img src="{{ $brand->logo ? asset($brand->logo) : 'https://via.placeholder.com/80' }}"
                        alt="{{ $brand->name }}" class="h-12 mb-2 object-contain">
                    <span class="text-4xl font-black italic tracking-tighter">{{ $brand->name }}</span>
                </div>
            @endforeach
        </div>
    </section>
@endsection

@section('scripts')
    <script>
        // --- THREE.JS ENGINE ---
        let scene, camera, renderer, product;
        let scrollY = window.scrollY;

        function init() {
            scene = new THREE.Scene();
            camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);

            renderer = new THREE.WebGLRenderer({
                antialias: true,
                alpha: true
            });
            renderer.setSize(window.innerWidth, window.innerHeight);
            renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
            document.getElementById('canvas-container').appendChild(renderer.domElement);

            const geometry = new THREE.IcosahedronGeometry(2, 0);
            const material = new THREE.MeshPhysicalMaterial({
                color: 0x3b82f6,
                wireframe: true,
                roughness: 0.1,
                metalness: 0.8
            });
            product = new THREE.Group();
            const mesh = new THREE.Mesh(geometry, material);
            product.add(mesh);
            scene.add(product);

            const light1 = new THREE.PointLight(0x6366f1, 15);
            light1.position.set(5, 5, 5);
            scene.add(light1);

            const light2 = new THREE.PointLight(0xa855f7, 10);
            light2.position.set(-5, -5, 5);
            scene.add(light2);

            camera.position.z = 6;
        }

        window.addEventListener('scroll', () => {
            scrollY = window.scrollY;
            const sectionHeight = window.innerHeight;

            if (scrollY < sectionHeight) {
                product.position.x = (scrollY / sectionHeight) * 2;
                product.scale.set(1, 1, 1);
            } else if (scrollY >= sectionHeight && scrollY < sectionHeight * 2) {
                product.position.x = 2 - ((scrollY - sectionHeight) / sectionHeight) * 4;
                product.rotation.z = (scrollY / sectionHeight);
            }
        });

        function animate() {
            requestAnimationFrame(animate);
            product.rotation.y += 0.005;
            product.rotation.x += 0.002;
            product.position.y = scrollY * 0.0005;
            renderer.render(scene, camera);
        }

        window.addEventListener('resize', () => {
            camera.aspect = window.innerWidth / window.innerHeight;
            camera.updateProjectionMatrix();
            renderer.setSize(window.innerWidth, window.innerHeight);
        });

        init();
        animate();
    </script>

    <script>
        // --- HERO SLIDER ---
        const heroSlider = document.querySelector('.slider');
        const heroSlides = heroSlider.children;
        const nextBtn = document.querySelector('.next-btn');
        const prevBtn = document.querySelector('.prev-btn');
        const dotsContainer = document.querySelector('.dots');

        const heroTitle = document.getElementById('heroTitle');
        const heroSubtitle = document.getElementById('heroSubtitle');
        let currentIndex = 0;

        function updateText(index) {
            const slide = heroSlides[index];
            heroTitle.innerHTML = slide.dataset.title +
                ' <span class="text-gradient bg-gradient-to-r from-blue-400 to-purple-600 bg-clip-text text-transparent">V9</span>';
            heroSubtitle.innerHTML = slide.dataset.subtitle ? slide.dataset.subtitle +
                " The world's first spatial audio headset rendered in real-time 3D." : '';
        }

        for (let i = 0; i < heroSlides.length; i++) {
            const dot = document.createElement('span');
            dot.classList.add('w-3', 'h-3', 'bg-white', 'rounded-full', 'opacity-50', 'cursor-pointer');
            if (i === 0) dot.classList.add('opacity-100');
            dot.addEventListener('click', () => goToSlide(i));
            dotsContainer.appendChild(dot);
        }

        const dots = dotsContainer.children;

        function goToSlide(index) {
            heroSlider.style.transform = `translateX(-${index*100}%)`;
            dots[currentIndex].classList.remove('opacity-100');
            dots[currentIndex].classList.add('opacity-50');
            currentIndex = index;
            dots[currentIndex].classList.add('opacity-100');
            dots[currentIndex].classList.remove('opacity-50');
            updateText(index);
        }

        nextBtn.addEventListener('click', () => {
            let next = (currentIndex + 1) % heroSlides.length;
            goToSlide(next);
        });

        prevBtn.addEventListener('click', () => {
            let prev = (currentIndex - 1 + heroSlides.length) % heroSlides.length;
            goToSlide(prev);
        });

        setInterval(() => {
            nextBtn.click();
        }, 5000);
        updateText(0);
    </script>
@endsection
