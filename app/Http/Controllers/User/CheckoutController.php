<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Mail\OrderPlacedMail;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CheckoutController extends Controller
{
    public function placeOrder(Request $request)
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart')->with('error', 'Your cart is empty!');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'address' => 'required|string|max:500',
            'division' => 'required|string',
            'district' => 'required|string',
            'upazila' => 'required|string',
            'shipping' => 'required|numeric',
        ]);

        // Calculate subtotal
        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $total = $subtotal + $validated['shipping'];

        // Save order to DB
        $order = Order::create([
            'name' => $validated['name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'address' => $validated['address'],
            'division' => $validated['division'],
            'district' => $validated['district'],
            'upazila' => $validated['upazila'],
            'subtotal' => $subtotal,
            'shipping' => $validated['shipping'],
            'total' => $total,
            'payment_method' => 'Cash on Delivery',
            'items' => json_encode($cart),

        ]);
        Mail::to($validated['email'])->send(new OrderPlacedMail($order));
        // Clear Cart
     
        session()->forget('cart');

        return redirect()->route('cart.index')->with('success', 'Your order has been placed successfully!');
    }
}
