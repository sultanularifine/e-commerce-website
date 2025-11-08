@extends('backend.layouts.app')

@section('title', 'Edit Brand')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Brand</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item"><a href="{{ route('brands.index') }}">Brands</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">

                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach ($errors->all() as $error)
                                   <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('brands.update', $brand->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="form-group">
                            <label>Name *</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $brand->name) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Slug *</label>
                            <input type="text" name="slug" class="form-control" value="{{ old('slug', $brand->slug) }}" required>
                        </div>

                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" class="form-control">{{ old('description', $brand->description) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Current Logo</label><br>
                            @if($brand->logo)
                                <img src="{{ asset($brand->logo) }}" width="120" class="mb-2 rounded">
                            @else
                                <p>No logo uploaded</p>
                            @endif
                            <input type="file" name="logo" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ $brand->status ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ !$brand->status ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Update Brand</button>
                        <a href="{{ route('brands.index') }}" class="btn btn-secondary">Back</a>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection
