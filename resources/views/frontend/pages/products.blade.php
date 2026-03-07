@extends('frontend.layouts.app')

@section('title', 'All Products - Auto Parts Market')

@section('style')
<style>
body {
    background: #000;
    color: white;
    font-family: 'Inter', sans-serif;
    overflow-x: hidden;
    position: relative;
}

main {
    margin-top: 40px;
    padding: 20px;
    max-width: 1300px;
    margin-left: auto;
    margin-right: auto;
    position: relative;
    z-index: 2;
}

/* Animated background container */
#bgCanvas {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    z-index: 0;
}

/* Header */
h1 {
    font-size: 3rem;
    font-weight: 800;
    border-left: 4px solid #3b82f6;
    padding-left: 15px;
    margin-bottom: 40px;
    text-transform: uppercase;
}

  .sidebar {
        flex: 0 0 280px;
        position: sticky;
        top: 150px;
        height: max-content;
        background: #111;
        padding: 20px;
        border-radius: 20px;
    }

    .sidebar h3 {
        font-size: 16px;
        font-weight: 700;
        margin-bottom: 10px;
        border-bottom: 1px solid #333;
        padding-bottom: 5px;
        text-transform: uppercase;
        color: #fff;
    }

.filter-list a {
    color: #9ca3af;
    display: block;
    padding: 5px 0;
    font-size: 14px;
    transition: 0.3s;
}

.filter-list a:hover {
    color: white;
}

/* Product Grid */
.product-grid {
    display: grid;
    grid-template-columns: repeat(4,1fr);
    gap: 20px;
    perspective: 1500px;
}

.product-card {
    background: rgba(255,255,255,0.03);
    border-radius: 2rem;
    padding: 15px;
    text-align: center;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(20px);
    cursor: pointer;
}

.product-card:hover {
    transform: rotateX(10deg) rotateY(10deg) translateY(-5px);
    box-shadow: 0 0 40px rgba(59,130,246,0.8);
}

.product-image-container {
    width: 100%;
    height: 200px;
    border-radius: 1rem;
    overflow: hidden;
    position: relative;
    margin-bottom: 10px;
    transform-style: preserve-3d;
}

.product-image-container img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform 0.5s;
}

.product-card:hover .product-image-container img {
    transform: rotateY(15deg) rotateX(10deg) scale(1.1);
}

.product-name {
    font-size: 14px;
    font-weight: 600;
    height: 3em;
    overflow: hidden;
    margin-bottom: 5px;
}

.product-price {
    font-weight: 700;
    color: #3b82f6;
    margin-bottom: 10px;
}

.sale-tag {
    position: absolute;
    top: 10px;
    left: 10px;
    background: #2563eb;
    padding: 4px 6px;
    font-size: 12px;
    border-radius: 6px;
}

.old-price {
    text-decoration: line-through;
    color: #777;
    font-size: 12px;
    margin-left: 5px;
}

