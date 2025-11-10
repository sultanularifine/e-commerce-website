@extends('backend.layouts.app')
@section('title', 'Edit Contact Page')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Edit Contact Page</h1></div>

        <div class="section-body">
            <form action="{{ route('contact-page.update', $contactPage->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="form-group">
                    <label>Title</label>
                    <input type="text" name="title" class="form-control" value="{{ $contactPage->title }}">
                </div>

                <div class="form-group">
                    <label>Description</label>
                    <textarea name="description" class="form-control">{{ $contactPage->description }}</textarea>
                </div>

                <div class="form-group">
                    <label>Address</label>
                    <input type="text" name="address" class="form-control" value="{{ $contactPage->address }}">
                </div>

                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" class="form-control" value="{{ $contactPage->phone }}">
                </div>

                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" class="form-control" value="{{ $contactPage->email }}">
                </div>

                <div class="form-group">
                    <label>Working Hours</label>
                    <input type="text" name="working_hours" class="form-control" value="{{ $contactPage->working_hours }}">
                </div>

                <div class="form-group">
                    <label>Google Map Iframe</label>
                    <textarea name="map_iframe" class="form-control">{{ $contactPage->map_iframe }}</textarea>
                </div>

                <button type="submit" class="btn btn-success">Update Contact Page</button>
            </form>
        </div>
    </section>
</div>
@endsection
