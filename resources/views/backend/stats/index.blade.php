@extends('backend.layouts.app')

@section('title', 'Stats List')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Stats List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Stats</div>
                <div class="breadcrumb-item">Stats List</div>
            </div>
        </div>

         <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-left text-left my-1">
                                <a href="{{ route('stats.create') }}" class="btn btn-primary">Add Member</a>
                            </div>
                        </div>
                        <div class="card-body table-responsive">
                            <table class="table-striped table table-bordered" id="statsTable">
                                <thead>
                                    <tr>
                                        <th class="text-center">SL</th>
                                        <th>Value</th>
                                        <th>Title</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($stats as $index => $stat)
                                    <tr>
                                        <td>{{ $index + 1 }}</td>
                                        <td>{{ $stat->value }}</td>
                                        <td>{{ $stat->title }}</td>
                                        <td class="d-flex">
                                            <a href="{{ route('stats.edit', $stat->id) }}" class="btn btn-primary btn-sm mr-1">
                                                <i class="fas fa-pencil-alt"></i>
                                            </a>
                                            <form action="{{ route('stats.destroy', $stat->id) }}" method="POST">
                                                @csrf
                                                @method('DELETE')
                                                <button class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">
                                                    <i class="fas fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div> <!-- /.card-body -->
                    </div> <!-- /.card -->
                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script src="{{ asset('backend/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('#statsTable').DataTable();
    });
</script>
@endpush
