@extends('backend.layouts.app')
@section('title', 'Edit Footer Item')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Footer Item</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item">Edit Footer</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card-body card card-primary">
                            <form action="{{ route('footer.update', $footer->id) }}" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label><b>Type*</b></label>
                                        <select name="type" class="form-control" required>
                                            <option value="logo" {{ $footer->type == 'logo' ? 'selected' : '' }}>Logo
                                            </option>
                                            <option value="menu" {{ $footer->type == 'menu' ? 'selected' : '' }}>Menu
                                            </option>
                                            <option value="newsletter"
                                                {{ $footer->type == 'newsletter' ? 'selected' : '' }}>Newsletter</option>
                                            <option value="social" {{ $footer->type == 'social' ? 'selected' : '' }}>Social
                                            </option>
                                            <option value="contact" {{ $footer->type == 'contact' ? 'selected' : '' }}>
                                                Contact</option>
                                            <option value="other" {{ $footer->type == 'other' ? 'selected' : '' }}>Other
                                            </option>
                                        </select>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label><b>Name</b></label>
                                        <input type="text" class="form-control" name="name"
                                            value="{{ $footer->name }}">
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label><b>Value</b></label>
                                        <input type="text" class="form-control" name="value"
                                            value="{{ $footer->value }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label><b>Order</b></label>
                                        <input type="number" class="form-control" name="order"
                                            value="{{ $footer->order }}">
                                    </div>

                                    <div class="form-group col-md-3">
                                        <label><b>Status</b></label>
                                        <select name="status" class="form-control">
                                            <option value="1" {{ $footer->status == 1 ? 'selected' : '' }}>Active
                                            </option>
                                            <option value="0" {{ $footer->status == 0 ? 'selected' : '' }}>Inactive
                                            </option>
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label><b>Logo (optional)</b></label>
                                        <div class="custom-file">
                                            <input type="file" class="custom-file-input" id="logoFile" name="logo">
                                            <label class="custom-file-label" for="logoFile">Choose new logo</label>
                                        </div>
                                        <div class="mt-2">

                                            @if ($footer->logo && file_exists(public_path('uploads/footer/' . $footer->logo)))
                                                <img id="logoPreview" src="{{ asset('uploads/footer/' . $footer->logo) }}"
                                                    width="120"
                                                    style="border:1px solid #ddd;padding:3px;border-radius:4px;">
                                            @else
                                                <img id="logoPreview" src="" style="display:none;" width="120">
                                            @endif
                                        </div>

                                    </div>
                                </div>

                                <div class="form-group mb-0">
                                    <label><b>Description (optional)</b></label>
                                    <textarea class="form-control summernote" name="description" data-height="150">{{ $footer->description }}</textarea>
                                </div>

                                <div class="card-left text-left my-3">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                    <a href="{{ route('footer.index') }}" class="btn btn-secondary">Cancel</a>
                                </div>
                            </form>

                            @if ($errors->any())
                                <div class="alert alert-danger mt-3">
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/library/summernote/dist/summernote-bs4.min.js') }}"></script>
    <script>
        document.getElementById('logoFile').addEventListener('change', function(e) {
            const reader = new FileReader();
            reader.onload = function() {
                const img = document.getElementById('logoPreview');
                img.src = reader.result;
                img.style.display = 'block';
            }
            reader.readAsDataURL(e.target.files[0]);
        });
    </script>
@endpush
