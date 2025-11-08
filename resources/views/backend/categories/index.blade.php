@extends('backend.layouts.app')

@section('title', 'Categories List')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Categories</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                <div class="breadcrumb-item">Categories</div>
                <div class="breadcrumb-item">List</div>
            </div>
        </div>

        <div class="section-body">
            {{-- Success Message --}}
            @if ($message = Session::get('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ $message }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            @can('category-create')
                            <a href="{{ route('categories.create') }}" class="btn btn-primary">
                                <i class="fa fa-plus"></i> Add Category
                            </a>
                            <h4 class="mb-0">All Categories</h4>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered" id="categories-table">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Slug</th>
                                            <th>Status</th>
                                            <th>Created At</th>
                                            <th width="160">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($categories as $key => $category)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>
                                                    <strong>{{ $category->name }}</strong>
                                                    @if($category->image)
                                                        <br>
                                                        <img src="{{ asset($category->image) }}" alt="Image" width="50" height="50" class="mt-1 rounded">
                                                    @endif
                                                </td>
                                                <td>{{ $category->slug }}</td>
                                                <td>
                                                    <span class="badge badge-{{ $category->status ? 'success' : 'danger' }}">
                                                        {{ $category->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </td>
                                                <td>{{ $category->created_at->format('d M, Y') }}</td>
                                                <td class="d-flex align-items-center">
                                                    @can('category-edit')
                                                        <a href="{{ route('categories.edit', $category->id) }}" 
                                                           class="btn btn-sm btn-primary mr-1">
                                                            <i class="fa fa-edit"></i> Edit
                                                        </a>
                                                    @endcan
                                                    @can('category-delete')
                                                        <form action="{{ route('categories.destroy', $category->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger"
                                                                onclick="return confirm('Are you sure you want to delete this category?')">
                                                                <i class="fa fa-trash"></i> Delete
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            {{-- Laravel Pagination --}}
                            <div class="mt-3">
                                {!! $categories->links() !!}
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
        // Optional: DataTables only for client-side display
        $('#categories-table').DataTable({
            paging: false, // Disable DataTables pagination (Laravel handles it)
            info: false,
            ordering: true,
            searching: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search categories..."
            }
        });
    });
</script>
@endpush
