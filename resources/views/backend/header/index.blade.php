@extends('backend.layouts.app')
@section('title', 'Header Settings')

@push('style')
<link rel="stylesheet" href="{{ asset('backend/library/datatables/media/css/jquery.dataTables.min.css') }}">
@endpush

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Header Settings</h1>
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

            <div class="card shadow-sm">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4>All Header Items</h4>
                    <a href="{{ route('header-settings.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Add Header Item
                    </a>
                </div>

                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered table-striped" id="header-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>SL</th>
                                    <th>Type</th>
                                    <th>Name</th>
                                    <th>Icon</th>
                                    <th>Value</th>
                                    <th>Order</th>
                                    <th>Status</th>
                                    <th width="160">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($settings as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ ucfirst($item->type) }}</td>
                                    <td>{{ $item->name ?? '-' }}</td>
                                    <td><i class="{{ $item->icon ?? '' }}"></i></td>
                                    <td>{{ $item->value ?? '-' }}</td>
                                    <td>{{ $item->order }}</td>
                                    <td>
                                        <span class="badge badge-{{ $item->status ? 'success' : 'danger' }}">
                                            {{ $item->status ? 'Active' : 'Inactive' }}
                                        </span>
                                    </td>
                                    <td class="d-flex align-items-center">
                                        <a href="{{ route('header-settings.edit', $item->id) }}" class="btn btn-sm btn-primary mr-1">
                                            <i class="fa fa-edit"></i> 
                                        </a>
                                        <form action="{{ route('header-settings.destroy', $item->id) }}" method="POST" style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('Are you sure?')" class="btn btn-sm btn-danger">
                                                <i class="fa fa-trash"></i> 
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Laravel Pagination --}}
                    <div class="mt-3">
                        {!! $settings->links() !!}
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
        $('#header-table').DataTable({
            paging: false,  // Laravel handles pagination
            info: false,
            ordering: true,
            searching: true,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search header items..."
            }
        });
    });
</script>
@endpush
