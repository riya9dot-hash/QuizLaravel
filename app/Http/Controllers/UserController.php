<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of users (only admin users created by Super Admin).
     */
    public function index()
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only admin users (users with Admin role)
        $adminRole = Role::where('name', 'Admin')->first();
        $users = $adminRole ? $adminRole->users : collect();
        
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new admin user.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        return view('users.create');
    }

    /**
     * Store a newly created admin user.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // Automatically assign Admin role
        // Admin role is created in RolePermissionSeeder, but if it doesn't exist, it will be created here
        $adminRole = Role::firstOrCreate(['name' => 'Admin', 'guard_name' => 'web']);
        $user->assignRole($adminRole);

        // Clear permission cache to ensure role is immediately available
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        return redirect()->route('users.index')->with('success', 'Admin user created successfully with Admin role assigned.');
    }

    /**
     * Show the form for editing the specified admin user.
     */
    public function edit(User $user)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        // Only allow editing admin users
        if (!$user->hasRole('Admin')) {
            return redirect()->route('users.index')->with('error', 'You can only edit admin users.');
        }

        return view('users.edit', compact('user'));
    }

    /**
     * Update the specified admin user.
     */
    public function update(Request $request, User $user)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        // Only allow updating admin users
        if (!$user->hasRole('Admin')) {
            return redirect()->route('users.index')->with('error', 'You can only update admin users.');
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);

        if ($request->filled('password')) {
            $user->update(['password' => Hash::make($request->password)]);
        }

        return redirect()->route('users.index')->with('success', 'Admin user updated successfully.');
    }

    /**
     * Remove the specified admin user.
     */
    public function destroy(User $user)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        // Prevent deleting yourself
        if ($user->id === Auth::id()) {
            return redirect()->route('users.index')->with('error', 'Cannot delete your own account.');
        }

        // Only allow deleting admin users
        if (!$user->hasRole('Admin')) {
            return redirect()->route('users.index')->with('error', 'You can only delete admin users.');
        }

        // Soft delete the user
        $user->delete();
        return redirect()->route('users.index')->with('success', 'Admin user deleted successfully.');
    }

    /**
     * Remove multiple users (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'user_ids' => 'required|array',
            'user_ids.*' => 'exists:users,id',
        ]);

        $userIds = $request->user_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($userIds as $userId) {
            $user = User::find($userId);

            // Prevent deleting yourself
            if ($user->id === Auth::id()) {
                $errors[] = "Cannot delete your own account.";
                continue;
            }

            // Only allow deleting admin users
            if (!$user->hasRole('Admin')) {
                $errors[] = "User '{$user->name}' cannot be deleted. You can only delete admin users.";
                continue;
            }

            // Soft delete the user
            $user->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} user(s) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('users.index')->with('error', $message);
            }
            return redirect()->route('users.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('users.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('users.index')->with('error', 'No users were deleted.');
    }
}
