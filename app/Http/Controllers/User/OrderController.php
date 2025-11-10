<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // List all orders
    public function index(Request $request)
    {
        $query = Order::query();

        // Search by customer name or email
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
        }

        $orders = $query->latest()->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }

    // View single order
    public function show(Order $order)
    {
         $order->items = json_decode($order->items, true);
        return view('backend.orders.show', compact('order'));
    }

    // Update order status
    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:Pending,Processing,Completed,Cancelled'
        ]);

        $order->status = $request->status;
        $order->save();

        return redirect()->back()->with('success', 'Order status updated!');
    }

    // Delete order
    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route('admin.order.orders.index')->with('success', 'Order deleted successfully!');
    }

     public function pending() {
        $orders = Order::where('status', 'Pending')->latest()->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }

    public function processing() {
        $orders = Order::where('status', 'Processing')->latest()->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }

    public function completed() {
        $orders = Order::where('status', 'Completed')->latest()->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }

    public function cancelled() {
        $orders = Order::where('status', 'Cancelled')->latest()->paginate(20);
        return view('backend.orders.index', compact('orders'));
    }
}
