@extends('frontend.layouts.app')

@section('title', 'Cart - Auto Parts Market')

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

/* Animated background */
#bgCanvas {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:0;
}

main.container {
    max-width: 1200px;
    margin: 100px auto 50px;
    padding: 20px;
    position: relative;
    z-index: 2;
}

h1 {
    font-size: 2.5rem;
    font-weight: 700;
    margin-bottom: 30px;
    border-bottom: 2px solid rgba(255,255,255,0.1);
    padding-bottom: 15px;
    color: #3b82f6;
}

/* Buttons */
.btn {
    padding: 8px 15px;
    border: none;
    cursor: pointer;
    font-weight: 700;
    text-transform: uppercase;
    font-size: 12px;
    border-radius: 0.5rem;
    transition: all 0.3s ease;
}

.btn-yellow {
    background-color: #ffc107;
    color: #000;
}

.btn-orange {
    background-color: #ff5722;
    color: #fff;
}

.btn-checkout {
    width: 100%;
    padding: 12px;
    margin-top: 15px;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: #fff;
    font-weight: 700;
}

.btn-checkout:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(59,130,246,0.5);
}

/* Cart Layout */
.cart-layout {
    display: grid;
    grid-template-columns: 3fr 1fr;
    gap: 30px;
}

.cart-item, .cart-summary-section {
    background: rgba(255,255,255,0.03);
    border-radius: 1rem;
    padding: 20px;
    margin-bottom: 20px;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
    backdrop-filter: blur(20px);
    transition: transform 0.3s, box-shadow 0.3s;
}

.cart-item:hover, .cart-summary-section:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px rgba(59,130,246,0.7);
}

.cart-header {
    display: flex;
    font-weight: 700;
    padding: 10px 0;
    border-bottom: 2px solid rgba(255,255,255,0.1);
}

.cart-item {
    display: flex;
    align-items: center;
    padding: 20px 10;
    border-bottom: 1px solid rgba(255,255,255,0.1);
}

.col-item {
    flex: 4;
    display: flex;
    align-items: center;
}

.col-price, .col-qty, .col-subtotal {
    flex: 1;
    text-align: right;
}

.item-image {
    width: 60px;
    margin-right: 15px;
    border: 1px solid rgba(255,255,255,0.1);
}

.item-name {
    font-weight: 500;
}

.col-qty input {
    width: 40px;
    padding: 5px;
    text-align: center;
    border-radius: 0.3rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #fff;
}

/* Cart Summary */
.cart-summary-section h2 {
    font-size: 1.5rem;
    margin-bottom: 15px;
    border-bottom: 2px solid rgba(255,255,255,0.1);
    padding-bottom: 10px;
}

.summary-row {
    display: flex;
    justify-content: space-between;
    padding: 8px 0;
}

.subtotal-row, .order-total-row {
    font-weight: 700;
    border-top: 1px solid rgba(255,255,255,0.1);
    padding-top: 10px;
}

/* Value Banners */
.value-banners {
    display: flex;
    justify-content: space-around;
    padding: 40px 15px;
    flex-wrap: wrap;
    text-align: center;
    margin-top: 50px;
}

.banner {
    max-width: 300px;
    margin: 15px 0;
}

.banner i {
    font-size: 30px;
    margin-bottom: 10px;
    color: #3b82f6;
}

.banner h3 {
    margin: 5px 0;
    font-size: 16px;
    color: #fff;
}

