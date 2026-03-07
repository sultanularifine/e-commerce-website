@extends('frontend.layouts.app')

@section('title', 'Contact Us - Auto Parts Market')

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

/* Animated background */
#bgCanvas {
    position: fixed;
    top:0;
    left:0;
    width:100%;
    height:100%;
    z-index:0;
}

/* Header */
.contact-header {
    text-align: center;
    margin-bottom: 50px;
}

.contact-header h1 {
    font-size: 3rem;
    font-weight: 800;
    color: #3b82f6;
    margin-bottom: 10px;
}

.contact-header p {
    font-size: 1.25rem;
    color: #ccc;
}

/* Content Layout */
.contact-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    margin-bottom: 50px;
}

/* Contact Info Card */
.contact-info {
    background: rgba(255,255,255,0.03);
    border-radius: 1rem;
    padding: 40px 30px;
    display: flex;
    flex-direction: column;
    gap: 20px;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
    backdrop-filter: blur(20px);
    transition: transform 0.3s, box-shadow 0.3s;
}

.contact-info:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px rgba(59,130,246,0.7);
}

.contact-info h2 {
    font-size: 2rem;
    font-weight: 700;
    color: #3b82f6;
    margin-bottom: 20px;
}

.contact-info p {
    font-size: 1rem;
    color: #ccc;
}

/* Contact Form Card */
.contact-form {
    background: rgba(255,255,255,0.03);
    padding: 30px;
    border-radius: 1rem;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
    backdrop-filter: blur(20px);
    transition: transform 0.3s, box-shadow 0.3s;
}

.contact-form:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px rgba(59,130,246,0.7);
}

.contact-form h2 {
    font-size: 2rem;
    margin-bottom: 20px;
    color: #3b82f6;
}

.contact-form form {
    display: flex;
    flex-direction: column;
}

.contact-form input,
.contact-form textarea {
    padding: 12px 15px;
    margin-bottom: 15px;
    border-radius: 0.5rem;
    font-size: 1rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #fff;
    resize: none;
    transition: 0.3s;
}

.contact-form input:focus,
.contact-form textarea:focus {
    border-color: #3b82f6;
    outline: none;
}

/* Submit Button */
.contact-form button {
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: white;
    padding: 12px;
    border: none;
    border-radius: 0.5rem;
    font-size: 1rem;
    cursor: pointer;
    font-weight: 700;
    transition: 0.3s;
}

.contact-form button:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(59,130,246,0.5);
}

/* Map */
.map-container {
    max-width: 1200px;
    margin: 0 auto;
    border-radius: 1rem;
    margin-top: 40px;
    overflow: hidden;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
}

.map-container iframe {
    width: 100%;
    height: 450px;
    border: none;
}

/* Responsive */
@media (max-width: 768px) {
    .contact-content {
        grid-template-columns: 1fr;
    }
    .map-container iframe {
        height: 300px;
    }
}

@media (max-width: 480px) {
    .map-container iframe {
        height: 200px;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>
<main class="contact-section">
    <section class="contact-header">
        <h1>{{ $contactPage->title ?? 'Contact' }}</h1>
        <p>{{ $contactPage->description ?? 'Have a question?' }}</p>
    </section>

    <section class="contact-content">
        <div class="contact-info">
            <h2>Our Information</h2>
            <p><strong>Address:</strong> {{ $contactPage->address ?? 'Dhaka, Bangladesh' }}</p>
            <p><strong>Phone:</strong> {{ $contactPage->phone ?? '+880 1234 567' }}</p>
            <p><strong>Email:</strong> {{ $contactPage->email ?? 'support@.com' }}</p>
            <p><strong>Working Hours:</strong> {{ $contactPage->working_hours ?? '9:00 AM - 6:00 PM' }}</p>
        </div>

        <div class="contact-form">
            <h2>Send Us a Message</h2>
            <form action="{{ route('contact.submit') }}" method="POST">
                @csrf
                <input type="text" name="name" placeholder="Your Name" required>
                <input type="email" name="email" placeholder="Your Email" required>
                <input type="phone" name="phone" placeholder="Your Phone (Optional)">
                <input type="text" name="subject" placeholder="Subject" required>
                <textarea name="message" rows="6" placeholder="Your Message" required></textarea>
                <button type="submit">Send Message</button>
            </form>
        </div>
    </section>

    <section class="map-section">
        <div class="map-container">
            {!! $contactPage->map_iframe ?? '' !!}
        </div>
    </section>
</main>
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
@endsection