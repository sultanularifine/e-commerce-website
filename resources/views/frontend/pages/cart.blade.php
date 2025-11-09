@extends('frontend.layouts.app')

@section('title', 'Cart - Auto Parts Market')

@section('style')
<style>
    /* Base Styles */
    body {
        font-family: 'Roboto', sans-serif;
        margin: 0;
        padding: 0;
        color: #333;
        background-color: #fff;
        font-size: 14px;
    }

    .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px 15px;
    }

    h1 {
        font-size: 28px;
        font-weight: 700;
        margin-bottom: 30px;
        border-bottom: 2px solid #eee;
        padding-bottom: 15px;
    }

    /* Buttons */
    .btn {
        padding: 8px 15px;
        border: none;
        cursor: pointer;
        font-weight: 700;
        text-transform: uppercase;
        font-size: 12px;
        border-radius: 3px;
        transition: all 0.3s ease;
    }

    .btn-yellow {
        background-color: #ffc107;
        color: #333;
    }


    .btn-checkout {
        width: 100%;
        padding: 12px;
        margin-top: 15px;
        background-color: #333;
        color: #fff;
    }

    .btn-orange {
        background-color: #ff5722;
        color: #fff;
    }

    .btn-update-cart {
        background-color: #ffc107;
        color: #333;
        padding: 10px 20px;
        margin-top: 20px;
        float: right;
    }

    /* Cart Layout */
    .cart-layout {
        display: grid;
        grid-template-columns: 3fr 1fr;
        gap: 30px;
    }

    .cart-header {
        display: flex;
        font-weight: 700;
        padding: 10px 0;
        border-bottom: 2px solid #333;
        color: #333;
    }

    .cart-item {
        display: flex;
        align-items: center;
        padding: 20px 0;
        border-bottom: 1px solid #eee;
    }

    .col-item {
        flex: 4;
        display: flex;
        align-items: center;
    }

    .col-price,
    .col-qty,
    .col-subtotal {
        flex: 1;
        text-align: right;
    }

    .item-image {
        width: 60px;
        margin-right: 15px;
        border: 1px solid #eee;
    }

    .item-name {
        margin-top: -5px;
        font-weight: 500;
    }

    .item-actions {
        margin-top: 10px;
    }

    .col-qty input {
        width: 40px;
        padding: 5px;
        text-align: center;
        border: 1px solid #ccc;
    }

    /* Cart Summary */
    .cart-summary-section {
        border: 1px solid #eee;
        padding: 20px;
    }

    .cart-summary-section h2 {
        font-size: 18px;
        margin-bottom: 15px;
        border-bottom: 2px solid #eee;
        padding-bottom: 10px;
    }

    .summary-row {
        display: flex;
        justify-content: space-between;
        padding: 8px 0;
    }

    .subtotal-row,
    .order-total-row {
        font-weight: 700;
        border-top: 1px solid #eee;
        padding-top: 10px;
    }

    .discount-code {
        margin-top: 20px;
    }

    /* Value Banners */
    .value-banners {
        background-color: #222;
        color: #fff;
        display: flex;
        justify-content: space-around;
        padding: 40px 15px;
        margin-top: 50px;
        flex-wrap: wrap;
        text-align: center;
    }

    .banner {
        max-width: 300px;
        margin: 15px 0;
    }

    .banner i {
        font-size: 30px;
        margin-bottom: 10px;
    }

    .banner h3 {
        margin: 5px 0;
        font-size: 16px;
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

        .cart-item {
            flex-wrap: wrap;
            padding: 15px 0;
        }

        .col-item {
            flex: 1 1 100%;
            margin-bottom: 10px;
        }

        .col-price,
        .col-qty,
        .col-subtotal {
            flex: 1 1 33%;
            text-align: left;
            padding: 5px 0;
            position: relative;
        }

        .col-price::before { content: "Price: "; font-weight: 700; color: #666; }
        .col-qty::before { content: "Qty: "; font-weight: 700; color: #666; }
        .col-subtotal::before { content: "Subtotal: "; font-weight: 700; color: #666; }

        .col-qty input { width: 50px; }

        .value-banners {
            flex-direction: column;
        }
    }
</style>
@endsection

@section('content')
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
            <div class="cart-header">
                <span class="col-item">Item</span>
                <span class="col-price">Price</span>
                <span class="col-qty">Qty</span>
                <span class="col-subtotal">Subtotal</span>
            </div>

            <form action="{{ route('cart.update') }}" method="POST">
                @csrf
                @forelse ($cart as $id => $item)
                    <div class="cart-item">
                        <div class="col-item">
                            <img src="{{ asset($item['image'] ?? 'images/default.jpg') }}" alt="{{ $item['name'] }}" class="item-image">
                            <div>
                                <p class="item-name">{{ $item['name'] }}</p>
                                <div class="item-actions">
                                    <a href="{{ route('cart.remove', $id) }}" class="btn btn-remove">Remove</a>
                                </div>
                            </div>
                        </div>
                        <span class="col-price">${{ number_format($item['price'], 2) }}</span>
                        <span class="col-qty">
                            <input type="number" name="quantities[{{ $id }}]" value="{{ $item['quantity'] }}" min="1">
                        </span>
                        <span class="col-subtotal">${{ number_format($item['price'] * $item['quantity'], 2) }}</span>
                    </div>
                @empty
                    <p>Your cart is empty!</p>
                @endforelse

                @if ($cart)
                    <button type="submit" class="btn btn-update-cart">Update Shopping Cart</button>
                @endif
            </form>
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

            <div class="discount-code">
                <a href="{{ route('checkout.index') }}" class="btn btn-checkout btn-orange">
                    PROCEED TO CHECKOUT
                </a>
            </div>
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
