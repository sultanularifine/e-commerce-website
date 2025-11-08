@extends('backend.layouts.app')
@section('title', 'Add Slider')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add Slider</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('slider.index') }}">Sliders</a></div>
                <div class="breadcrumb-item">Add</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('slider.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label>Title *</label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group">
                            <label>Subtitle</label>
                            <input type="text" name="subtitle" class="form-control">
                        </div>

                        <div class="form-group">
                            <label>Image *</label>
                            <input type="file" name="image" class="form-control-file" required>
                        </div>

                        <div class="form-group">
                            <label>Status</label>
                            <select name="status" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button class="btn btn-primary">Save Slider</button>
                        <a href="{{ route('slider.index') }}" class="btn btn-secondary">Back</a>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
