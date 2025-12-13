<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Order Confirmation</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f7;
            margin: 0;
            padding: 0;
        }
        .email-container {
            max-width: 700px;
            margin: 30px auto;
            background-color: #ffffff;
            padding: 20px;
            border-radius: 12px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        h2 {
            color: #333333;
            text-align: center;
        }
        p {
            font-size: 16px;
            color: #555555;
        }
        .order-details {
            margin-top: 20px;
        }
        .order-details th, .order-details td {
            padding: 10px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }
        .order-details th {
            background-color: #f5f5f5;
            font-weight: 600;
        }
        .order-summary {
            margin-top: 20px;
            text-align: right;
        }
        .order-summary p {
            font-size: 16px;
            margin: 5px 0;
        }
        .product-img {
            width: 50px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
        .footer {
            margin-top: 30px;
            font-size: 14px;
            color: #888888;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="email-container">
        <h2>Thank you for your order, {{ $order->name }}!</h2>
        <p>Your order has been received successfully. Here are your order details:</p>

        <table class="order-details" width="100%" cellpadding="0" cellspacing="0">
            <thead>
                <tr>
                    <th>Image</th>
                    <th>Product</th>
                    <th>Qty</th>
                    <th>Price</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach(json_decode($order->items, true) as $item)
                <tr>
                    
                    <td>
                        <img src="{{ public_path($item['image']) }}" alt="{{ $item['name'] }}" class="product-img">
                    </td>
                   
                    <td>{{ $item['name'] }}</td>
                    <td>{{ $item['quantity'] }}</td>
                    <td>${{ number_format($item['price'], 2) }}</td>
                    <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>

        <div class="order-summary">
            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
            <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
        </div>

        <div class="order-info">
            <p><strong>Order ID:</strong> {{ $order->id }}</p>
            <p><strong>Address:</strong> {{ $order->address }}, {{ $order->upazila }}, {{ $order->district }}, {{ $order->division }}</p>
            <p><strong>Phone:</strong> {{ $order->phone }}</p>
            <p><strong>Email:</strong> {{ $order->email }}</p>
        </div>

        <p style="margin-top:20px;">We will notify you once your order is shipped. Thank you for shopping with us!</p>

        <div class="footer">
            &copy; {{ date('Y') }} Your Store Name. All rights reserved.
        </div>
    </div>
</body>
</html>

