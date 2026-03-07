@extends('frontend.layouts.app')

@section('title', 'Search Results - Auto Parts Market')

@section('style')
<style>
    body {
        background: #000;
        color: #fff;
        font-family: 'Inter', sans-serif;
        overflow-x: hidden;
    }

    main {
        position: relative;
        z-index: 2;
        padding: 75px 15px;
        max-width: 1200px;
        margin: 0 auto;
    }

    h1 {
        font-size: 2.5rem;
        font-weight: 800;
        margin-bottom: 30px;
        border-left: 4px solid #3b82f6;
        padding-left: 12px;
        text-transform: uppercase;
        letter-spacing: 0.05em;
    }

    /* ================= Product Grid ================= */
    .product-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 25px;
    }

    .product-card {
        background: rgba(255,255,255,0.05);
        backdrop-filter: blur(15px);
        border-radius: 2rem;
        padding: 20px;
        text-align: center;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .product-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 20px 40px rgba(0,0,0,0.6);
    }

    .product-image-container {
        width: 100%;
        height: 200px;
        overflow: hidden;
        border-radius: 1.5rem;
        margin-bottom: 15px;
    }

    .product-image-container img {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: transform 0.5s ease;
    }

    .product-card:hover .product-image-container img {
        transform: scale(1.1);
    }

    .sale-tag {
        position: absolute;
        top: 10px;
        left: 10px;
        background: #ff5722;
        color: #fff;
        padding: 4px 8px;
        font-size: 0.75rem;
        font-weight: 700;
        border-radius: 6px;
    }

    .product-name {
        font-weight: 600;
        font-size: 1rem;
        margin-bottom: 8px;
        height: 2.5em;
        overflow: hidden;
    }

    .product-price {
        font-weight: 700;
        font-size: 1rem;
        color: #3b82f6;
    }

    .old-price {
        text-decoration: line-through;
        color: #999;
        font-size: 0.85rem;
        margin-left: 5px;
    }

    .btn-add-to-cart {
        margin-top: 10px;
        width: 100%;
        padding: 10px;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 0.75rem;
        border-radius: 1rem;
        border: 1px solid rgba(255,255,255,0.2);
        background: rgba(255,255,255,0.05);
        color: #fff;
        transition: background 0.3s ease, color 0.3s ease;
    }

    .btn-add-to-cart:hover {
        background: #3b82f6;
        color: #fff;
        border-color: #3b82f6;
    }

    /* ================= Responsive ================= */
    @media (max-width: 992px) {
        .product-grid {
            grid-template-columns: repeat(3, 1fr);
        }
    }

    @media (max-width: 768px) {
        .product-grid {
            grid-template-columns: repeat(2, 1fr);
        }
    }

    @media (max-width: 576px) {
        .product-grid {
            grid-template-columns: 1fr;
        }

        .product-image-container {
            height: 150px;
        }
    }

    /* ================= 3D BACKGROUND CANVAS ================= */
    #canvas-container {
        position: fixed;
        top:0;
        left:0;
        width:100%;
        height:100%;
        z-index:1;
    }
</style>
@endsection

@section('content')
<div id="canvas-container"></div>

<main>
    <h1>Search Results for: "{{ $query }}"</h1>

    @if ($products->count() > 0)
        <div class="product-grid">
            @foreach ($products as $product)
                <div class="product-card">
                    <a href="{{ route('products.view', $product->slug) }}">
                        <div class="product-image-container">
                            @if ($product->discount_price)
                                <span class="sale-tag">
                                    -{{ round((($product->price - $product->discount_price) / $product->price) * 100) }}%
                                </span>
                            @endif
                            <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" alt="{{ $product->name }}">
                        </div>
                        <h4 class="product-name">{{ $product->name }}</h4>
                        <p class="product-price">
                            ${{ number_format($product->discount_price ?? $product->price, 2) }}
                            @if ($product->discount_price)
                                <span class="old-price">${{ number_format($product->price, 2) }}</span>
                            @endif
                        </p>
                    </a>

                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                        @csrf
                        <input type="hidden" name="quantity" value="1">
                        <button type="submit" class="btn-add-to-cart">ADD TO CART</button>
                    </form>
                </div>
            @endforeach
        </div>

        <div class="pagination-wrapper d-flex justify-content-center flex-wrap mt-6">
            {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
        </div>
    @else
        <p>No products found matching your search.</p>
    @endif
</main>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r148/three.min.js"></script>
<script>
    // ================= 3D FLOATING BACKGROUND =================
    let scene, camera, renderer, stars;

    function init3D() {
        scene = new THREE.Scene();

        camera = new THREE.PerspectiveCamera(75, window.innerWidth / window.innerHeight, 0.1, 1000);
        camera.position.z = 50;

        renderer = new THREE.WebGLRenderer({ alpha: true, antialias: true });
        renderer.setSize(window.innerWidth, window.innerHeight);
        renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
        document.getElementById('canvas-container').appendChild(renderer.domElement);

        const starGeometry = new THREE.BufferGeometry();
        const starCount = 1000;
        const positions = [];

        for (let i=0; i<starCount; i++){
            positions.push((Math.random()-0.5)*200);
            positions.push((Math.random()-0.5)*200);
            positions.push((Math.random()-0.5)*200);
        }

        starGeometry.setAttribute('position', new THREE.Float32BufferAttribute(positions, 3));
        const starMaterial = new THREE.PointsMaterial({ color: 0x3b82f6, size: 0.5 });
        stars = new THREE.Points(starGeometry, starMaterial);
        scene.add(stars);
    }

    function animate3D() {
        requestAnimationFrame(animate3D);
        stars.rotation.y += 0.0005;
        stars.rotation.x += 0.0002;
        renderer.render(scene, camera);
    }

    window.addEventListener('resize', () => {
        camera.aspect = window.innerWidth / window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });

    init3D();
    animate3D();
</script>
@endsection