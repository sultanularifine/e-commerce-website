@extends('backend.layouts.app')
@section('title', 'Edit User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
                <div class="breadcrumb-item">Edit User</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-header bg-primary text-white">
                            <h4 class="mb-0">Update User Information</h4>
                        </div>

                        <div class="card-body">
                            {{-- Validation Errors --}}
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            {{-- Edit Form --}}
                            {!! Form::model($user, ['method' => 'PATCH','route' => ['users.update', $user->id]]) !!}

                            <div class="form-group">
                                <label><b>Name</b></label>
                                {!! Form::text('name', old('name', $user->name), ['placeholder' => 'Enter Name','class' => 'form-control']) !!}
                            </div>

                            <div class="form-group mt-3">
                                <label><b>Email</b></label>
                                {!! Form::text('email', old('email', $user->email), ['placeholder' => 'Enter Email','class' => 'form-control']) !!}
                            </div>

                            <div class="form-group mt-3">
                                <label><b>Password</b></label>
                                {!! Form::password('password', ['placeholder' => 'Password','class' => 'form-control']) !!}
                                <small class="text-muted">Leave blank if you do not want to change the password</small>
                            </div>

                            <div class="form-group mt-3">
                                <label><b>Confirm Password</b></label>
                                {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password','class' => 'form-control']) !!}
                            </div>

                            <div class="form-group mt-3">
                                <label><b>Role</b></label>
                                {!! Form::select('roles[]', $roles, old('roles', $userRole), ['class' => 'form-control', 'multiple']) !!}
                            </div>

                            <div class="text-left mt-4">
                                <button type="submit" class="btn btn-primary">Update User</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>

                            {!! Form::close() !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
