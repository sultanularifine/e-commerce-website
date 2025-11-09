@extends('backend.layouts.app')

@section('title', 'Order Details')

@push('style')
    <style>
        .card-header {
            font-weight: 700;
        }

        .order-summary p {
            margin: 0 0 5px;
        }

        .order-items-table td,
        .order-items-table th {
            vertical-align: middle !important;
        }

        .status-select {
            width: 200px;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Order #{{ $order->id }}</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="{{ route('admin.orders.index') }}">Orders</a></div>
                    <div class="breadcrumb-item">View</div>
                </div>
            </div>

            <div class="row">
                {{-- Customer Details --}}
                <div class="col-lg-6 col-md-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-primary text-white">Customer Details</div>
                        <div class="card-body">
                            <p><strong>Name:</strong> {{ $order->name }}</p>
                            <p><strong>Phone:</strong> {{ $order->phone }}</p>
                            <p><strong>Email:</strong> {{ $order->email }}</p>
                            <p><strong>Address:</strong> {{ $order->address }}, {{ $order->upazila }},
                                {{ $order->district }}, {{ $order->division }}</p>
                        </div>
                    </div>
                </div>

                {{-- Order Summary --}}
                <div class="col-lg-6 col-md-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-info text-white">Order Summary</div>
                        <div class="card-body order-summary">
                            <p><strong>Subtotal:</strong> ${{ number_format($order->subtotal, 2) }}</p>
                            <p><strong>Shipping:</strong> ${{ number_format($order->shipping, 2) }}</p>
                            <p><strong>Total:</strong> ${{ number_format($order->total, 2) }}</p>
                            <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                            <p><strong>Status:</strong> {{ $order->status }}</p>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Order Items --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-secondary text-white">Order Items</div>
                        <div class="card-body table-responsive">
                            <table class="table table-bordered order-items-table">
                                <thead class="thead-light">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Qty</th>
                                        <th>Total</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($order->items as $item)
                                        <tr>
                                            <td>{{ $item['name'] }}</td>
                                            <td>${{ number_format($item['price'], 2) }}</td>
                                            <td>{{ $item['quantity'] }}</td>
                                            <td>${{ number_format($item['price'] * $item['quantity'], 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Update Status --}}
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-sm mb-4">
                        <div class="card-header bg-warning text-dark">Update Status</div>
                        <div class="card-body">
                            <form action="{{ route('admin.orders.status', $order->id) }}" method="POST">
                                @csrf
                                <div class="d-flex align-items-center gap-2">
                                    <select name="status" class="form-control status-select">
                                        <option value="Pending" {{ $order->status == 'Pending' ? 'selected' : '' }}>Pending
                                        </option>
                                        <option value="Processing" {{ $order->status == 'Processing' ? 'selected' : '' }}>
                                            Processing</option>
                                        <option value="Completed" {{ $order->status == 'Completed' ? 'selected' : '' }}>
                                            Completed</option>
                                        <option value="Cancelled" {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                                            Cancelled</option>
                                    </select>
                                    <button type="submit" class="btn btn-primary">Update Status</button>
                                    <a href="{{ route('admin.orders.index') }}" class="ml-2 btn btn-info">Back</a>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
@endsection
