@extends('backend.layouts.app')

@section('title', 'Team Members List')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Team Members List</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item"><a href="#">Team Members</a></div>
                <div class="breadcrumb-item">Team Members List</div>
            </div>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-left text-left my-1">
                                <a href="{{ route('team-members.create') }}" class="btn btn-primary">Add Member</a>
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="table-1">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Image</th>
                                            <th>Name</th>
                                            <th>Role</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($teamMembers as $index => $member)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                @if($member->image)
                                                    <img src="{{ asset('storage/'.$member->image) }}" width="60px" height="60px" class="rounded">
                                                @else
                                                    <img src="https://via.placeholder.com/60" width="60px" height="60px" class="rounded">
                                                @endif
                                            </td>
                                            <td>{{ $member->name }}</td>
                                            <td>{{ $member->role }}</td>
                                            <td class="d-flex">
                                                <a href="{{ route('team-members.edit', $member->id) }}" class="btn btn-primary btn-action btn-sm mr-1" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-pencil-alt"></i>
                                                </a>

                                                <form action="{{ route('team-members.destroy', $member->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button class="btn btn-danger btn-sm btn-action" data-toggle="tooltip" title="Delete" onclick="return confirm('Are you sure?')">
                                                        <i class="fas fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div> <!-- /.table-responsive -->
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
        $('#table-1').DataTable();
    });
</script>
@endpush
