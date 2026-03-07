@extends('frontend.layouts.app')

@section('title', 'Checkout - Auto Parts Market')

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

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #3b82f6;
}

/* Form Styles */
.form-inline {
    display: flex;
    gap: 15px;
    flex-wrap: wrap;
}

.form-inline .form-group {
    flex: 1;
    min-width: 200px;
}

.form-group label {
    font-weight: 600;
    margin-bottom: 5px;
    display: block;
}

.form-control, select {
    width: 100%;
    padding: 10px;
    border-radius: 0.5rem;
    border: 1px solid rgba(255,255,255,0.2);
    background: rgba(255,255,255,0.05);
    color: #fff;
    font-size: 14px;
    transition: 0.3s;
}

.form-control:focus, select:focus {
    border-color: #3b82f6;
    outline: none;
    box-shadow: 0 0 10px rgba(59,130,246,0.5);
}

/* Cart Table */
.table-cart {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
    background: rgba(255,255,255,0.03);
    border-radius: 1rem;
    backdrop-filter: blur(15px);
    box-shadow: 0 10px 25px rgba(59,130,246,0.3);
}

.table-cart th, .table-cart td {
    padding: 10px;
    border-bottom: 1px solid rgba(255,255,255,0.1);
    text-align: center;
    color: #fff;
}

.table-cart th {
    background: rgba(59,130,246,0.2);
    font-weight: 600;
}

/* Summary & Button */
.summary {
    text-align: right;
    margin-top: 20px;
}

.summary p {
    font-size: 16px;
    margin: 5px 0;
}

