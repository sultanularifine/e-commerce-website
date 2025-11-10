@extends('backend.layouts.app')

@section('title', 'Edit Stat')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Edit Stat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('stats.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('stats.index') }}">Stats</a></div>
                <div class="breadcrumb-item">Edit</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header"><h4>Edit Stat</h4></div>
                        <div class="card-body">
                            <form action="{{ route('stats.update', $stat->id) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" name="value" class="form-control" value="{{ $stat->value }}" required>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" value="{{ $stat->title }}" required>
                                </div>
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                                <a href="{{ route('stats.index') }}" class="btn btn-secondary">Cancel</a>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
@endsection
