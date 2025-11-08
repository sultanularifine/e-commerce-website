<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\RedirectResponse;

class ProductController extends Controller
{

    public function index()
    {
        $products = Product::with('category', 'brand', 'images')->latest()->paginate(10);
        return view('backend.products.index', compact('products'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('backend.products.create', compact('categories', 'brands'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'discount_price' => 'nullable|numeric|min:0',
            'stock'          => 'required|integer|min:0',
            'category_id'    => 'nullable|exists:categories,id',
            'brand_id'       => 'nullable|exists:brands,id',
            'thumbnail'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*'      => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title'     => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status'          => 'required|boolean',
        ]);

        // Create product
        $product = new Product();
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->discount_price = $validated['discount_price'] ?? null;
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'] ?? null;
        $product->brand_id = $validated['brand_id'] ?? null;
        $product->meta_title = $validated['meta_title'] ?? null;
        $product->meta_description = $validated['meta_description'] ?? null;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->status = $validated['status'] ?? null;

        // Thumbnail upload
        if ($request->hasFile('thumbnail')) {
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailPath = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('backend/thumbnails'), $thumbnailPath);
            $product->thumbnail = 'backend/thumbnails/' . $thumbnailPath;
        }

        $product->save();

        // Gallery images upload
        if ($request->hasFile('gallery')) {
            foreach ($request->file('gallery') as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;

                $imagePath = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('backend/gallery'), $imagePath);
                $productImage->gallery = 'backend/gallery/' . $imagePath;

                $productImage->save();
            }
        }

        return redirect()->route('products.index')->with('success', 'Product created successfully.');
    }




    public function edit(Product $product)
    {
        $categories = Category::all();
        $brands = Brand::all();
        return view('backend.products.edit', compact('product', 'categories', 'brands'));
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'name'            => 'required|string|max:255',
            'description'     => 'nullable|string',
            'price'           => 'required|numeric|min:0',
            'discount_price'  => 'nullable|numeric|min:0',
            'stock'           => 'required|integer|min:0',
            'category_id'     => 'nullable|exists:categories,id',
            'brand_id'        => 'nullable|exists:brands,id',
            'thumbnail'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'gallery.*'       => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'meta_title'      => 'nullable|string|max:255',
            'meta_description' => 'nullable|string',
            'status'          => 'required|boolean',
        ]);

        // Update product fields
        $product->name = $validated['name'];
        $product->slug = Str::slug($validated['name']);
        $product->description = $validated['description'] ?? null;
        $product->price = $validated['price'];
        $product->discount_price = $validated['discount_price'] ?? null;
        $product->stock = $validated['stock'];
        $product->category_id = $validated['category_id'] ?? null;
        $product->brand_id = $validated['brand_id'] ?? null;
        $product->meta_title = $validated['meta_title'] ?? null;
        $product->meta_description = $validated['meta_description'] ?? null;
        $product->is_featured = $request->has('is_featured') ? 1 : 0;
        $product->status = $validated['status'] ?? null;

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
                unlink(public_path($product->thumbnail));
            }
            $thumbnailFile = $request->file('thumbnail');
            $thumbnailPath = time() . '_' . $thumbnailFile->getClientOriginalName();
            $thumbnailFile->move(public_path('backend/thumbnails'), $thumbnailPath);
            $product->thumbnail = 'backend/thumbnails/' . $thumbnailPath;
        }

        $product->save();

        // Handle gallery images
        if ($request->hasFile('gallery')) {
            // Delete old gallery images
            foreach ($product->images as $oldImage) {
                if (file_exists(public_path($oldImage->gallery))) {
                    unlink(public_path($oldImage->gallery));
                }
                $oldImage->delete();
            }

            // Upload new gallery images
            foreach ($request->file('gallery') as $image) {
                $productImage = new ProductImage();
                $productImage->product_id = $product->id;

                $imagePath = time() . '_' . $image->getClientOriginalName();
                $image->move(public_path('backend/gallery'), $imagePath);
                $productImage->gallery = 'backend/gallery/' . $imagePath;

                $productImage->save();
            }
        }

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }


    /**
     * Remove the specified product.
     */
    public function destroy(Product $product): RedirectResponse
    {
        // Delete thumbnail
        if ($product->thumbnail && file_exists(public_path($product->thumbnail))) {
            unlink(public_path($product->thumbnail));
        }

        // Delete gallery images
        foreach ($product->images as $image) {
            if ($image->gallery && file_exists(public_path($image->gallery))) {
                unlink(public_path($image->gallery));
            }
            $image->delete();
        }

        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }

    public function show(Product $product)
    {
        return view('backend.products.show', compact('product'));
    }
    public function toggleStatus(Product $product)
{
    $product->status = !$product->status;
    $product->save();

    return response()->json([
        'success' => true,
        'status' => $product->status ? 'Active' : 'Inactive'
    ]);
}

}
