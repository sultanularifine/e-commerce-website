@extends('backend.layouts.app')
@section('title', 'Edit About Page')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>About Page</h1></div>

        <form action="{{ route('about.update', $about->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label>Title</label>
                <input name="title" class="form-control" value="{{ $about->title }}">
            </div>

            <div class="form-group">
                <label>Subtitle</label>
                <input name="subtitle" class="form-control" value="{{ $about->subtitle }}">
            </div>

            <div class="form-group">
                <label>Who We Are</label>
                <textarea name="who_we_are" class="form-control" rows="4">{{ $about->who_we_are }}</textarea>
            </div>

            <div class="form-group">
                <label>Our Story</label>
                <textarea name="our_story" class="form-control" rows="4">{{ $about->our_story }}</textarea>
            </div>

            <div class="form-group">
                <label>Image</label>
                <input type="file" name="image" class="form-control">
                @if($about->image)
                    <img src="{{ asset('storage/'.$about->image) }}" width="150" class="mt-2">
                @endif
            </div>

            <button type="submit" class="btn btn-primary">Save</button>
        </form>
    </section>
</div>
@endsection
