@extends('backend.layouts.app')

@section('title', 'Brands List')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Brands</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item">Brands</div>
                    <div class="breadcrumb-item">Brands List</div>
                </div>
            </div>

            <div class="section-body">
                @if ($message = Session::get('success'))
                    <div class="alert alert-success">{{ $message }}</div>
                @endif

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h4>All Brands</h4>
                        @can('brand-create')
                            <a href="{{ route('brands.create') }}" class="btn btn-primary">Add Brand</a>
                        @endcan
                    </div>

                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped" id="brands-table">
                                <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Logo</th>
                                        <th>Name</th>
                                        <th>Slug</th>
                                        <th>Description</th>
                                        <th>Status</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($brands as $brand)
                                        <tr>
                                            <td></td> <!-- Serial number handled by DataTables -->
                                            <td>
                                                @if ($brand->logo)
                                                    <img src="{{ asset($brand->logo) }}" width="80" class="rounded">
                                                @else
                                                    -
                                                @endif
                                            </td>
                                            <td>{{ $brand->name }}</td>
                                            <td>{{ $brand->slug }}</td>
                                            <td>{{ Str::limit($brand->description, 50) ?? '-' }}</td>
                                            <td>
                                                @if ($brand->status)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-danger">Inactive</span>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                @can('brand-edit')
                                                    <a href="{{ route('brands.edit', $brand->id) }}"
                                                        class="btn btn-primary btn-sm mr-1">
                                                        <i class="fa fa-edit"></i>
                                                    </a>
                                                @endcan
                                                @can('brand-delete')
                                                    <form action="{{ route('brands.destroy', $brand->id) }}" method="POST"
                                                        style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger btn-sm"
                                                            onclick="return confirm('Are you sure?')">
                                                            <i class="fa fa-trash"></i>
                                                        </button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

                            {!! $brands->links() !!} <!-- Pagination fallback -->
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
            var t = $('#brands-table').DataTable({
                "columnDefs": [{
                    "orderable": false,
                    "targets": 6
                }] // Disable sorting on Action column
            });

            // Serial numbers
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
