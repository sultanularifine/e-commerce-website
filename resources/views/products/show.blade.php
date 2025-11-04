@extends('backend.layouts.app')
@section('title', 'View Product')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>View Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('products.index') }}">Products</a></div>
                <div class="breadcrumb-item">View Product</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="card">
                        <div class="card-body">
                            <h3 class="mb-3">{{ $product->name }}</h3>
                            <p>{{ $product->detail }}</p>
                        </div>
                        <div class="card-footer text-left">
                            <a class="btn btn-primary" href="{{ route('products.index') }}">Back</a>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
