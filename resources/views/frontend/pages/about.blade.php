@extends('frontend.layouts.app')

@section('title', 'About Us - Auto Parts Market')

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

/* Hero Section */
.about-hero {
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: #fff;
    padding: 80px 20px;
    text-align: center;
    border-radius: 1rem;
    margin-bottom: 50px;
}

.about-hero h1 {
    font-size: 3rem;
    font-weight: 800;
    margin-bottom: 10px;
}

.about-hero p {
    font-size: 1.25rem;
    font-weight: 500;
}

/* About Content */
.about-content {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 40px;
    align-items: center;
    margin-bottom: 60px;
}

.about-content img {
    width: 100%;
    border-radius: 1rem;
    object-fit: cover;
    box-shadow: 0 10px 25px rgba(59,130,246,0.4);
    transition: transform 0.3s, box-shadow 0.3s;
}

.about-content img:hover {
    transform: scale(1.05) rotateY(5deg);
    box-shadow: 0 20px 40px rgba(59,130,246,0.7);
}

.about-text h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 15px;
    color: #3b82f6;
}

.about-text p {
    font-size: 1rem;
    color: #ccc;
    margin-bottom: 15px;
    line-height: 1.8;
}

/* Stats Section */
.stats {
    display: flex;
    justify-content: space-between;
    text-align: center;
    padding: 40px 20px;
    border-radius: 1rem;
    background: rgba(59,130,246,0.05);
    margin-bottom: 60px;
}

.stat-item h3 {
    color: #3b82f6;
    font-size: 2rem;
    margin-bottom: 8px;
}

.stat-item p {
    font-size: 1rem;
    color: #ccc;
}

/* Team Section */
.team-section {
    text-align: center;
}

.team-section h2 {
    font-size: 2rem;
    font-weight: 700;
    margin-bottom: 30px;
    color: #3b82f6;
}

.team-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
    gap: 25px;
}

.team-member {
    background: rgba(255,255,255,0.03);
    border-radius: 1rem;
    padding: 20px;
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
    transition: transform 0.3s, box-shadow 0.3s;
    backdrop-filter: blur(20px);
}

.team-member:hover {
    transform: translateY(-5px) scale(1.02);
    box-shadow: 0 20px 40px rgba(59,130,246,0.7);
}

.team-member img {
    width: 100%;
    height: 220px;
    object-fit: cover;
    border-radius: 1rem;
    margin-bottom: 15px;
    transition: transform 0.3s;
}

.team-member img:hover {
    transform: scale(1.05);
}

.team-member h4 {
    font-size: 1.125rem;
    margin-bottom: 5px;
    color: #fff;
}

.team-member p {
    font-size: 0.875rem;
    color: #ccc;
}

/* Responsive */
@media (max-width: 768px) {
    .about-content {
        grid-template-columns: 1fr;
    }

    .stats {
        flex-direction: column;
        gap: 20px;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>
<main>
    <section class="about-hero">
        <h1>{{ $about->title ?? 'About Auto Parts Market' }}</h1>
        <p>{{ $about->subtitle ?? 'Your Trusted Destination for Quality Auto Parts' }}</p>
    </section>

    <section class="about-content">
        <div class="about-text">
            <h2>Who We Are</h2>
            <p>{{ $about->who_we_are }}</p>
            <p>{{ $about->our_story }}</p>
        </div>
        <div>
            <img src="{{ asset('storage/' . $about->image) }}" alt="About Auto Parts Market">
        </div>
    </section>

    <section class="stats">
        @foreach ($stats as $stat)
            <div class="stat-item">
                <h3>{{ $stat->value }}</h3>
                <p>{{ $stat->title }}</p>
            </div>
        @endforeach
    </section>

    <section class="team-section">
        <h2>Meet Our Team</h2>
        <div class="team-grid">
            @foreach ($team as $member)
                <div class="team-member">
                    <img src="{{ asset('storage/' . $member->image) }}" alt="{{ $member->name }}">
                    <h4>{{ $member->name }}</h4>
                    <p>{{ $member->role }}</p>
                </div>
            @endforeach
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