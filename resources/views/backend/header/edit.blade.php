@extends('backend.layouts.app')
@section('title', isset($headerSetting) ? 'Edit Header Item' : 'Add Header Item')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>{{ isset($headerSetting) ? 'Edit Header Item' : 'Add Header Item' }}</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('header-settings.index') }}">Header Settings</a></div>
                <div class="breadcrumb-item">{{ isset($headerSetting) ? 'Edit' : 'Add' }}</div>
            </div>
        </div>

        <div class="section-body">
            <div class="card">
                <div class="card-body">
                    {{-- Validation Errors --}}
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form action="{{ isset($headerSetting) ? route('header-settings.update', $headerSetting->id) : route('header-settings.store') }}" method="POST">
                        @csrf
                        @if(isset($headerSetting))
                            @method('PUT')
                        @endif

                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Type *</label>
                                    <select name="type" class="form-control" required>
                                        <option value="social" {{ (old('type', $headerSetting->type ?? '') == 'social') ? 'selected' : '' }}>Social</option>
                                        <option value="contact" {{ (old('type', $headerSetting->type ?? '') == 'contact') ? 'selected' : '' }}>Contact</option>
                                        <option value="menu" {{ (old('type', $headerSetting->type ?? '') == 'menu') ? 'selected' : '' }}>Menu</option>
                                    </select>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Name</label>
                                    <input type="text" name="name" class="form-control" value="{{ old('name', $headerSetting->name ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Icon (Font Awesome class)</label>
                                    <input type="text" name="icon" class="form-control" value="{{ old('icon', $headerSetting->icon ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Value / URL</label>
                                    <input type="text" name="value" class="form-control" value="{{ old('value', $headerSetting->value ?? '') }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Order</label>
                                    <input type="number" name="order" class="form-control" value="{{ old('order', $headerSetting->order ?? 0) }}">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Status</label>
                                    <select name="status" class="form-control">
                                        <option value="1" {{ (old('status', $headerSetting->status ?? 1) == 1) ? 'selected' : '' }}>Active</option>
                                        <option value="0" {{ (old('status', $headerSetting->status ?? 1) == 0) ? 'selected' : '' }}>Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="mt-4">
                            <button type="submit" class="btn btn-primary">
                                <i class="fa fa-save"></i> {{ isset($headerSetting) ? 'Update' : 'Save' }}
                            </button>
                            <a href="{{ route('header-settings.index') }}" class="btn btn-secondary">
                                <i class="fa fa-arrow-left"></i> Back
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
