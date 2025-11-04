@extends('backend.layouts.app')
@section('title', 'View Role')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>View Role</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('roles.index') }}">Roles</a></div>
                <div class="breadcrumb-item">View Role</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-10">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="form-group mb-3">
                                <strong>Role Name:</strong>
                                <p>{{ $role->name }}</p>
                            </div>

                            <div class="form-group">
                                <strong>Permissions:</strong>
                                <br/>
                                @if(!empty($rolePermissions))
                                    @foreach($rolePermissions as $permission)
                                        <span class="badge bg-success text-light">{{ $permission->name }}</span>
                                    @endforeach
                                @else
                                    <p>No permissions assigned</p>
                                @endif
                            </div>
                        </div>

                        <div class="card-footer text-left">
                            <a class="btn btn-primary" href="{{ route('roles.index') }}">Back</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
