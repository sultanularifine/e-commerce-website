@extends('backend.layouts.app')

@section('title', 'Users Management')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Users Management</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Users</div>
                    <div class="breadcrumb-item">Users List</div>
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
                                    <a href="{{ route('users.create') }}" class="btn btn-primary">Create New User</a>
                                </div>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table-striped table" id="users-table">
                                        <thead>
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th>Name</th>
                                                <th>Email</th>
                                                <th>Roles</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($data as $user)
                                                <tr>
                                                    <td></td> <!-- Serial number handled by DataTables -->
                                                    <td>{{ $user->name }}</td>
                                                    <td>{{ $user->email }}</td>
                                                    <td>
                                                        @if (!empty($user->getRoleNames()))
                                                            @foreach ($user->getRoleNames() as $role)
                                                                <label
                                                                    class="badge badge-success">{{ $role }}</label>
                                                            @endforeach
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        <!-- Show Button (always visible if user can view) -->
                                                        @can('user-list')
                                                            <a class="btn btn-info btn-sm me-1"
                                                                href="{{ route('users.show', $user->id) }}" title="Show">
                                                                <i class="fa-solid fa-eye"></i>
                                                            </a>
                                                        @endcan

                                                        <!-- Edit Button -->
                                                        @can('user-edit')
                                                            <a class="btn btn-primary btn-sm me-1"
                                                                href="{{ route('users.edit', $user->id) }}" title="Edit">
                                                                <i class="fas fa-pencil-alt"></i>
                                                            </a>
                                                        @endcan

                                                        <!-- Delete Button -->
                                                        @can('user-delete')
                                                            {!! Form::open(['method' => 'DELETE', 'route' => ['users.destroy', $user->id], 'style' => 'display:inline']) !!}
                                                            <button class="btn btn-danger btn-sm" title="Delete"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                            {!! Form::close() !!}
                                                        @endcan
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>

                                    {!! $data->render() !!} <!-- Optional: DataTables pagination will override -->
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
            var t = $('#users-table').DataTable({
                "columnDefs": [{
                        "orderable": false,
                        "targets": 4
                    } // Disable sorting on Action column
                ]
            });

            // Add dynamic serial numbers
            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                });
            }).draw();
        });
    </script>
@endpush
