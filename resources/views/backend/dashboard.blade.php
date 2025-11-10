@extends('backend.layouts.app')

@section('title', 'E-commerce Dashboard')

@push('style')
    <style>
        .dashboard-card {
            border-radius: 15px;
            padding: 20px;
            color: #fff;
            margin-bottom: 20px;
            position: relative;
            overflow: hidden;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card .icon {
            font-size: 40px;
            opacity: 0.2;
            position: absolute;
            top: 20px;
            right: 20px;
        }

        .dashboard-card h3 {
            font-size: 1.5rem;
            margin-bottom: 5px;
        }

        .dashboard-card p {
            font-size: 1.2rem;
            font-weight: 700;
        }

        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .chart-container {
            background: #fff;
            padding: 20px;
            border-radius: 15px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.05);
            margin-bottom: 30px;
        }

        .todo-card {
            background: #1f3b73;
            border-radius: 15px;
            padding: 20px;
            color: #fff;
            margin-bottom: 30px;
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .todo-card .task-item {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            padding: 10px 15px;
            margin-bottom: 10px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .todo-card .task-item p {
            margin: 0;
            color: #fff;
        }

        .todo-card .badge {
            font-size: 0.85rem;
        }

        .bg-seconda {
            background: #1a2538;
        }
    </style>
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="container-fluid">
                <div class="section-header">
                    <h1>E-commerce Dashboard</h1>
                </div>
                <!-- To-Do List Section -->
                <h2 class="section-title">To-Do List</h2>
                <div class="todo-card">
                    <!-- Add New Task Form -->
                    <form action="{{ route('todo.store') }}" method="POST" class="mb-3">
                        @csrf
                        <div class="row g-2">
                            <div class="col-md-4">
                                <input type="text" name="name" class="form-control" placeholder="Task name..."
                                    required>
                            </div>
                            <div class="col-md-3">
                                <input type="time" name="time" class="form-control" required>
                            </div>
                            <div class="col-md-3">
                                <input type="date" name="date" class="form-control" required>
                            </div>
                            <div class="col-md-2">
                                <button type="submit" class="btn btn-success w-100">Add Task</button>
                            </div>
                        </div>
                    </form>

                    <!-- Task List -->
                    @foreach ($data as $index => $task)
                        <div class="task-item col-md-12">
                            @if (isset($editId) && $editId == $task->id)
                                <!-- Inline Edit Form -->
                                <form action="{{ route('todo.update', $task->id) }}" method="POST"
                                    class="row col-md-12 g-3 align-items-end">
                                    @csrf
                                    @method('PUT')

                                    <div class=" col-md-4">
                                        <input type="text" name="name" value="{{ $task->name }}"
                                            class="form-control" placeholder="Task Name" required>
                                    </div>

                                    <div class="col-md-3">
                                        <input type="time" name="time" value="{{ $task->time }}"
                                            class="form-control" required>
                                    </div>

                                    <div class=" col-md-3">
                                        <input type="date" name="date" value="{{ $task->date }}"
                                            class="form-control" required>
                                    </div>

                                    <div class=" col-md-2 d-flex gap-2 mt-2">
                                        <button type="submit" class="btn btn-success flex-grow-1">Save</button>
                                        <a href="{{ route('dashboard') }}"
                                            class="btn btn-secondary ml-2 flex-grow-1">Cancel</a>
                                    </div>
                                </form>
                            @else
                                <!-- Normal Display -->
                                <div class="d-flex justify-content-between w-100 align-items-center">
                                    <div>
                                        <span class="badge bg-light text-dark">{{ $index + 1 }}</span>
                                        <span class="ms-2">{{ $task->name }}</span>
                                    </div>
                                    <div class="d-flex gap-2 align-items-center">
                                        <span
                                            class="badge bg-info">{{ \Carbon\Carbon::parse($task->time)->format('h:i A') }}</span>
                                        <span
                                            class="badge bg-warning">{{ \Carbon\Carbon::parse($task->date)->format('j F Y') }}</span>
                                        <a href="{{ route('dashboard', $task->id) }}" class="btn btn-sm btn-primary"><i
                                                class="fas fa-edit"></i></a>
                                        <form action="{{ route('todo.destroy', $task->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-sm btn-danger"><i
                                                    class="fas fa-trash-alt"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
                <!-- Overview / Summary -->
                <h2 class="section-title">Overview</h2>
                <div class="row">
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card bg-primary">
                            <i class="fas fa-dollar-sign icon"></i>
                            <h3>Total Sales</h3>
                            <p>${{ number_format($totalSales, 2) }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card bg-success">
                            <i class="fas fa-shopping-cart icon"></i>
                            <h3>Orders</h3>
                            <p>{{ $totalOrders }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card bg-warning">
                            <i class="fas fa-users icon"></i>
                            <h3>New Customers</h3>
                            <p>{{ $newCustomers }}</p>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-6">
                        <div class="dashboard-card bg-danger">
                            <i class="fas fa-boxes icon"></i>
                            <h3>Total Products</h3>
                            <p>{{ $totalProducts }}</p>
                        </div>
                    </div>
                </div>

                <!-- Low Stock & Recent Activity -->
                <div class="row">
                    <div class="col-lg-6">
                        <div class="dashboard-card bg-info">
                            <h3>Low Stock Alerts</h3>
                            <ul class="list-unstyled mt-2">
                                @foreach ($lowStockProducts as $product)
                                    <li>{{ $product->name }} - {{ $product->stock }} left</li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="dashboard-card bg-seconda">
                            <h3>Recent Activity</h3>
                            <ul class="list-unstyled mt-2">
                                @foreach ($recentActivities as $activity)
                                    <li>{{ $activity->message ?? 'Order #' . $activity->id }} -
                                        <small>{{ $activity->created_at->diffForHumans() }}</small>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Reports / Analytics -->
                <h2 class="section-title">Reports & Analytics</h2>
                <div class="row">
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Sales Report</h4>
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Top Selling Products</h4>
                            <canvas id="topProductsChart"></canvas>
                        </div>
                    </div>
                </div>

                <div class="row mt-3">
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Product Performance</h4>
                            <canvas id="productPerformanceChart"></canvas>
                        </div>
                    </div>
                    <div class="col-lg-6">
                        <div class="chart-container">
                            <h4>Customer Report</h4>
                            <canvas id="customerChart"></canvas>
                        </div>
                    </div>
                </div>



            </div>
        </section>
    </div>
@endsection

@push('scripts')
    <script src="{{ asset('backend/library/chart.js/dist/Chart.min.js') }}"></script>
    <script>
        // Sales Report Chart
        var salesCtx = document.getElementById('salesChart').getContext('2d');
        new Chart(salesCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($salesReport['labels']) !!},
                datasets: [{
                    label: 'Sales ($)',
                    data: {!! json_encode($salesReport['data']) !!},
                    borderColor: '#1f3b73',
                    backgroundColor: 'rgba(31,59,115,0.2)',
                    fill: true,
                }]
            }
        });

        // Top Selling Products Chart
        var topProductsCtx = document.getElementById('topProductsChart').getContext('2d');
        new Chart(topProductsCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($topProducts['labels']) !!},
                datasets: [{
                    label: 'Units Sold',
                    data: {!! json_encode($topProducts['data']) !!},
                    backgroundColor: '#3d80b4'
                }]
            }
        });

        // Product Performance Chart
        var productPerfCtx = document.getElementById('productPerformanceChart').getContext('2d');
        new Chart(productPerfCtx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($productPerformance['labels']) !!},
                datasets: [{
                    data: {!! json_encode($productPerformance['data']) !!},
                    backgroundColor: ['#1f3b73', '#3d80b4', '#FFC107']
                }]
            }
        });

        // Customer Report Chart
        var customerCtx = document.getElementById('customerChart').getContext('2d');
        new Chart(customerCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($customerReport['labels']) !!},
                datasets: [{
                    data: {!! json_encode($customerReport['data']) !!},
                    backgroundColor: ['#FFC107', '#1f3b73']
                }]
            }
        });
    </script>
@endpush
