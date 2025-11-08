@extends('backend.layouts.app')
@section('title', 'Edit Product')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Product</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                    <div class="breadcrumb-item active">Edit Product</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-lg-10 col-md-12">
                        <div class="card card-primary">
                            <div class="card-body">

                                {{-- Validation Errors --}}
                                @if ($errors->any())
                                    <div class="alert alert-danger">
                                        <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                        <ul>
                                            @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif

                                <form action="{{ route('products.update', $product->id) }}" method="POST"
                                    enctype="multipart/form-data">
                                    @csrf
                                    @method('PUT')

                                    {{-- Product Name --}}
                                    <div class="form-group">
                                        <label><b>Product Name *</b></label>
                                        <input type="text" name="name" value="{{ old('name', $product->name) }}"
                                            class="form-control" required>
                                    </div>

                                    {{-- Description --}}
                                    <div class="form-group">
                                        <label><b>Description</b></label>
                                        <textarea name="description" class="form-control" rows="4">{{ old('description', $product->description) }}</textarea>
                                    </div>

                                    {{-- Price and Discount --}}
                                    <div class="form-row">
                                        <div class="form-group col-md-6">
                                            <label><b>Price *</b></label>
                                            <input type="number" name="price" value="{{ old('price', $product->price) }}"
                                                step="0.01" min="0" class="form-control" required>
                                        </div>
                                        <div class="form-group col-md-6">
                                            <label><b>Discount Price</b></label>
                                            <input type="number" name="discount_price"
                                                value="{{ old('discount_price', $product->discount_price) }}" step="0.01"
                                                min="0" class="form-control">
                                        </div>
                                    </div>

                                    {{-- Stock --}}
                                    <div class="form-group">
                                        <label><b>Stock Quantity *</b></label>
                                        <input type="number" name="stock" value="{{ old('stock', $product->stock) }}"
                                            min="0" class="form-control" required>
                                    </div>

                                    {{-- Category --}}
                                    <div class="form-group">
                                        <label><b>Category</b></label>
                                        <select name="category_id" class="form-control">
                                            <option value="">Select Category</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                                    {{ $category->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Brand --}}
                                    <div class="form-group">
                                        <label><b>Brand</b></label>
                                        <select name="brand_id" class="form-control">
                                            <option value="">Select Brand</option>
                                            @foreach ($brands as $brand)
                                                <option value="{{ $brand->id }}"
                                                    {{ $product->brand_id == $brand->id ? 'selected' : '' }}>
                                                    {{ $brand->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>

                                    {{-- Thumbnail --}}
                                    <div class="form-group">
                                        <label><b>Thumbnail</b></label><br>
                                        @if ($product->thumbnail)
                                            <img src="{{ asset($product->thumbnail) }}" width="100"
                                                class="mb-2 rounded">
                                        @endif
                                        <input type="file" name="thumbnail" class="form-control-file">
                                    </div>

                                    {{-- Gallery --}}
                                    <div class="form-group">
                                        <label><b>Gallery Images</b></label><br>
                                        @foreach ($product->images as $img)
                                            <img src="{{ asset($img->gallery) }}" width="80" class="mr-2 mb-2 rounded">
                                        @endforeach
                                        <input type="file" name="gallery[]" class="form-control-file" multiple>
                                    </div>

                                    {{-- SEO --}}
                                    <div class="form-group">
                                        <label><b>Meta Title</b></label>
                                        <input type="text" name="meta_title"
                                            value="{{ old('meta_title', $product->meta_title) }}" class="form-control">
                                    </div>

                                    <div class="form-group">
                                        <label><b>Meta Description</b></label>
                                        <textarea name="meta_description" class="form-control" rows="3">{{ old('meta_description', $product->meta_description) }}</textarea>
                                    </div>
                                    {{-- Featured Product --}}
                                    <div class="form-group">
                                        <label><b>Featured Product</b></label>
                                        <div class="form-check">
                                            <input type="checkbox" name="is_featured" value="1"
                                                class="form-check-input" id="is_featured"
                                                {{ old('is_featured', $product->is_featured) ? 'checked' : '' }}>
                                            <label class="form-check-label" for="is_featured">Mark as Featured</label>
                                        </div>
                                    </div>

                                    {{-- Status --}}
                                    <div class="form-group">
                                        <label><b>Status</b></label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $product->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $product->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>

                                    <div class="text-left mt-3">
                                        <button type="submit" class="btn btn-primary">Update Product</button>
                                        <a href="{{ route('products.index') }}" class="btn btn-secondary">Back</a>
                                    </div>
                                </form>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