/* Responsive */
@media (max-width: 768px) {
    .cart-layout {
        grid-template-columns: 1fr;
        gap: 20px;
    }
    .cart-header {
        display: none;
    }
    .col-item, .col-price, .col-qty, .col-subtotal {
        flex: 1 1 100%;
        text-align: left;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>

<main class="container">
    <h1>SHOPPING CART</h1>

    @if(session('success'))
        <div style="background:#d4edda;color:#155724;padding:10px;border-radius:5px;margin-bottom:15px;">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background:#f8d7da;color:#721c24;padding:10px;border-radius:5px;margin-bottom:15px;">
            {{ session('error') }}
        </div>
    @endif

    <div class="cart-layout">
        <!-- Cart Items -->
        <div class="cart-items-section">
            @forelse ($cart as $id => $item)
                <div class="cart-item" data-id="{{ $id }}">
                    <div class="col-item">
                        <img src="{{ asset($item['image'] ?? 'images/default.jpg') }}" alt="{{ $item['name'] }}" class="item-image">
                        <div>
                            <p class="item-name">{{ $item['name'] }}</p>
                            <div class="item-actions">
                                <a href="{{ route('cart.remove', $id) }}" class="btn btn-yellow">Remove</a>
                            </div>
                        </div>
                    </div>
                    <span class="col-price">${{ number_format($item['price'], 2) }}</span>
                    <span class="col-qty">
                        <input type="number" value="{{ $item['quantity'] }}" min="1">
                    </span>
                    <span class="col-subtotal">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                </div>
            @empty
                <p>Your cart is empty!</p>
            @endforelse
        </div>

        <!-- Cart Summary -->
        <div class="cart-summary-section">
            <h2>SUMMARY</h2>
            <div class="summary-row subtotal-row">
                <span>Subtotal</span>
                <span>${{ number_format($subtotal, 2) }}</span>
            </div>
            <div class="summary-row">
                <span>Shipping (Flat Rate)</span>
                <span>${{ number_format($shipping, 2) }}</span>
            </div>
            <div class="summary-row order-total-row">
                <span>Order Total</span>
                <span>${{ number_format($total, 2) }}</span>
            </div>

          <div class="mt-4">  <a href="{{ route('checkout.index') }}" class="btn-checkout">
                PROCEED TO CHECKOUT
            </a></div>
        </div>
    </div>
</main>

<!-- Value Banners -->
<section class="value-banners">
    <div class="banner">
        <i class="fas fa-truck"></i>
        <h3>FREE SHIPPING</h3>
        <p>ON ALL ORDERS OVER $99.00</p>
    </div>
    <div class="banner">
        <i class="fas fa-dollar-sign"></i>
        <h3>MONEY GUARANTEE</h3>
        <p>7 DAYS MONEY BACK GUARANTEE</p>
    </div>
    <div class="banner">
        <i class="fas fa-headset"></i>
        <h3>ONLINE SUPPORT</h3>
        <p>24/7 CUSTOMER SUPPORT</p>
    </div>
</section>
@endsection

@section('scripts')
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

<script>
// --- Auto update summary + backend via AJAX ---
document.addEventListener('DOMContentLoaded', function(){
    const cartItems = document.querySelectorAll('.cart-item');
    const subtotalElem = document.querySelector('.subtotal-row span:last-child');
    const orderTotalElem = document.querySelector('.order-total-row span:last-child');
    const shippingCost = parseFloat({{ $shipping }});

    function recalcSummary(){
        let subtotal = 0;
        cartItems.forEach(item=>{
            const price = parseFloat(item.querySelector('.col-price').innerText.replace('$',''));
            const quantity = parseInt(item.querySelector('.col-qty input').value);
            const lineTotal = price * quantity;
            item.querySelector('.col-subtotal').innerText = '$'+lineTotal.toFixed(2);
            subtotal += lineTotal;
        });
        subtotalElem.innerText = '$'+subtotal.toFixed(2);
        orderTotalElem.innerText = '$'+(subtotal + shippingCost).toFixed(2);
    }

    function updateBackend(item){
        const id = item.dataset.id;
        const quantity = item.querySelector('.col-qty input').value;

        fetch("{{ route('cart.update') }}", {
            method: 'POST',
            headers: {
                'Content-Type':'application/json',
                'X-CSRF-TOKEN':'{{ csrf_token() }}'
            },
            body: JSON.stringify({
                quantities: {[id]: quantity}
            })
        });
    }

    cartItems.forEach(item=>{
        const input = item.querySelector('.col-qty input');
        input.addEventListener('input', function(){
            recalcSummary();
            updateBackend(item);
        });
    });

    recalcSummary();
});
</script>
@endsection