@extends('backend.layouts.app')
@section('title', 'Profile Settings')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header"><h1>Profile Settings</h1></div>

        <div class="card card-primary">
            <div class="card-body">
                @if(session('success'))
                    <div class="alert alert-success">{{ session('success') }}</div>
                @endif

                <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="form-group">
                        <label>Name</label>
                        <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                    </div>

                    <div class="form-group">
                        <label>New Password</label>
                        <input type="password" name="password" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Confirm Password</label>
                        <input type="password" name="password_confirmation" class="form-control">
                    </div>

                    <div class="form-group">
                        <label>Avatar</label>
                        <input type="file" name="avatar" class="form-control-file">
                        @if($user->avatar)
                            <img src="{{ asset('uploads/avatars/'.$user->avatar) }}" width="120" class="mt-2">
                        @endif
                    </div>

                    <button type="submit" class="btn btn-success">Update Profile</button>
                    <a href="{{ route('profile.show') }}" class="btn btn-secondary">Back</a>
                </form>
            </div>
        </div>
    </section>
</div>
@endsection
