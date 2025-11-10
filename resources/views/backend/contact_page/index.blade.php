@extends('backend.layouts.app')
@section('title', 'Manage Contact Page')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Contact Page</h1></div>

        <div class="section-body">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            @if($contactPage)
                <div class="card">
                    <div class="card-body">
                        <p><strong>Title:</strong> {{ $contactPage->title }}</p>
                        <p><strong>Description:</strong> {{ $contactPage->description }}</p>
                        <p><strong>Address:</strong> {{ $contactPage->address }}</p>
                        <p><strong>Phone:</strong> {{ $contactPage->phone }}</p>
                        <p><strong>Email:</strong> {{ $contactPage->email }}</p>
                        <p><strong>Working Hours:</strong> {{ $contactPage->working_hours }}</p>
                        <div>{!! $contactPage->map_iframe !!}</div>

                        <a href="{{ route('contact-page.edit', $contactPage->id) }}" class="btn btn-primary mt-3">Edit Contact Page</a>
                    </div>
                </div>
            @else
                <p>No contact page found.</p>
            @endif
        </div>
    </section>
</div>
@endsection
