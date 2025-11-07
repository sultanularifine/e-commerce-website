@extends('backend.layouts.app')
@section('title', 'View Product')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>View Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('products.index') }}">Products</a></div>
                <div class="breadcrumb-item active">View Product</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-10 col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <h3>{{ $product->name }}</h3>
                            <p><strong>Description:</strong> {{ $product->description }}</p>
                            <p><strong>Category:</strong> {{ $product->category?->name ?? '-' }}</p>
                            <p><strong>Brand:</strong> {{ $product->brand?->name ?? '-' }}</p>
                            <p><strong>Price:</strong> ${{ number_format($product->price,2) }}</p>
                            @if($product->discount_price)
                                <p><strong>Discount Price:</strong> ${{ number_format($product->discount_price,2) }}</p>
                            @endif
                            <p><strong>Stock:</strong> {{ $product->stock }}</p>
                            <p><strong>Status:</strong> {{ $product->status ? 'Active' : 'Inactive' }}</p>

                            {{-- Thumbnail --}}
                            @if ($product->thumbnail)
                                <p><strong>Thumbnail:</strong></p>
                                <img src="{{ asset($product->thumbnail) }}" alt="Thumbnail" width="150" class="mb-2 rounded">
                            @endif

                            {{-- Gallery --}}
                            @if ($product->images->count() > 0)
                                <p><strong>Gallery:</strong></p>
                                @foreach ($product->images as $img)
                                    <img src="{{ asset($img->gallery) }}" alt="Gallery Image" width="100" class="mr-2 mb-2 rounded">
                                @endforeach
                            @endif

                            {{-- SEO --}}
                            @if($product->meta_title)
                                <p><strong>Meta Title:</strong> {{ $product->meta_title }}</p>
                            @endif
                            @if($product->meta_description)
                                <p><strong>Meta Description:</strong> {{ $product->meta_description }}</p>
                            @endif
                        </div>
                        <div class="card-footer text-left">
                            <a class="btn btn-secondary" href="{{ route('products.index') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
