<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Permission;
use App\Models\Module;
use Illuminate\Support\Facades\Auth;

class PermissionController extends Controller
{
    /**
     * Display a listing of permissions.
     */
    public function index(Request $request)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only permissions created by the logged-in admin
        $query = Permission::where('created_by', Auth::id())
            ->with('roles', 'module');

        // Search functionality - search by permission name or module name
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', '%' . $search . '%')
                  ->orWhereHas('module', function($moduleQuery) use ($search) {
                      $moduleQuery->where('name', 'like', '%' . $search . '%');
                  });
            });
        }

        $permissions = $query->latest()->paginate(10);
        return view('permissions.index', compact('permissions'));
    }

    /**
     * Show the form for creating a new permission.
     */
    public function create()
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Get all modules for dropdown
        $modules = Module::orderBy('name')->get();
        return view('permissions.create', compact('modules'));
    }

    /**
     * Store a newly created permission.
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
                \Illuminate\Validation\Rule::unique('permissions', 'name')->where(function ($query) {
                    return $query->where('created_by', Auth::id())->where('guard_name', 'web');
                }),
            ],
            'module_id' => 'required|exists:modules,id',
        ]);

        Permission::create([
            'name' => strtolower(trim($request->name)),
            'guard_name' => 'web',
            'module_id' => $request->module_id,
            'created_by' => Auth::id(), // Track which admin created this permission
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission created successfully.');
    }

    /**
     * Show the form for editing the specified permission.
     */
    public function edit(Permission $permission)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only edit permissions they created
        if ($permission->created_by !== Auth::id()) {
            abort(403, 'You can only edit permissions created by you.');
        }

        // Get all modules for dropdown
        $modules = Module::orderBy('name')->get();
        return view('permissions.edit', compact('permission', 'modules'));
    }

    /**
     * Update the specified permission.
     */
    public function update(Request $request, Permission $permission)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only update permissions they created
        if ($permission->created_by !== Auth::id()) {
            abort(403, 'You can only update permissions created by you.');
        }

        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                \Illuminate\Validation\Rule::unique('permissions', 'name')->where(function ($query) {
                    return $query->where('created_by', Auth::id())->where('guard_name', 'web');
                })->ignore($permission->id),
            ],
            'module_id' => 'required|exists:modules,id',
        ]);

        $permission->update([
            'name' => strtolower(trim($request->name)),
            'module_id' => $request->module_id,
        ]);

        return redirect()->route('permissions.index')->with('success', 'Permission updated successfully.');
    }

    /**
     * Remove the specified permission.
     */
    public function destroy(Permission $permission)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only delete permissions they created
        if ($permission->created_by !== Auth::id()) {
            abort(403, 'You can only delete permissions created by you.');
        }

        $permission->delete();
        return redirect()->route('permissions.index')->with('success', 'Permission deleted successfully.');
    }

    /**
     * Remove multiple permissions (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Only Admin can access (Super Admin cannot access)
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'permission_ids' => 'required|array',
            'permission_ids.*' => 'exists:permissions,id',
        ]);

        $permissionIds = $request->permission_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($permissionIds as $permissionId) {
            $permission = Permission::find($permissionId);

            // Verify permission belongs to this admin
            if ($permission->created_by !== Auth::id()) {
                $errors[] = "Permission '{$permission->name}' cannot be deleted. You can only delete permissions created by you.";
                continue;
            }

            // Soft delete the permission
            $permission->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} permission(s) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('permissions.index')->with('error', $message);
            }
            return redirect()->route('permissions.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('permissions.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('permissions.index')->with('error', 'No permissions were deleted.');
    }
}
