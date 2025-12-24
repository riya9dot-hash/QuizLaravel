<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Auth;

class RoleController extends Controller
{
    /**
     * Display a listing of roles.
     */
    public function index()
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin sees only roles they created
        $roles = Role::where('created_by', Auth::id())
            ->whereNotIn('name', ['SuperAdmin', 'Admin'])
            ->with('permissions')
            ->get();

        return view('roles.index', compact('roles'));
    }

    /**
     * Show the form for creating a new role.
     */
    public function create()
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only permissions created by the logged-in admin
        $permissions = Permission::where('created_by', Auth::id())->get();
        return view('roles.create', compact('permissions'));
    }

    /**
     * Store a newly created role.
     */
    public function store(Request $request)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('roles', 'name')->where(function ($query) {
                    return $query->where('created_by', Auth::id())->where('guard_name', 'web');
                }),
            ],
        ]);

        $role = Role::create([
            'name' => $request->name,
            'guard_name' => 'web',
            'created_by' => Auth::id(), // Track which admin created this role
        ]);

        if ($request->has('permissions') && is_array($request->permissions)) {
            // Convert permission IDs to Permission models
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        }

        return redirect()->route('roles.index')->with('success', 'Role created successfully.');
    }

    /**
     * Show the form for editing the specified role.
     */
    public function edit(Role $role)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Prevent editing Super Admin and Admin roles
        if (in_array($role->name, ['SuperAdmin', 'Admin'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot edit Super Admin or Admin roles.');
        }

        // Admin can only edit roles they created
        if ($role->created_by !== Auth::id()) {
            abort(403, 'You can only edit roles created by you.');
        }

        // Show only permissions created by the logged-in admin
        $permissions = Permission::where('created_by', Auth::id())->get();
        $rolePermissions = $role->permissions->pluck('id')->toArray();
        return view('roles.edit', compact('role', 'permissions', 'rolePermissions'));
    }

    /**
     * Update the specified role.
     */
    public function update(Request $request, Role $role)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Prevent editing Super Admin and Admin roles
        if (in_array($role->name, ['SuperAdmin', 'Admin'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot edit Super Admin or Admin roles.');
        }

        // Admin can only edit roles they created
        if ($role->created_by !== Auth::id()) {
            abort(403, 'You can only edit roles created by you.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('roles', 'name')->where(function ($query) {
                    return $query->where('created_by', Auth::id())->where('guard_name', 'web');
                })->ignore($role->id),
            ],
        ]);

        $role->update(['name' => $request->name]);

        if ($request->has('permissions') && is_array($request->permissions) && count($request->permissions) > 0) {
            // Convert permission IDs to Permission models
            $permissions = Permission::whereIn('id', $request->permissions)->get();
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions([]);
        }

        return redirect()->route('roles.index')->with('success', 'Role updated successfully.');
    }

    /**
     * Remove the specified role.
     */
    public function destroy(Role $role)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Prevent deleting Super Admin and Admin roles
        if (in_array($role->name, ['SuperAdmin', 'Admin'])) {
            return redirect()->route('roles.index')->with('error', 'Cannot delete Super Admin or Admin roles.');
        }

        // Admin can only delete roles they created
        if ($role->created_by !== Auth::id()) {
            abort(403, 'You can only delete roles created by you.');
        }

        $role->delete();
        return redirect()->route('roles.index')->with('success', 'Role deleted successfully.');
    }

    /**
     * Remove multiple roles (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'role_ids' => 'required|array',
            'role_ids.*' => 'exists:roles,id',
        ]);

        $roleIds = $request->role_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($roleIds as $roleId) {
            $role = Role::find($roleId);

            // Prevent deleting Super Admin and Admin roles
            if (in_array($role->name, ['SuperAdmin', 'Admin'])) {
                $errors[] = "Role '{$role->name}' cannot be deleted. Super Admin and Admin roles are protected.";
                continue;
            }

            // Verify role belongs to this admin
            if ($role->created_by !== Auth::id()) {
                $errors[] = "Role '{$role->name}' cannot be deleted. You can only delete roles created by you.";
                continue;
            }

            // Soft delete the role
            $role->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} role(s) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('roles.index')->with('error', $message);
            }
            return redirect()->route('roles.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('roles.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('roles.index')->with('error', 'No roles were deleted.');
    }
}