/* Button Style */
.btn-add-to-cart {
    background: linear-gradient(135deg, #3b82f6, #2563eb);
    border: none;
    padding: 6px;
    width: 100%;
    border-radius: .5rem;
    font-weight: 700;
    cursor: pointer;
    text-transform: uppercase;
    letter-spacing: 1px;
    color: white;
    box-shadow: 0 0 20px rgba(59,130,246,0.5);
    transition: 0.3s;
}
.btn-add-to-cart:hover {
    box-shadow: 0 0 40px rgba(59,130,246,0.9);
    transform: translateY(-3px) scale(1.02);
}

/* Pagination */
.pagination-wrapper {
    margin-top: 40px;
    display: flex;
    justify-content: center;
}
/* ===== Desktop Layout ===== */
.listing-layout {
    display: flex;
    gap: 30px;
}

/* Sidebar fixed on side */
.sidebar {
    flex: 0 0 250px; /* fixed width */
    position: sticky;
    top: 100px; /* distance from top while scrolling */
    height: max-content;
}

.product-listing {
    flex: 1; /* takes remaining space */
}

/* ===== Mobile Layout ===== */
@media (max-width: 768px) {
    .listing-layout {
        display: block; /* stack vertically */
    }

    .sidebar {
        position: relative; /* sticky disabled on mobile */
        top: auto;
        width: 100%;
        margin-bottom: 20px;
    }

    .product-listing {
        width: 100%;
    }
    .product-card {
    background: rgba(255,255,255,0.03);
    border-radius: 2rem;
    padding: 25px;
    text-align: center;
    position: relative;
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(20px);
    cursor: pointer;
}

    .product-grid {
        grid-template-columns: repeat(2, 1fr); /* 2 columns on tablet/mobile */
        gap: 15px;
    }

}

@media (max-width: 480px) {
    .product-grid {
        grid-template-columns: 1fr; /* single column on small mobile */
        gap: 10px;
    }
}

/* Responsive */
@media(max-width:1000px){
    .product-grid{
        grid-template-columns:repeat(3,1fr);
    }
}
@media(max-width:768px){
    .listing-layout{
        grid-template-columns:1fr;
    }

    .product-grid{
        grid-template-columns:repeat(1,1fr);
    }
}
@media(max-width:600px){
    .product-image-container{
        height: 150px;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>
<main>
    <h1>ALL PRODUCTS</h1>

    <div class="listing-layout">
        {{-- Sidebar --}}
        <aside class="sidebar">
            <div class="filter-section filter-categories">
                <h3>CATEGORIES</h3>
                <ul class="filter-list">
                    @foreach ($categories as $category)
                        <li>
                            <a href="{{ route('product.index', ['category' => $category->slug]) }}">
                                {{ $category->name }} ({{ $category->products->count() }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="filter-section filter-brands">
                <h3>BRANDS</h3>
                <ul class="filter-list">
                    @foreach ($brands as $brand)
                        <li>
                            <a href="{{ route('product.index', ['brand' => $brand->slug]) }}">
                                {{ $brand->name }} ({{ $brand->products->count() }})
                            </a>
                        </li>
                    @endforeach
                </ul>
            </div>
        </aside>

        {{-- Product Listing --}}
        <section class="product-listing">
            <div class="listing-toolbar">
                <p class="item-count">Items: {{ $products->total() }}</p>
                <div class="sort-options">
                    <span>Sort By:</span>
                    <select id="sortSelect">
                        <option value="position" {{ request('sort') == 'position' ? 'selected' : '' }}>Position</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>Name</option>
                        <option value="price" {{ request('sort') == 'price' ? 'selected' : '' }}>Price</option>
                    </select>
                </div>
            </div>

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

            <div class="pagination-wrapper">
                {{ $products->withQueryString()->links('pagination::bootstrap-5') }}
            </div>
        </section>
    </div>
</main>
@endsection

@section('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r148/three.min.js"></script>
<script>
    // --- Sort JS ---
    document.getElementById('sortSelect').addEventListener('change', function() {
        const params = new URLSearchParams(window.location.search);
        params.set('sort', this.value);
        params.delete('page');
        window.location.search = params.toString();
    });

    // --- 3D Floating Background using THREE.js ---
    const canvas = document.getElementById('bgCanvas');
    const scene = new THREE.Scene();
    const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
    const renderer = new THREE.WebGLRenderer({canvas: canvas, alpha: true});
    renderer.setSize(window.innerWidth, window.innerHeight);
    renderer.setPixelRatio(Math.min(window.devicePixelRatio, 2));
    
    const particles = new THREE.Group();
    scene.add(particles);

    for(let i=0; i<50; i++){
        const geometry = new THREE.IcosahedronGeometry(Math.random()*0.3+0.1, 0);
        const material = new THREE.MeshStandardMaterial({color: 0x3b82f6, wireframe:true, emissive:0x1e3a8a});
        const mesh = new THREE.Mesh(geometry, material);
        mesh.position.set((Math.random()-0.5)*20, (Math.random()-0.5)*10, (Math.random()-0.5)*20);
        mesh.rotation.set(Math.random()*Math.PI, Math.random()*Math.PI, 0);
        particles.add(mesh);
    }

    const light = new THREE.PointLight(0x3b82f6, 2);
    light.position.set(0,10,10);
    scene.add(light);

    camera.position.z = 10;

    function animate(){
        requestAnimationFrame(animate);
        particles.children.forEach(p => {
            p.rotation.x += 0.002;
            p.rotation.y += 0.004;
            p.position.y -= 0.002;
            if(p.position.y < -10) p.position.y = 10;
        });
        renderer.render(scene,camera);
    }
    animate();

    window.addEventListener('resize', ()=>{
        camera.aspect = window.innerWidth/window.innerHeight;
        camera.updateProjectionMatrix();
        renderer.setSize(window.innerWidth, window.innerHeight);
    });
</script>
@endsection