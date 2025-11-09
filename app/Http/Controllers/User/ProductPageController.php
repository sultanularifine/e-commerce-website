<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{

    public function index(Request $request)
{
    $sort = $request->query('sort');
    $categorySlug = $request->query('category');
    $brandSlug = $request->query('brand');

    $products = Product::with(['category', 'brand'])
        ->where('status', true);

    // Filter by category
    if ($categorySlug) {
        $category = Category::where('slug', $categorySlug)->first();
        if ($category) {
            $products->where('category_id', $category->id);
        }
    }

    // Filter by brand
    if ($brandSlug) {
        $brand = Brand::where('slug', $brandSlug)->first();
        if ($brand) {
            $products->where('brand_id', $brand->id);
        }
    }

    // Sorting
    if ($sort === 'name') {
        $products->orderBy('name', 'asc');
    } elseif ($sort === 'price') {
        $products->orderByRaw('COALESCE(discount_price, price) ASC');
    } else {
        $products->orderBy('created_at', 'asc');
    }

    // Pagination
    $products = $products->paginate(12);

    // Sidebar data
    $categories = Category::where('status', true)->get();
    $brands = Brand::where('status', true)->get();
    $featuredProducts = Product::where('is_featured', true)
        ->where('status', true)
        ->take(5)
        ->get();

    return view('frontend.pages.products', compact('products', 'categories', 'brands', 'featuredProducts'));
}



    public function create()
    {
        //
    }


    public function store(Request $request)
    {
        //
    }


    public function show($slug)
    {
        $product = Product::where('slug', $slug)->firstOrFail();

        // Get related products (same category, exclude current)
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->take(4)
            ->get();

        return view('frontend.pages.show', compact('product', 'relatedProducts'));
    }



    public function edit(string $id)
    {
        //
    }


    public function update(Request $request, string $id)
    {
        //
    }


    public function destroy(string $id)
    {
        //
    }



    public function newArrivals(Request $request)
    {
        $sort = $request->get('sort', 'latest');

        // 🔹 Get products created in the last 3 days
        $query = Product::where('created_at', '>=', Carbon::now()->subDays(3));

        // 🔹 Sorting logic (same as All Products page)
        if ($sort === 'name') {
            $query->orderBy('name', 'asc');
        } elseif ($sort === 'price') {
            $query->orderByRaw('COALESCE(discount_price, price)');
        } else {
            $query->latest();
        }

        // 🔹 Paginate results
        $products = $query->paginate(12);

        // 🔹 Sidebar data (same as product page)
        $categories = Category::withCount('products')->get();
        $brands = Brand::withCount('products')->get();
        $featuredProducts = Product::where('is_featured', 1)->take(4)->get();

        return view('frontend.pages.new-arrivals', compact('products', 'categories', 'brands', 'featuredProducts'));
    }
}
