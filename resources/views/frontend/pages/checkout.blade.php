@extends('frontend.layouts.app')

@section('title', 'Checkout')

@section('style')
<style>
.container {
    max-width: 1200px;
    margin: 40px auto;
    
    background: #fff;
    border-radius: 12px;

}

h2 {
    text-align: center;
    margin-bottom: 30px;
    color: #333;
}

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

.form-control {
    width: 100%;
    padding: 10px 0;
    border-radius: 6px;
    border: 1px solid #ccc;
    font-size: 14px;
}

.table-cart {
    width: 100%;
    border-collapse: collapse;
    margin-bottom: 30px;
}

.table-cart th, .table-cart td {
    padding: 10px;
    border-bottom: 1px solid #eee;
    text-align: center;
}

.table-cart th {
    background: #f5f5f5;
    font-weight: 600;
}

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
    background: #ff6600;
    color: #fff;
    border: none;
    padding: 12px 25px;
    border-radius: 6px;
    font-size: 16px;
    cursor: pointer;
    margin-top: 20px;
    transition: 0.3s;
}

.btn-place-order:hover {
    background: #e55a00;
}

@media(max-width:768px){
    .container { padding: 15px; }
    .summary { text-align: left; }
}
</style>
@endsection

@section('content')
<div class="container">
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
            @foreach($cart as $item)
                <tr>
                    <td><img src="{{ asset($item['image'] ?? 'images/default.jpg') }}" alt="{{ $item['name'] }}" style="width:50px;"></td>
                    <td>{{ $item['name'] }}</td>
                    <td>${{ number_format($item['price'],2) }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'],2) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Checkout Form -->
    <form action="{{ route('checkout.placeOrder') }}" method="POST">
        @csrf

        <!-- Name, Phone, Email -->
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

        <!-- Address -->
        <div class="form-group" style="margin-top:15px;">
            <label>Full Address</label>
            <input type="text" name="address" class="form-control" required>
        </div>

        <!-- Division, District, Upazila -->
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
            <p><strong>Subtotal:</strong> ${{ number_format($subtotal,2) }}</p>
            <p><strong>Shipping:</strong> <span id="shipping-cost">${{ $shipping }}</span></p>
            <p><strong>Total:</strong> <span id="total-cost">${{ $total }}</span></p>
        </div>
        <input type="hidden" name="shipping" id="shipping" value="{{ $shipping }}">

        <h4>Payment Method</h4>
        <p><strong>Cash on Delivery</strong></p>

        <button type="submit" class="btn-place-order">Place Order</button>
    </form>
</div>

<script>
const bangladesh = {
    "Dhaka": {
        "Dhaka": ["Dhanmondi","Gulshan","Mirpur","Banani","Uttara"],
        "Gazipur": ["Gazipur Sadar","Kaliakoir","Tongi"]
    },
    "Chittagong": {
        "Chattogram": ["Pahartali","Chandgaon","Agrabad"],
        "Cox's Bazar": ["Cox's Bazar Sadar","Chakaria"]
    },
    "Khulna": {
        "Khulna": ["Khulna Sadar","Batiaghata"],
        "Jessore": ["Jessore Sadar","Chowgacha"]
    },
    "Rajshahi": {
        "Rajshahi": ["Rajshahi Sadar","Paba"],
        "Bogura": ["Bogura Sadar","Shibganj"]
    },
    "Barisal": {
        "Barisal": ["Barisal Sadar","Babuganj"],
        "Patuakhali": ["Patuakhali Sadar","Dumki"]
    },
    "Sylhet": {
        "Sylhet": ["Sylhet Sadar","Beanibazar"],
        "Moulvibazar": ["Moulvibazar Sadar","Kulaura"]
    },
    "Rangpur": {
        "Rangpur": ["Rangpur Sadar","Gangachara"],
        "Dinajpur": ["Dinajpur Sadar","Birampur"]
    },
    "Mymensingh": {
        "Mymensingh": ["Mymensingh Sadar","Bhaluka"],
        "Jamalpur": ["Jamalpur Sadar","Islampur"]
    }
};

window.addEventListener('DOMContentLoaded', () => {
    let divisionSelect = document.getElementById('division');
    Object.keys(bangladesh).forEach(div => {
        divisionSelect.innerHTML += `<option value="${div}">${div}</option>`;
    });
    calculateShipping();
});

function loadDistricts(){
    const division = document.getElementById('division').value;
    const districtSelect = document.getElementById('district');
    const upazilaSelect = document.getElementById('upazila');
    districtSelect.innerHTML = '<option value="">Select District</option>';
    upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';

    if(bangladesh[division]){
        Object.keys(bangladesh[division]).forEach(dist => {
            districtSelect.innerHTML += `<option value="${dist}">${dist}</option>`;
        });
    }
    calculateShipping();
}

function loadUpazilas(){
    const division = document.getElementById('division').value;
    const district = document.getElementById('district').value;
    const upazilaSelect = document.getElementById('upazila');
    upazilaSelect.innerHTML = '<option value="">Select Upazila</option>';

    if(division && district && bangladesh[division][district]){
        bangladesh[division][district].forEach(upa => {
            upazilaSelect.innerHTML += `<option value="${upa}">${upa}</option>`;
        });
    }
    calculateShipping();
}

function calculateShipping(){
    const division = document.getElementById('division').value;
    const district = document.getElementById('district').value;
    let shipping = (division === "Dhaka" && district === "Dhaka") ? 50 : 100;

    document.getElementById('shipping-cost').innerText = '$' + shipping;
    document.getElementById('total-cost').innerText = '$' + ({{ $subtotal }} + shipping);
    document.getElementById('shipping').value = shipping;
}
</script>
@endsection
