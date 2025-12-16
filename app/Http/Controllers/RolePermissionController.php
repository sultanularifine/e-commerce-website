<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class RolePermissionController extends Controller
{
    /**
     * Show the Manage Permissions page
     */
    public function managePermissions(): View
    {
        $roles = Role::all();
        return view('roles.manage_permissions', compact('roles'));
    }

    /**
     * AJAX: Get permissions for a role
     */
    public function getPermissions($roleId)
    {
        $role = Role::findOrFail($roleId);
        $allPermissions = Permission::orderBy('name')->get(); // Sorted alphabetically
        $rolePermissions = $role->permissions()->pluck('id')->toArray();

        return response()->json([
            'permissions' => $allPermissions,
            'role_permissions' => $rolePermissions,
        ]);
    }

    /**
     * Update permissions for a role
     */
  

    public function updatePermissions(Request $request, $roleId): RedirectResponse
{
    $role = Role::findOrFail($roleId);

    $request->validate([
        'permission' => 'nullable|array',
        'permission.*' => 'integer',
    ]);

    // Convert permission IDs → names
    $permissions = Permission::whereIn('id', $request->permission ?? [])
                             ->pluck('name')
                             ->toArray();

    $role->syncPermissions($permissions);

    return redirect()->back()->with('success', 'Role permissions updated successfully.');
}

}
