<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // 🛍️ Show Cart Page
    public function index()
    {
        $cart = session('cart', []);
        $subtotal = 0;

        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = $subtotal > 0 ? 35 : 0;
        $total = $subtotal + $shipping;

        return view('frontend.pages.cart', compact('cart', 'subtotal', 'shipping', 'total'));
    }

    // 🛒 Add to Cart
    public function addToCart(Request $request, Product $product)
    {
        $cart = session()->get('cart', []);
        $quantity = $request->input('quantity', 1);

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity'] += $quantity;
        } else {
            $cart[$product->id] = [
                'name' => $product->name,
                'price' => $product->discount_price ?? $product->price,
                'quantity' => $quantity,
                'image' => $product->thumbnail,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    // ✏️ Update Cart Quantities
    public function updateCart(Request $request)
    {
        $cart = session('cart', []);

        foreach ($request->quantities as $id => $qty) {
            if (isset($cart[$id])) {
                $cart[$id]['quantity'] = max(1, (int)$qty);
            }
        }

        session()->put('cart', $cart);

        return redirect()->route('cart.index')->with('success', 'Cart updated!');
    }

    // ❌ Remove Item
    public function removeItem($id)
    {
        $cart = session('cart', []);
        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Item removed from cart.');
    }

    // ✅ Checkout Page
    public function checkout()
    {
        $cart = session('cart', []);
        if (empty($cart)) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty!');
        }

        $subtotal = 0;
        foreach ($cart as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $shipping = 35;
        $total = $subtotal + $shipping;

        return view('frontend.pages.checkout', compact('cart', 'subtotal', 'shipping', 'total'));
    }
    public function buyNow(Request $request, Product $product)
{
    // 🛍️ Create a temporary cart for this product
    $quantity = $request->input('quantity', 1);

    $cart = [
        $product->id => [
            'name' => $product->name,
            'price' => $product->discount_price ?? $product->price,
            'quantity' => $quantity,
            'image' => $product->thumbnail,
        ],
    ];

    // 🧠 Save to session (optional, so checkout can read it)
    session()->put('cart', $cart);

    // 🧾 Calculate totals
    $subtotal = $cart[$product->id]['price'] * $quantity;
    $shipping = 35;
    $total = $subtotal + $shipping;

    // 🧭 Redirect directly to checkout page
    return view('frontend.pages.checkout', compact('cart', 'subtotal', 'shipping', 'total'));
}

}