.btn-place-order {
    display: inline-block;
    background: linear-gradient(135deg,#3b82f6,#2563eb);
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 0.5rem;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: 0.3s;
}

.btn-place-order:hover {
    transform: translateY(-2px) scale(1.02);
    box-shadow: 0 10px 25px rgba(59,130,246,0.5);
}

/* Responsive */
@media(max-width:768px) {
    .container {
        padding: 15px;
    }

    .summary {
        text-align: left;
    }
}
</style>
@endsection

@section('content')
<canvas id="bgCanvas"></canvas>

<main class="container">
    <h2>Checkout</h2>

    <!-- Cart Table -->
    <table class="table-cart">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product</th>
                <th>Price</th>
                <th>Qty</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($cart as $item)
                <tr>
                    <td><img src="{{ asset($item['image'] ?? 'images/default.jpg') }}" alt="{{ $item['name'] }}" style="width:50px;"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>{{ number_format($item['price'], 2) }} $</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>{{ number_format($item['price'] * $item['quantity'], 2) }} $</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Checkout Form -->
    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf
        <div class="form-inline">
            <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="name" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Phone</label>
                <input type="text" name="phone" class="form-control" required>
            </div>
            <div class="form-group">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>
        </div>

        <div class="form-group" style="margin-top:15px;">
            <label>Full Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <div class="form-inline" style="margin-top:15px;">
            <div class="form-group">
                <label>Division</label>
                <select name="division" id="division" class="form-control" required onchange="loadDistricts()">
                    <option value="">Select Division</option>
                </select>
            </div>
            <div class="form-group">
                <label>District</label>
                <select name="district" id="district" class="form-control" required onchange="loadUpazilas()">
                    <option value="">Select District</option>
                </select>
            </div>
            <div class="form-group">
                <label>Upazila / Thana</label>
                <select name="upazila" id="upazila" class="form-control" required onchange="calculateShipping()">
                    <option value="">Select Upazila</option>
                </select>
            </div>
        </div>

        <hr>

        <div class="summary">
            <p><strong>Subtotal:</strong> {{ number_format($subtotal, 2) }} $</p>
            <p><strong>Shipping:</strong> <span id="shipping-cost">{{ $shipping }}</span> $</p>
            <p><strong>Total:</strong> <span id="total-cost">{{ $total }}</span> $</p>
        </div>
        <input type="hidden" name="shipping" id="shipping" value="{{ $shipping }}">

        <h4>Payment Method</h4>
        <p><strong>Cash on Delivery</strong></p>

        <button type="submit" class="btn-place-order">Place Order</button>
    </form>
</main>

<script>
const bangladesh = {
  "Dhaka": {
    "Dhaka": ["Dhamrai","Dohar","Keraniganj","Nawabganj","Savar","Dhanmondi","Gulshan","Mirpur","Banani","Uttara"],
    "Gazipur": ["Gazipur Sadar","Kaliakoir","Kaliganj","Kapasia","Sreepur"],
    "Narayanganj": ["Araihazar","Bandar","Narayanganj Sadar","Rupganj","Sonargaon"],
    "Narsingdi": ["Narsingdi Sadar","Belabo","Monohardi","Palash","Raipura","Shibpur"],
    "Munshiganj": ["Munshiganj Sadar","Gajaria","Lohajang","Sreenagar","Sirajdikhan","Tongibari"],
    "Manikganj": ["Manikganj Sadar","Singair","Sibaloy","Saturia","Harirampur","Ghior","Daulatpur"],
    "Tangail": ["Tangail Sadar","Kalihaati","Ghatail","Bashail","Bhuapur","Delduar","Gopalpur","Madhupur","Mirzapur","Nagarpur","Sakhipur","Dhanbari"],
    "Kishoreganj": ["Kishoreganj Sadar","Hossainpur","Karimganj","Tarail","Katiadi","Pakundia","Bhairab","Nikli","Bajitpur","Itna","Mithamain","Ostagram","Kuliarchar"],
    "Faridpur": ["Faridpur Sadar","Boalmari","Alfadanga","Madhukhali","Bhanga","Nagarkanda","Charbhadrasan","Sadarpara","Salta"],
    "Rajbari": ["Rajbari Sadar","Goalanda","Pangsha","Baliakandi","Kalukhali"],
    "Gopalganj": ["Gopalganj Sadar","Kotalipara","Tungipara","Kashiani","Muksudpur"],
    "Madaripur": ["Madaripur Sadar","Kalkini","Rajoir","Shibchar","Dasar"],
    "Shariatpur": ["Shariatpur Sadar","Jajira","Naria","Bhedarganj","Damudya","Gosairhat"]
  },
  "Chattogram": {
    "Chattogram": ["Anwara","Banshkhali","Boalkhali","Chandanaish","Fatikchhari","Hathazari","Lohagara","Mirsarai","Patiya","Rangunia","Raozan","Sandwip","Satkania","Sitakunda","Karnaphuli"],
    "Cox's Bazar": ["Cox's Bazar Sadar","Chakaria","Kutubdia","Maheshkhali","Ramu","Teknaf","Ukhiya","Pekua"],
    "Cumilla": ["Cumilla Sadar","Barura","Brahmanpara","Burichong","Chandina","Chouddagram","Daudkandi","Debidwar","Homna","Laksam","Muradnagar","Nangalkot","Titas","Meghna","Monohorgonj","Sadar Dakshin","Lalmai"],
    "Brahmanbaria": ["Brahmanbaria Sadar","Ashuganj","Nasirnagar","Nabinagar","Sarail","Shahbazpur","Kasba","Akhaura","Bijoynagar"],
    "Chandpur": ["Chandpur Sadar","Kachua","Shahrasti","Hajiganj","Matlab Uttar","Matlab Dakkhin","Faridganj","Haimchar"],
    "Noakhali": ["Noakhali Sadar","Begumganj","Chatkhil","Companiganj","Hatiya","Senbagh","Sonaimuri","Subarnachar","Kabirhat"],
    "Feni": ["Feni Sadar","Daganbhuiya","Chagolnaiya","Sonagazi","Parshuram","Phulgazi"],
    "Lakshmipur": ["Lakshmipur Sadar","Raipur","Ramganj","Ramgati","Kamalnagar"],
    "Rangamati": ["Rangamati Sadar","Baghaichhari","Barkal","Kaukhali","Kaptai","Jurachhari","Longdu","Naniarchar","Rajsthali","Bilaichhari"],
    "Khagrachhari": ["Khagrachhari Sadar","Dighinala","Panchhari","Mahalchhari","Matiranga","Guimara","Ramgarh","Manikchhari","Laxmichhari"],
    "Bandarban": ["Bandarban Sadar","Alikadam","Naikhongchhari","Rowangchhari","Ruma","Thanchi","Lama"]
  },
  "Rajshahi": {
    "Rajshahi": ["Bagha","Bagmara","Charghat","Durgapur","Godagari","Mohanpur","Paba","Puthia","Tanore"],
    "Bogura": ["Bogura Sadar","Adamdighi","Dhunat","Dupchanchia","Gabtali","Kahalu","Nandigram","Sariakandi","Shahjahanpur","Sherpur","Shibganj","Sonatala"],
    "Pabna": ["Pabna Sadar","Atghoria","Bera","Bhangura","Chatmohar","Faridpur","Ishwardi","Santhia","Sujanagar"],
    "Sirajganj": ["Sirajganj Sadar","Belkuchi","Chowhali","KamarKhand","Kazipur","Raiganj","Shahjadpur","Tarash","Ullapara"],
    "Natore": ["Natore Sadar","Bagatipara","Baraigram","Lalpur","Singra","Gurudaspur","Naldanga"],
    "Naogaon": ["Naogaon Sadar","Atrai","Dhamoirhat","Manda","Mahadebpur","Niamatpur","Patnitala","Porsa","Raninagar","Sapahar","Baldagachi"],
    "Chapainawabganj": ["Chapainawabganj Sadar","Gomastapur","Nachol","Bholahat","Shibganj"],
    "Joypurhat": ["Joypurhat Sadar","Akkelpur","Kalai","Khetlal","Panchbibi"]
  },
  "Khulna": {
    "Khulna": ["Batiaghata","Dakop","Dumuria","Dighalia","Koyra","Paikgachha","Phultala","Rupsa","Terokhada"],
    "Jessore": ["Jessore Sadar","Abhaynagar","Bagherpara","Chowgacha","Jhikargacha","Keshabpur","Monirampur","Sharsha"],
    "Satkhira": ["Satkhira Sadar","Ashashuni","Debhata","Kalaroa","Kaliganj","Shyamnagar","Tala"],
    "Bagerhat": ["Bagerhat Sadar","Fakirhat","Mollahat","Kachua","Morrelganj","Mongla","Chitalmari","Sharankhola","Rampal"],
    "Kushtia": ["Kushtia Sadar","Kumarkhali","Khoksa","Mirpur","Daulatpur","Bheramara"],
    "Jhinaidah": ["Jhinaidah Sadar","Shailkupa","Harinakundu","Kaliganj","Kotchandpur","Maheshpur"],
    "Magura": ["Magura Sadar","Shripur","Mohammadpur","Shalikha"],
    "Chuadanga": ["Chuadanga Sadar","Alamdanga","Dumurdahuda","Jibannagar"],
    "Meherpur": ["Meherpur Sadar","Gangni","Mujibnagar"],
    "Narail": ["Narail Sadar","Lohagara","Kalia"]
  },
  "Barishal": {
    "Barishal": ["Barishal Sadar","Agailjhara","Babuganj","Bakerganj","Banaripara","Gournadi","Hijla","Mehendiganj","Muladi","Uzirpur"],
    "Bhola": ["Bhola Sadar","Borhanuddin","Charfassion","Daulatkhan","Lalmohan","Monpura","Tazumuddin"],
    "Patuakhali": ["Patuakhali Sadar","Bauphal","Dashmina","Galachipa","Kalapara","Mirzaganj","Dumki","Rangabali"],
    "Pirojpur": ["Pirojpur Sadar","Bhandaria","Mathbaria","Nazirpur","Nesarabad","Kaukhali","Indurkani"],
    "Barguna": ["Barguna Sadar","Amtali","Bamna","Betagi","Patharghata","Taltoli"],
    "Jhalokathi": ["Jhalokathi Sadar","Kathalia","Nalchity","Rajapur"]
  },
  "Sylhet": {
    "Sylhet": ["Sylhet Sadar","Balaganj","Beanibazar","Bishwanath","Companiganj","Fenchuganj","Golapganj","Gowainghat","Jaintiapur","Kanaighat","Dakshin Surma","Zakiganj","Osmaninagar"],
    "Moulvibazar": ["Moulvibazar Sadar","Barlekha","Kamalganj","Kulaura","Rajnagar","Sreemangal","Juri"],
    "Habiganj": ["Habiganj Sadar","Azmiriganj","Bahubal","Baniachang","Chunarughat","Lakhai","Madhabpur","Nabiganj","Shaistaganj"],
    "Sunamganj": ["Sunamganj Sadar","Dakshin Sunamganj","Bishwambharpur","Chatak","Derai","Dharmapasha","Duarabazar","Jagannathpur","Jamalganj","Tahirpur","Shalla","Madhyanagar"]
  },
  "Rangpur": {
    "Rangpur": ["Rangpur Sadar","Badarganj","Gangachara","Kaunia","Mithapukur","Pirgacha","Pirgong","Taraganj"],
    "Dinajpur": ["Dinajpur Sadar","Birganj","Kaharol","Bochaganj","Biramapur","Biramapurr","Nawabganj","Ghoraghat","Hakimpur","Phulbari","Chirirbandar","Khansama","Parbatipur"],
    "Kurigram": ["Kurigram Sadar","Ulipur","Chilmari","Roumari","Rajibpur","Bhurungamari","Nageshwari","Phulbari","Rajarhat"],
    "Gaibandha": ["Gaibandha Sadar","Fulchhari","Sadullapur","Saghata","Sundarganj","Gobindaganj","Palashbari"],
    "Nilphamari": ["Nilphamari Sadar","Domar","Jaldhaka","Kishoreganj","Saidpur","Dimla"],
    "Thakurgaon": ["Thakurgaon Sadar","Pirgong","Baliadangi","Ranisankail","Haripur"],
    "Panchagarh": ["Panchagarh Sadar","Boda","Debiganj","Tetulia","Atwari"],
    "Lalmonirhat": ["Lalmonirhat Sadar","Aditmari","Kaliganj","Hatibandha","Patgram"]
  },
  "Mymensingh": {
    "Mymensingh": ["Mymensingh Sadar","Muktagachha","Fulbaria","Trishal","Bhaluka","Gafargaon","Nandail","Ishwarganj","Gouripur","Fulpur","Tarakanda","Haluaghat","Dhubarua"],
    "Jamalpur": ["Jamalpur Sadar","Bakshiganj","Dewanganj","Islampur","Madariganj","Melandah","Sarisabari"],
    "Sherpur": ["Sherpur Sadar","Jhinaigati","Nakla","Nalitabari","Sreebardi"],
    "Netrokona": ["Netrokona Sadar","Barhatta","Durgapur","Kalamakanda","Kendua","Khaliakuri","Madan","Mohanganj","Purbo Dhala","Atpara"]
  }
};

window.addEventListener('DOMContentLoaded', () => {
    let divisionSelect = document.getElementById('division');
    Object.keys(bangladesh).forEach(div => {
        divisionSelect.innerHTML += `<option value="${div}">${div}</option>`;
    });
    calculateShipping();
});

function loadDistricts() {
    const division = document.getElementById('division').value;
    const districtSelect = document.getElementById('district');
    const upazilaSelect = document.getElementById('upazila');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
    if (bangladesh[division]) {
        Object.keys(bangladesh[division]).forEach(dist => {
            districtSelect.innerHTML += `<option value="${dist}">${dist}</option>`;
        });
    }
    calculateShipping();
}

function loadUpazilas() {
    const division = document.getElementById('division').value;
    const district = document.getElementById('district').value;
    const upazilaSelect = document.getElementById('upazila');
    upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';
    if (division && district && bangladesh[division][district]) {
        bangladesh[division][district].forEach(upa => {
            upazilaSelect.innerHTML += `<option value="${upa}">${upa}</option>`;
        });
    }
    calculateShipping();
}

function calculateShipping() {
    const division = document.getElementById('division').value;
    const district = document.getElementById('district').value;
    let shipping = (division === "Dhaka" && district === "Dhaka") ? 50 : 100;
    document.getElementById('shipping-cost').innerText = '$' + shipping;
    document.getElementById('total-cost').innerText = '$' + ({{ $subtotal }} + shipping);
    document.getElementById('shipping').value = shipping;
}
</script>

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