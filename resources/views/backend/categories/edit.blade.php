@extends('backend.layouts.app')
@section('title', 'Edit Category')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Category</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('categories.index') }}">Categories</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ route('categories.update', $category->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6">
                                {{-- Name --}}
                                <div class="form-group">
                                    <label>Name *</label>
                                    <input type="text" name="name" value="{{ old('name', $category->name) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Slug --}}
                                <div class="form-group">
                                    <label>Slug *</label>
                                    <input type="text" name="slug" value="{{ old('slug', $category->slug) }}" class="form-control" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Parent Category --}}
                                <div class="form-group">
                                    <label>Parent Category</label>
                                    <select name="parent_id" class="form-control">
                                        <option value="">Select Parent</option>
                                        @foreach ($categories as $cat)
                                            <option value="{{ $cat->id }}" {{ $category->parent_id == $cat->id ? 'selected' : '' }}>
                                                {{ $cat->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Status --}}
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ $category->status == 1 ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ $category->status == 0 ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-12">
                                {{-- Description --}}
                                <div class="form-group">
                                    <label>Description</label>
                                    <textarea name="description" rows="4" class="form-control">{{ old('description', $category->description) }}</textarea>
                                </div>
                            </div>

                            <div class="col-md-6">
                                {{-- Image Upload --}}
                                <div class="form-group">
                                    <label>Category Image</label>
                                    <input type="file" name="image" class="form-control-file">
                                    @if($category->image)
                                        <div class="mt-2">
                                            <img src="{{ asset($category->image) }}" alt="Category Image" width="120" class="img-thumbnail">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> Update Category
                            </button>
                            <a href="{{ route('categories.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
