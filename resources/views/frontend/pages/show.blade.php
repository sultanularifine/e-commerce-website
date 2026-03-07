@extends('frontend.layouts.app')

@section('title', 'Product - Auto Parts Market')

@section('style')
<style>
body {
    font-family: 'Roboto', sans-serif;
    margin: 0;
    padding: 0;
    background: #000;
    color: #fff;
    overflow-x: hidden;
    position: relative;
    
}
main{
    margin-top: 80px;
}
/* Animated background canvas */
#bgCanvas {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:0;
}

/* Product Section */
.product-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: space-between;
    padding: 40px 60px;
    gap: 30px;
    position: relative;
    z-index: 2;
}

.product-images {
    flex: 1 1 40%;
    max-width: 500px;
}

.product-images img.main-image {
    width: 100%;
    border-radius: 12px;
    transition: 0.3s;
    box-shadow: 0 10px 25px rgba(59,130,246,0.5);
}

.product-thumbs {
    display: flex;
    gap: 10px;
    margin-top: 10px;
    flex-wrap: wrap;
}

.product-thumbs img {
    width: 80px;
    height: 80px;
    object-fit: cover;
    border: 2px solid rgba(255,255,255,0.2);
    border-radius: 8px;
    cursor: pointer;
    transition: 0.3s;
}

.product-thumbs img:hover {
    border-color: #3b82f6;
}

.product-details {
    flex: 1 1 50%;
}

.product-details h1 {
    font-size: 28px;
    margin-bottom: 10px;
    color: #3b82f6;
}

.in-stock {
    color: #22c55e;
    font-weight: 600;
    margin-bottom: 8px;
}

.text-danger {
    color: #ef4444;
    font-weight: 600;
    margin-bottom: 8px;
}

.stars {
    color: #facc15;
    margin-bottom: 10px;
}

.product-details p {
    margin: 15px 0;
    color: #ccc;
}

.price {
    font-size: 22px;
    font-weight: bold;
    margin-bottom: 10px;
}

.old-price {
    font-size: 16px;
    font-weight: normal;
    text-decoration: line-through;
    color: #888;
    margin-left: 8px;
}

.product-actions {
    display: flex;
    align-items: center;
    gap: 10px;
    margin: 15px 0;
    flex-wrap: wrap;
}

.product-actions input {
    width: 60px;
    padding: 6px;
    text-align: center;
    border: 1px solid rgba(255,255,255,0.2);
    border-radius: 6px;
    background: rgba(255,255,255,0.05);
    color: #fff;
}

.btn {
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 8px;
    cursor: pointer;
    font-size: 14px;
    transition: 0.3s;
}

.btn:hover {
    transform: translateY(-2px) scale(1.05);
    box-shadow: 0 10px 25px rgba(59,130,246,0.5);
}

/* Tabs */
.tabs {
    margin: 40px 60px;
    position: relative;
    z-index: 2;
}

.tab-buttons {
    display: flex;
    border-bottom: 2px solid rgba(255,255,255,0.2);
    flex-wrap: wrap;
}

.tab-buttons button {
    background: none;
    border: none;
    padding: 10px 20px;
    font-weight: 600;
    cursor: pointer;
    border-bottom: 3px solid transparent;
    color: #fff;
    transition: 0.3s;
}

.tab-buttons button.active {
    border-color: #3b82f6;
    color: #3b82f6;
}

.tab-content {
    padding: 20px 0;
    color: #ccc;
}

/* Related Products */
.related-products {
    padding: 20px 60px;
    position: relative;
    z-index: 2;
}

.related-products h2 {
    text-align: center;
    margin-bottom: 20px;
    font-size: 24px;
    color: #3b82f6;
}

.product-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 20px;
    justify-content: flex-start;
}

.product-card {
    display: flex;
    flex-direction: column;
    align-items: center;
    width: 250px;
    background: rgba(255,255,255,0.05);
    border-radius: 12px;
    padding: 15px;
    text-decoration: none;
    color: inherit;
    box-shadow: 0 10px 20px rgba(59,130,246,0.3);
    transition: transform 0.2s, box-shadow 0.3s;
}

.product-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 30px rgba(59,130,246,0.5);
}

.product-image {
    width: 100%;
    height: 200px;
    overflow: hidden;
    border-radius: 12px;
    margin-bottom: 10px;
}

.product-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

/* Responsive */
@media(max-width:768px) {
    .product-container {
        flex-direction: column;
        align-items: center;
        padding: 30px;
    }

    .product-details,
    .product-images {
        max-width: 100%;
    }

    .product-card {
        width: 45%;
    }
}

@media(max-width:480px) {
    .product-card {
        width: 100%;
    }

    .product-image img {
        height: 150px;
    }

    .tabs, .related-products {
        padding: 20px;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>

<main>
    <section class="product-container">
        <div class="product-images">
            <img src="{{ asset($product->thumbnail ?? 'images/default.jpg') }}" alt="{{ $product->name }}"
                class="main-image">

            @if (!empty($product->images) && count($product->images))
                <div class="product-thumbs">
                    @foreach ($product->images as $img)
                        <img src="{{ asset($img->gallery) }}" alt="{{ $product->name }}">
                    @endforeach
                </div>
            @endif
        </div>

        <div class="product-details">
            <h1>{{ $product->name }}</h1>
            <div class="{{ $product->stock > 0 ? 'in-stock' : 'text-danger' }}">
                {{ $product->stock > 0 ? 'In Stock' : 'Out of Stock' }}
            </div>
            <div class="stars">★★★★★</div>

            <div class="price">
                ${{ number_format($product->discount_price ?? $product->price, 2) }}
                @if ($product->discount_price)
                    <span class="old-price">${{ number_format($product->price, 2) }}</span>
                @endif
            </div>

            <p>{{ $product->description }}</p>

            <div class="product-actions">
                <form action="{{ route('cart.add', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <label>Qty</label>
                    <input type="number" name="quantity" value="1" min="1">
                    <button type="submit" class="btn">Add to Cart</button>
                </form>

                <form action="{{ route('cart.buy', $product->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <input type="hidden" name="quantity" value="1">
                    <button type="submit" class="btn">Buy Now</button>
                </form>
            </div>

        </div>
    </section>

    <section class="tabs">
        <div class="tab-buttons">
            <button class="active">Details</button>
        </div>
        <div class="tab-content">
            <p>{{ $product->meta_description ?? 'No additional details.' }}</p>
        </div>
    </section>

    <section class="related-products">
        <h2>We Found Other Products You Might Like!</h2>
        <div class="product-grid">
            @foreach ($relatedProducts as $related)
                <a href="{{ route('products.view', $related->slug) }}" class="product-card">
                    <div class="product-image">
                        <img src="{{ asset($related->thumbnail ?? 'images/default.jpg') }}" alt="{{ $related->name }}">
                    </div>
                    <h3>{{ $related->name }}</h3>
                    <div class="price">
                        ${{ number_format($related->discount_price ?? $related->price, 2) }}
                        @if ($related->discount_price)
                            <span class="old-price">${{ number_format($related->price, 2) }}</span>
                        @endif
                    </div>
                    <button class="btn">Add to Cart</button>
                </a>
            @endforeach
        </div>
    </section>
</main>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const thumbs = document.querySelectorAll('.product-thumbs img');
    const mainImg = document.querySelector('.product-images .main-image');

    thumbs.forEach(thumb => {
        thumb.addEventListener('click', () => {
            mainImg.src = thumb.src;
        });
    });
});
</script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r148/three.min.js"></script>
<script>
// --- 3D Floating Background ---
const canvas = document.getElementById('bgCanvas');
const scene = new THREE.Scene();
const camera = new THREE.PerspectiveCamera(75, window.innerWidth/window.innerHeight, 0.1, 1000);
const renderer = new THREE.WebGLRenderer({canvas: canvas, alpha: true});
renderer.setSize(window.innerWidth, window.innerHeight);
renderer.setPixelRatio(Math.min(window.devicePixelRatio,2));

const particles = new THREE.Group();
scene.add(particles);

for(let i=0;i<50;i++){
    const geometry = new THREE.IcosahedronGeometry(Math.random()*0.3+0.1,0);
    const material = new THREE.MeshStandardMaterial({color:0x3b82f6, wireframe:true, emissive:0x1e3a8a});
    const mesh = new THREE.Mesh(geometry, material);
    mesh.position.set((Math.random()-0.5)*20, (Math.random()-0.5)*10, (Math.random()-0.5)*20);
    mesh.rotation.set(Math.random()*Math.PI, Math.random()*Math.PI,0);
    particles.add(mesh);
}

const light = new THREE.PointLight(0x3b82f6,2);
light.position.set(0,10,10);
scene.add(light);

camera.position.z = 10;

function animate(){
    requestAnimationFrame(animate);
    particles.children.forEach(p=>{
        p.rotation.x += 0.002;
        p.rotation.y += 0.004;
        p.position.y -= 0.002;
        if(p.position.y<-10) p.position.y=10;
    });
    renderer.render(scene,camera);
}
animate();

window.addEventListener('resize',()=>{
    camera.aspect = window.innerWidth/window.innerHeight;
    camera.updateProjectionMatrix();
    renderer.setSize(window.innerWidth, window.innerHeight);
});
</script>
@endsection