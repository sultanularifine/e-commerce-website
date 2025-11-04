@extends('backend.layouts.app')

@section('title', 'Roles List')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Role Management</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Roles</div>
                <div class="breadcrumb-item">Roles List</div>
            </div>
        </div>

        <div class="section-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">
                    <p>{{ $message }}</p>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-left text-left my-1">
                                @can('role-create')
                                    <a href="{{ route('roles.create') }}" class="btn btn-primary">Create New Role</a>
                                @endcan
                            </div>
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table-striped table" id="roles-table">
                                    <thead>
                                        <tr>
                                            <th class="text-center">SL</th>
                                            <th>Name</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $key => $role)
                                            <tr>
                                                <td></td> <!-- Serial number will be handled by DataTables -->
                                                <td>{{ $role->name }}</td>
                                                <td class="d-flex">
                                                    <a class="btn btn-info btn-sm mr-1" href="{{ route('roles.show',$role->id) }}" title="Show"><i class="fa-solid fa-eye"></i></a>

                                                    @can('role-edit')
                                                        <a class="btn btn-primary btn-sm mr-1" href="{{ route('roles.edit',$role->id) }}" title="Edit"><i class="fas fa-pencil-alt"></i></a>
                                                    @endcan

                                                    @can('role-delete')
                                                        {!! Form::open(['method' => 'DELETE','route' => ['roles.destroy', $role->id],'style'=>'display:inline']) !!}
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure?')"><i class="fas fa-trash"></i></button>
                                                        {!! Form::close() !!}
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $roles->render() !!} <!-- Optional, DataTables pagination will override -->
                            </div>
                        </div>
                    </div>
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
            var t = $('#roles-table').DataTable({
                "columnDefs": [
                    { "orderable": false, "targets": 2 } // Disable sorting on Action column
                ]
            });

            // Add serial number
            t.on('order.dt search.dt', function () {
                t.column(0, {search:'applied', order:'applied'}).nodes().each(function (cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endpush
