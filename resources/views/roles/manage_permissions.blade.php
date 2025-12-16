@extends('backend.layouts.app')
@section('title', 'Manage Role Permissions')

@section('main')
<div class="main-content">
    <section class="section">
        <div class="section-header">
            <h1>Manage Role Permissions</h1>
        </div>

        <div class="section-body">
            <div class="row justify-content-center">
                <div class="col-lg-12">

                    {{-- Success Message --}}
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    {{-- Select Role --}}
                    <div class="form-group col-md-12">
                        <label><b>Select Role</b></label>
                        <select id="roleSelect" class="form-control roleSelect">
                            <option value="">-- Select Role --</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ ucfirst($role->name) }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Permissions Form --}}
                    <label><b>Assign Permissions</b></label>
                    <form id="permissionForm" method="POST" style="display:none;" class="form-group col-md-12">
                        @csrf
                        
                        {{-- Select All / Deselect All Button --}}
                        <div class="mb-2" id="selectAllContainer" style="display:none;">
                            <button type="button" id="selectAllBtn" class="btn btn-sm btn-secondary">Select All</button>
                        </div>

                        <div id="permissionsContainer" class="row"></div>
                        <div class="mt-3">
                            <button type="submit" class="btn btn-primary">Update Permissions</button>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </section>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {

    var getPermissionsUrl = "{{ route('get_permissions', ':role') }}";
    var updatePermissionsUrl = "{{ route('update_permissions', ':role') }}";

    // On role selection
    $('#roleSelect').on('change', function() {
        var roleId = $(this).val();

        if (!roleId) {
            $('#permissionsContainer').html('');
            $('#permissionForm').hide();
            $('#selectAllContainer').hide();
            return;
        }

        $('#permissionsContainer').html('<p>Loading permissions...</p>');

        $.ajax({
            url: getPermissionsUrl.replace(':role', roleId),
            type: 'GET',
            dataType: 'json',
            success: function(data) {
                $('#permissionsContainer').html('');
                $('#permissionForm').show();

                if (!data.permissions || data.permissions.length === 0) {
                    $('#permissionsContainer').html('<p>No permissions available.</p>');
                    $('#selectAllContainer').hide();
                    return;
                }

                // Show select all button
                $('#selectAllContainer').show();

                $('#permissionForm').attr('action', updatePermissionsUrl.replace(':role', roleId));

                // Render checkboxes
                $.each(data.permissions, function(index, permission) {
                    var isChecked = data.role_permissions.includes(permission.id) ? 'checked' : '';
                    var html = `
                        <div class="col-md-6 mb-2">
                            <div class="form-check">
                                <input class="form-check-input permission-checkbox" type="checkbox" name="permission[]" value="${permission.id}" id="perm_${permission.id}" ${isChecked}>
                                <label class="form-check-label" for="perm_${permission.id}">${permission.name}</label>
                            </div>
                        </div>
                    `;
                    $('#permissionsContainer').append(html);
                });

                // Update button text based on current selection
                updateSelectAllBtnText();
            },
            error: function(err) {
                console.error('AJAX error:', err);
                alert('Failed to load permissions. Try again.');
                $('#permissionsContainer').html('');
                $('#permissionForm').hide();
                $('#selectAllContainer').hide();
            }
        });
    });

    // Select / Deselect all functionality
    $(document).on('click', '#selectAllBtn', function() {
        var allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
        $('.permission-checkbox').prop('checked', !allChecked);
        updateSelectAllBtnText();
    });

    // Update button text dynamically when any checkbox is manually clicked
    $(document).on('change', '.permission-checkbox', function() {
        updateSelectAllBtnText();
    });

    function updateSelectAllBtnText() {
        if ($('.permission-checkbox').length === 0) {
            $('#selectAllContainer').hide();
            return;
        }
        var allChecked = $('.permission-checkbox:checked').length === $('.permission-checkbox').length;
        $('#selectAllBtn').text(allChecked ? 'Deselect All' : 'Select All');
    }

});
</script>
@endpush
