@extends('backend.layouts.app')
@section('title', 'Create New User')

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Create New User</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('users.index') }}">Users</a></div>
                    <div class="breadcrumb-item">Create User</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row justify-content-center">
                    <div class="col-lg-12 col-md-10">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        {!! Form::open(['route' => 'users.store', 'method' => 'POST']) !!}
                        <div class="card">
                            <div class="card-body">
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label><b>Name*</b></label>
                                        {!! Form::text('name', old('name'), ['placeholder' => 'Name', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>Email*</b></label>
                                        {!! Form::text('email', old('email'), ['placeholder' => 'Email', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group col-md-6">
                                        <label><b>Password*</b></label>
                                        {!! Form::password('password', ['placeholder' => 'Password', 'class' => 'form-control']) !!}
                                    </div>
                                    <div class="form-group col-md-6">
                                        <label><b>Confirm Password*</b></label>
                                        {!! Form::password('confirm-password', ['placeholder' => 'Confirm Password', 'class' => 'form-control']) !!}
                                    </div>
                                </div>
                              <div class="form-group">
    <label><b>Roles*</b></label>
    <div class="row">
        @foreach($roles as $id => $roleName)
            <div class="col-md-3">
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="roles[]" value="{{ $id }}" 
                        {{ (is_array(old('roles')) && in_array($id, old('roles'))) ? 'checked' : '' }}>
                    <label class="form-check-label">{{ $roleName }}</label>
                </div>
            </div>
        @endforeach
    </div>
</div>


                            </div>
                            <div class="card-footer text-center">
                                <button type="submit" class="btn btn-primary">Submit</button>
                                <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
                            </div>
                        </div>
                        {!! Form::close() !!}

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
