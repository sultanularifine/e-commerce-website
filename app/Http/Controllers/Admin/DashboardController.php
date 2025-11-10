<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Todo;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function index($editId = null)
    { 
        $data = Todo::all();
        $totalSales = Order::where('status', 'completed')->sum('total');
        $totalOrders = Order::count();
        $newCustomers = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $totalProducts = Product::count();

        $lowStockProducts = Product::where('stock', '<=', 5)->get();

        $recentActivities = Order::latest()->take(5)->get();

        $salesReport = ['labels' => [], 'data' => []];
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::now()->subDays($i);
            $salesReport['labels'][] = $date->format('d M');
            $sales = Order::whereDate('created_at', $date)
                ->where('status', 'completed')
                ->sum('total');
            $salesReport['data'][] = $sales;
        }

        $topProductsQuery = Product::all()->map(function ($product) {
            $sold_units = Order::where('status', 'completed')
                ->whereJsonContains('items', ['product_id' => $product->id])
                ->count();
            $product->sold_units = $sold_units;
            return $product;
        })->sortByDesc('sold_units')->take(5);

        $topProducts = [
            'labels' => $topProductsQuery->pluck('name'),
            'data' => $topProductsQuery->pluck('sold_units')
        ];

        $productPerformanceQuery = Product::select(
            DB::raw("SUM(CASE WHEN stock > 20 THEN 1 ELSE 0 END) as high_stock"),
            DB::raw("SUM(CASE WHEN stock BETWEEN 6 AND 20 THEN 1 ELSE 0 END) as medium_stock"),
            DB::raw("SUM(CASE WHEN stock <= 5 THEN 1 ELSE 0 END) as low_stock")
        )->first();

        $productPerformance = [
            'labels' => ['High Stock', 'Medium Stock', 'Low Stock'],
            'data' => [
                $productPerformanceQuery->high_stock,
                $productPerformanceQuery->medium_stock,
                $productPerformanceQuery->low_stock
            ]
        ];

        $newCustomerCount = User::where('created_at', '>=', Carbon::now()->subMonth())->count();
        $returningCustomerCount = User::where('created_at', '<', Carbon::now()->subMonth())->count();

        $customerReport = [
            'labels' => ['New Customers', 'Returning Customers'],
            'data' => [$newCustomerCount, $returningCustomerCount]
        ];

        return view('backend.dashboard', compact(
            'totalSales',
            'totalOrders',
            'newCustomers',
            'totalProducts',
            'lowStockProducts',
            'recentActivities',
            'salesReport',
            'topProducts',
            'productPerformance',
            'customerReport',
            'data',
            'editId'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'time' => 'required',
            'date' => 'required',
        ]);

        $todo = new Todo();
        $todo->name = $request->name;
        $todo->time = $request->time;
        $todo->date = $request->date;
        $todo->save();
        return redirect()->back();
    }
    
    public function update(Request $request, $id)
    {

        $todo = Todo::find($id);
        $todo->name = $request->name;
        $todo->time = $request->time;
        $todo->date = $request->date;
        $todo->save();

        return redirect()->route('dashboard');
    }
    public function destroy($id)
    {
        $todo = Todo::find($id);
        if ($todo->delete()) {
            return redirect()->back();
        }
    }
}
