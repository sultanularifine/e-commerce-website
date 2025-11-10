@extends('backend.layouts.app')

@section('title', 'Footer Settings')

@push('style')
    <link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
    <div class="main-content">
        <section class="section">
            <div class="section-header">
                <h1>Footer Settings</h1>
                <div class="section-header-breadcrumb">
                    <div class="breadcrumb-item active"><a href="#">Dashboard</a></div>
                    <div class="breadcrumb-item"><a href="#">Settings</a></div>
                    <div class="breadcrumb-item">Footer</div>
                </div>
            </div>

            <div class="section-body">
                <div class="row">
                    <div class="col-12">
                        <div class="card">

                            <div class="card-header">
                                <div class="card-left text-left my-1">
                                    <a href="{{ route('footer.create') }}" class="btn btn-primary">Add Footer Item</a>
                                </div>
                            </div>

                            <div class="card-body">
                                @if(session('success'))
                                    <div class="alert alert-success">{{ session('success') }}</div>
                                @endif

                                <div class="table-responsive">
                                    <table class="table-striped table" id="table-1">
                                        <thead>
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th>Type</th>
                                                <th>Name</th>
                                                <th>Value</th>
                                                <th>Order</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($footers as $index => $setting)
                                                <tr>
                                                    <td>{{ $index + 1 }}</td>
                                                    <td>
                                                        <span class="badge 
                                                            @if($setting->type == 'menu') bg-info text-light
                                                            @elseif($setting->type == 'contact') bg-warning text-light
                                                            @elseif($setting->type == 'social') bg-primary text-light
                                                            @elseif($setting->type == 'logo') bg-success text-light
                                                            @else bg-secondary text-light
                                                            @endif
                                                        ">
                                                            {{ strtoupper($setting->type) }}
                                                        </span>
                                                    </td>
                                                    <td>{{ $setting->name ?? '—' }}</td>
                                                    <td style="max-width: 250px; overflow: hidden; text-overflow: ellipsis;">
                                                        {{ $setting->value }}
                                                    </td>
                                                    <td>{{ $setting->order }}</td>
                                                    <td>
                                                        @if($setting->status)
                                                            <span class="badge badge-success">Active</span>
                                                        @else
                                                            <span class="badge badge-danger">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="d-flex">
                                                        <a href="{{ route('footer.edit', $setting->id) }}"
                                                            class="btn btn-primary btn-action btn-sm mr-1"
                                                            data-toggle="tooltip" title="Edit">
                                                            <i class="fas fa-pencil-alt"></i>
                                                        </a>
                                                        <form action="{{ route('footer.destroy', $setting->id) }}" method="POST">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button class="btn btn-danger btn-sm btn-action"
                                                                data-toggle="tooltip" title="Delete"
                                                                onclick="return confirm('Are you sure?')">
                                                                <i class="fas fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
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
    <script src="{{ asset('backend/js/page/modules-datatables.js') }}"></script>
@endpush
