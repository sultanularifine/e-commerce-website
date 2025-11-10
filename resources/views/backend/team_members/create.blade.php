@extends('backend.layouts.app')
@section('title', 'Add Team Member')

@push('style')
    <!-- CSS Libraries -->
    <link rel="stylesheet" href="{{ asset('backend/library/summernote/dist/summernote-bs4.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add Team Member</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('team-members.index') }}">Team Members</a></div>
                <div class="breadcrumb-item">Add Team Member</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card card-primary card-body">
                        <form action="{{ route('team-members.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label><b>Name*</b></label>
                                    <input type="text" class="form-control" name="name" placeholder="Full Name" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label><b>Role*</b></label>
                                    <input type="text" class="form-control" name="role" placeholder="e.g. Product Manager" required>
                                </div>
                            </div>

                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label><b>Image</b></label>
                                    <div class="custom-file">
                                        <input type="file" class="custom-file-input" id="imageFile" name="image">
                                        <label class="custom-file-label" for="imageFile">Choose file</label>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group mt-3 text-left">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('team-members.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </form>

                        @if ($errors->any())
                            <div class="mt-3">
                                <ul class="text-danger">
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
    <!-- JS Libraries -->
    <script src="{{ asset('backend/library/summernote/dist/summernote-bs4.min.js') }}"></script>
@endpush
