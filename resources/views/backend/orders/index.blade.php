@extends('backend.layouts.app')

@section('title', 'Orders List')

@push('style')
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.dataTables.min.css">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Orders List</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item">Orders</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">

                        @if (session('success'))
                            <div class="alert alert-success">{{ session('success') }}</div>
                        @endif

                        <div class="card">
                            <div class="card-header">
                                <h4>All Orders</h4>
                            </div>

                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped" id="orders-table">
                                        <thead>
                                            <tr>
                                                <th>SL</th>
                                                <th>Order ID</th>
                                                <th>Customer</th>
                                                <th>Email</th>
                                                <th>Total</th>
                                                <th>Payment</th>
                                                <th>Status</th>
                                                <th>Date</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($orders  as $index => $order)
                                                <tr>
                                                     <td>{{ $index + 1 }}</td>
                                                    <td>{{ $order->id }}</td>
                                                    <td>{{ $order->name }}</td>
                                                    <td>{{ $order->email }}</td>
                                                    <td>${{ number_format($order->total, 2) }}</td>
                                                    <td>{{ $order->payment_method }}</td>
                                                    <td>
                                                        <span class="badge badge-{{ $order->status=='Completed'?'success':($order->status=='Processing'?'primary':($order->status=='Cancelled'?'danger':'warning')) }}">
                                                            {{ $order->status }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $order->created_at->format('d-m-Y H:i') }}</td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('admin.orders.show', $order->id) }}"
                                                           class="btn btn-info btn-sm mr-1" title="View">
                                                           <i class="fas fa-eye"></i>
                                                        </a>

                                                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                                              onsubmit="return confirm('Are you sure to delete this order?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger btn-sm" title="Delete">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div> <!-- card-body -->
                        </div> <!-- card -->

                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <!-- DataTables JS -->
    <script src="{{ asset('backend/library/datatables/media/js/jquery.dataTables.min.js') }}"></script>
    <!-- Buttons extension -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#orders-table')) {
                $('#orders-table').DataTable().destroy();
            }

            $('#orders-table').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'print',
                    'excelHtml5',
                    'csvHtml5',
                    'pdfHtml5'
                ],
                order: [[1, 'desc']], // latest orders first
                pageLength: 10,
                responsive: true,
            });
        });
    </script>
@endpush
