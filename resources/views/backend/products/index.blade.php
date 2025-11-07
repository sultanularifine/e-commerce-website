@extends('backend.layouts.app')

@section('title', 'Products List')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Products</h1>
            <div class="section-header-breadcrumb">
                <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                <div class="breadcrumb-item">Products</div>
                <div class="breadcrumb-item">Products List</div>
            </div>
        </div>

        <div class="section-body">
            @if ($message = Session::get('success'))
                <div class="alert alert-success">{{ $message }}</div>
            @endif

            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h4>All Products</h4>
                            @can('product-create')
                                <a href="{{ route('products.create') }}" class="btn btn-primary">Add Product</a>
                            @endcan
                        </div>

                        <div class="card-body">
                            <div class="table-responsive">
                                <table class="table table-striped" id="products-table">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Name</th>
                                            <th>Category</th>
                                            <th>Brand</th>
                                            <th>Price</th>
                                            <th>Stock</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($products as $product)
                                            <tr>
                                                <td></td> <!-- Serial number handled by DataTables -->
                                                <td>{{ $product->name }}</td>
                                                <td>{{ $product->category?->name ?? '-' }}</td>
                                                <td>{{ $product->brand?->name ?? '-' }}</td>
                                                <td>${{ number_format($product->price, 2) }}</td>
                                                <td>{{ $product->stock }}</td>
                                                <td class="d-flex">
                                                    <a href="{{ route('products.show', $product->id) }}" class="btn btn-info btn-sm mr-1" title="View">
                                                        <i class="fa fa-eye"></i>
                                                    </a>

                                                    @can('product-edit')
                                                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary btn-sm mr-1" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                    @endcan

                                                    @can('product-delete')
                                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete" onclick="return confirm('Are you sure?')">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    @endcan
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                                {!! $products->links() !!} <!-- Pagination fallback -->
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
        var t = $('#products-table').DataTable({
            "columnDefs": [{ "orderable": false, "targets": 6 }]
        });

        // Serial numbers
        t.on('order.dt search.dt', function () {
            t.column(0, { search:'applied', order:'applied' }).nodes().each(function (cell, i) {
                cell.innerHTML = i + 1;
            });
        }).draw();
    });
</script>
@endpush
