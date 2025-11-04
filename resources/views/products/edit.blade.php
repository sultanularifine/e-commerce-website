@extends('backend.layouts.app')
@section('title', 'Edit Product')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('products.index') }}">Products</a></div>
                <div class="breadcrumb-item">Edit Product</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="card card-primary">
                        <div class="card-body">

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

                            <form action="{{ route('products.update', $product->id) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <div class="form-group">
                                    <label><b>Name*</b></label>
                                    <input type="text" name="name" value="{{ $product->name }}" class="form-control" placeholder="Enter Product Name">
                                </div>

                                <div class="form-group">
                                    <label><b>Detail*</b></label>
                                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Enter Product Detail">{{ $product->detail }}</textarea>
                                </div>

                                <div class="text-left mt-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a class="btn btn-secondary" href="{{ route('products.index') }}">Back</a>
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
