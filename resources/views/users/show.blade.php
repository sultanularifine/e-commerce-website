@extends('backend.layouts.app')
@section('title', 'View User')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>View User</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
                <div class="breadcrumb-item">View User</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <strong>Name:</strong>
                                <p>{{ $user->name }}</p>
                            </div>

                            <div class="form-group mb-3">
                                <strong>Email:</strong>
                                <p>{{ $user->email }}</p>
                            </div>

                            <div class="form-group">
                                <strong>Roles:</strong>
                                <br/>
                                @if(!empty($user->getRoleNames()))
                                    @foreach($user->getRoleNames() as $role)
                                        <span class="badge bg-success text-light">{{ $role }}</span>
                                    @endforeach
                                @else
                                    <p>No roles assigned</p>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-left">
                            <a class="btn btn-primary" href="{{ route('users.index') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
