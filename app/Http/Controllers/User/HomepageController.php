<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\Slider;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    public function index()
    {
        $sliders = Slider::where('status', true)
            ->orderBy('created_at', 'desc')
            ->get();

        $newArrivals = Product::where('status', true)
            ->orderBy('created_at', 'desc')
            ->take(5)
            ->get();

        $brands = Brand::where('status', true)
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        $categories = Category::where('status', true)
            ->orderBy('name', 'asc')
            ->get();

        return view('frontend.pages.home', compact('sliders', 'newArrivals', 'brands', 'categories'));
    }
    public function about()
    {
        return view('frontend.pages.about');
    }
}
