@extends('backend.layouts.app')

@section('title', 'Add New Stat')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Add New Stat</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('stats.index') }}">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="{{ route('stats.index') }}">Stats</a></div>
                <div class="breadcrumb-item">Add New</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12">
                    <div class="card">
                        <div class="card-header"><h4>Add Stat</h4></div>
                        <div class="card-body">
                            <form action="{{ route('stats.store') }}" method="POST">
                                @csrf
                                <div class="form-group">
                                    <label>Value</label>
                                    <input type="text" name="value" class="form-control" placeholder="e.g. 10K+" required>
                                </div>
                                <div class="form-group">
                                    <label>Title</label>
                                    <input type="text" name="title" class="form-control" placeholder="e.g. Happy Customers" required>
                                </div>
                                <button type="submit" class="btn btn-success">Add Stat</button>
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
