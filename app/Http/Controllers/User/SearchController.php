<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('query');

        if(!$query){
            return redirect()->back(); 
        }

        // Use paginate instead of get()
        $products = Product::where('name', 'like', "%$query%")->paginate(12); // 12 items per page

        return view('frontend.pages.search.results', compact('products', 'query'));
    }
}
