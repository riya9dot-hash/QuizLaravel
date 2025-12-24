<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Role;

class DashboardController extends Controller
{
    /**
     * Show the application dashboard.
     */
    public function index()
    {
        $user = Auth::user();
        $roles = $user->getRoleNames();
        $permissions = $user->getAllPermissions()->pluck('name');

        // Get roles created by the logged-in admin only
        $createdRoles = collect();
        if ($user->hasRole('Admin')) {
            $createdRoles = Role::where('created_by', $user->id)
                ->whereNotIn('name', ['SuperAdmin', 'Admin'])
                ->with('permissions')
                ->get();
        }

        return view('dashboard', [
            'user' => $user,
            'roles' => $roles,
            'permissions' => $permissions,
            'createdRoles' => $createdRoles,
        ]);
    }
}
