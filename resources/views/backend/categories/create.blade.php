@extends('backend.layouts.app')
@section('title', 'Add Category')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Add New Category</h1></div>

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

                    {{-- Category Form --}}
                    <form action="{{ route('categories.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Name *</label>
                            <input 
                                type="text" 
                                name="name" 
                                id="name" 
                                class="form-control" 
                                value="{{ old('name') }}" 
                                placeholder="Enter category name" 
                                required
                            >
                        </div>

                        <div class="form-group">
                            <label>Slug (auto-generated if left blank)</label>
                            <input 
                                type="text" 
                                name="slug" 
                                id="slug" 
                                class="form-control" 
                                value="{{ old('slug') }}" 
                                placeholder="example: car-parts"
                            >
                        </div>

                        {{-- Optional Parent Category --}}
                        @if(isset($categories) && $categories->count() > 0)
                        <div class="form-group">
                            <label>Parent Category</label>
                            <select name="parent_id" class="form-control">
                                <option value="">Select Parent</option>
                                @foreach ($categories as $cat)
                                    <option value="{{ $cat->id }}">{{ $cat->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        @endif

                        <div class="form-group">
                            <label>Description</label>
                            <textarea 
                                name="description" 
                                class="form-control" 
                                rows="3" 
                                placeholder="Write a short description..."
                            >{{ old('description') }}</textarea>
                        </div>

                        <div class="form-group">
                            <label>Image</label>
                            <input type="file" name="image" class="form-control-file">
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1" {{ old('status', 1) == 1 ? 'selected' : '' }}>Active</option>
                                <option value="0" {{ old('status') == 0 ? 'selected' : '' }}>Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary">Save Category</button>
                        <a href="{{ route('categories.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@section('scripts')
<script>
    // Optional JS: auto-generate slug from name
    document.getElementById('name').addEventListener('keyup', function() {
        let slug = this.value
            .toLowerCase()
            .replace(/[^a-z0-9]+/g, '-')
            .replace(/(^-|-$)+/g, '');
        document.getElementById('slug').value = slug;
    });
</script>
@endsection
