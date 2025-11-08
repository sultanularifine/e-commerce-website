@extends('backend.layouts.app')
@section('title', 'Edit Slider')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Edit Slider</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('slider.index') }}">Sliders</a></div>
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

                        <form action="{{ route('slider.update', $slider->id) }}" method="POST"
                            enctype="multipart/form-data">
                            @csrf @method('PUT')

                            <div class="form-group">
                                <label>Title *</label>
                                <input type="text" name="title" class="form-control"
                                    value="{{ old('title', $slider->title) }}" required>
                            </div>

                            <div class="form-group">
                                <label>Subtitle</label>
                                <input type="text" name="subtitle" class="form-control"
                                    value="{{ old('subtitle', $slider->subtitle) }}">
                            </div>

                            <div class="form-group">
                                <label>Current Image</label><br>
                                <img src="{{ asset($slider->image) }}" width="120" class="rounded mb-2"> <input type="file"
                                    name="image" class="form-control-file">
                            </div>

                            <div class="form-group">
                                <label>Status</label>
                                <select name="status" class="form-control">
                                    <option value="1" {{ old('status', $slider->status) ? 'selected' : '' }}>Active
                                    </option>
                                    <option value="0" {{ !old('status', $slider->status) ? 'selected' : '' }}>Inactive
                                    </option>
                                </select>
                            </div>

                            <button class="btn btn-primary">Update Slider</button>
                            <a href="{{ route('slider.index') }}" class="btn btn-secondary">Back</a>
                        </form>

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
