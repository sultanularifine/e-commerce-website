<?php

namespace App\Http\Controllers\User;
use App\Http\Controllers\Controller;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductPageController extends Controller
{

    public function index()
    {
        $products = Product::with(['category', 'brand'])
            ->where('status', true)
            ->orderBy('created_at', 'desc')
            ->paginate(12);  

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
    public function cart()
    {
        return view('frontend.pages.cart');
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
}
