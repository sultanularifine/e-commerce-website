@extends('backend.layouts.app')
@section('title', 'Add Product')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add New Product</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('products.index') }}">Products</a></div>
                <div class="breadcrumb-item">Add Product</div>
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

                            <form action="{{ route('products.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label><b>Name*</b></label>
                                    <input type="text" name="name" class="form-control" placeholder="Enter Product Name">
                                </div>

                                <div class="form-group">
                                    <label><b>Detail*</b></label>
                                    <textarea class="form-control" style="height:150px" name="detail" placeholder="Enter Product Detail"></textarea>
                                </div>

                                <div class="text-left mt-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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
