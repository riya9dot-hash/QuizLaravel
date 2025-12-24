<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Brand;
use App\Models\Language;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class BrandUserController extends Controller
{
    /**
     * Display a listing of regular users for the admin's brands.
     */
    public function index()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Get all regular users (not admins) created by this admin
        $users = User::whereDoesntHave('roles', function($query) {
            $query->whereIn('name', ['Admin', 'SuperAdmin']);
        })
        ->where('created_by', Auth::id())
        ->with(['brands', 'roles', 'language'])
        ->orderBy('name', 'asc')
        ->get();

        return view('brand-users.index', compact('users'));
    }

    /**
     * Show the form for creating a new regular user.
     */
    public function create()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Get brands created by this admin
        $brands = Brand::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Get only roles created by this admin (excluding SuperAdmin and Admin)
        $roles = Role::where('created_by', Auth::id())
            ->whereNotIn('name', ['SuperAdmin', 'Admin'])
            ->orderBy('name', 'asc')
            ->get();

        // Get languages created by this admin
        $languages = Language::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        return view('brand-users.create', compact('brands', 'roles', 'languages'));
    }

    /**
     * Store a newly created regular user.
     */
    // public function store(Request $request)
    // {
    //     // Only Admin can access
    //     if (!Auth::user()->hasRole('Admin')) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:8',
    //         'brand_ids' => 'required|array|min:1',
    //         'brand_ids.*' => 'exists:brands,id',
    //         'role_id' => 'required|exists:roles,id',
    //         'language_id' => 'nullable|exists:languages,id',
    //     ]);

    //     // Verify all brands belong to this admin
    //     $adminBrandIds = Brand::where('created_by', Auth::id())->pluck('id')->toArray();
    //     $requestBrandIds = $request->brand_ids;
        
    //     foreach ($requestBrandIds as $brandId) {
    //         if (!in_array($brandId, $adminBrandIds)) {
    //             return back()->withErrors(['brand_ids' => 'You can only assign users to your own brands.'])->withInput();
    //         }
    //     }

    //     // Verify role belongs to this admin
    //     $role = Role::where('id', $request->role_id)
    //         ->where('created_by', Auth::id())
    //         ->whereNotIn('name', ['SuperAdmin', 'Admin'])
    //         ->firstOrFail();

    //     // Verify language belongs to this admin if provided
    //     $languageId = null;
    //     if ($request->filled('language_id')) {
    //         $language = Language::where('id', $request->language_id)
    //             ->where('created_by', Auth::id())
    //             ->firstOrFail();
    //         $languageId = $language->id;
    //     }

    //     $user = User::create([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'password' => Hash::make($request->password),
    //         'language_id' => $languageId,
    //         'created_by' => Auth::id(),
    //     ]);

    //     // Assign selected role
    //     $user->assignRole($role);

    //     // Attach all selected brands
    //     $user->brands()->attach($requestBrandIds);

    //     // Clear permission cache
    //     app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    //     return redirect()->route('brand-users.index')->with('success', 'User created successfully and assigned to brand.');
    // }

    public function store(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Validate request
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users',
            'password'    => 'required|string|min:8',
            'brand_ids'   => 'required|array|min:1',
            'brand_ids.*' => 'exists:brands,id',
            'role_id'     => 'required|array|min:1',
            'role_id.*'   => 'exists:roles,id',
            'language_id' => 'nullable|exists:languages,id',
        ]);

        /* -----------------------------------------
        Verify brands belong to logged-in admin
        ------------------------------------------*/
        $adminBrandIds = Brand::where('created_by', Auth::id())
            ->pluck('id')
            ->toArray();

        foreach ($request->brand_ids as $brandId) {
            if (!in_array($brandId, $adminBrandIds)) {
                return back()->withErrors([
                    'brand_ids' => 'You can only assign users to your own brands.'
                ])->withInput();
            }
        }

        /* -----------------------------------------
        Verify roles belong to logged-in admin
        ------------------------------------------*/
        $roles = Role::whereIn('id', $request->role_id)
            ->where('created_by', Auth::id())
            ->whereNotIn('name', ['SuperAdmin', 'Admin'])
            ->get();

        if ($roles->count() !== count($request->role_id)) {
            return back()->withErrors([
                'role_id' => 'Invalid role selection.'
            ])->withInput();
        }

        /* -----------------------------------------
        Verify language belongs to admin (optional)
        ------------------------------------------*/
        $languageId = null;
        if ($request->filled('language_id')) {
            $language = Language::where('id', $request->language_id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $languageId = $language->id;
        }

        /* -----------------------------------------
        Create User
        ------------------------------------------*/
        $user = User::create([
            'name'        => $request->name,
            'email'       => $request->email,
            'password'    => Hash::make($request->password),
            'language_id' => $languageId,
            'created_by'  => Auth::id(),
        ]);

        /* -----------------------------------------
        Assign Multiple Roles (Spatie)
        ------------------------------------------*/
        $user->assignRole($roles);

        /* -----------------------------------------
        Attach Multiple Brands
        ------------------------------------------*/
        $user->brands()->attach($request->brand_ids);

        /* -----------------------------------------
        Clear permission cache
        ------------------------------------------*/
        app(\Spatie\Permission\PermissionRegistrar::class)
            ->forgetCachedPermissions();

        return redirect()
            ->route('brand-users.index')
            ->with('success', 'User created successfully with roles and brands.');
    }


    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $brandUser)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify user was created by this admin
        if ($brandUser->created_by !== Auth::id()) {
            abort(403, 'You can only edit users created by you.');
        }

        // Get brands created by this admin
        $brands = Brand::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Get only roles created by this admin (excluding SuperAdmin and Admin)
        $roles = Role::where('created_by', Auth::id())
            ->whereNotIn('name', ['SuperAdmin', 'Admin'])
            ->orderBy('name', 'asc')
            ->get();

        // Get languages created by this admin
        $languages = Language::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Get user's current brand IDs
        $userBrandIds = $brandUser->brands->pluck('id')->toArray();
        $userRoleIds = $brandUser->roles->pluck('id')->toArray();


        return view('brand-users.edit', compact('brandUser', 'brands', 'roles', 'languages', 'userBrandIds','userRoleIds'));
    }

    /**
     * Update the specified user.
     */
    // public function update(Request $request, User $brandUser)
    // {
    //     // Only Admin can access
    //     if (!Auth::user()->hasRole('Admin')) {
    //         abort(403, 'Unauthorized access');
    //     }

    //     // Verify user was created by this admin
    //     if ($brandUser->created_by !== Auth::id()) {
    //         abort(403, 'You can only update users created by you.');
    //     }

    //     $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $brandUser->id,
    //         'password' => 'nullable|string|min:8',
    //         'brand_ids' => 'required|array|min:1',
    //         'brand_ids.*' => 'exists:brands,id',
    //         'role_id' => 'required|exists:roles,id',
    //         'language_id' => 'nullable|exists:languages,id',
    //     ]);

    //     // Verify all brands belong to this admin
    //     $adminBrandIds = Brand::where('created_by', Auth::id())->pluck('id')->toArray();
    //     $requestBrandIds = $request->brand_ids;
    //     foreach ($requestBrandIds as $brandId) {
    //         if (!in_array($brandId, $adminBrandIds)) {
    //             return back()->withErrors(['brand_ids' => 'You can only assign users to your own brands.'])->withInput();
    //         }
    //     }

    //     // Verify role belongs to this admin
    //     $role = Role::where('id', $request->role_id)
    //         ->where('created_by', Auth::id())
    //         ->whereNotIn('name', ['SuperAdmin', 'Admin'])
    //         ->firstOrFail();

    //     // Verify language belongs to this admin if provided
    //     $languageId = null;
    //     if ($request->filled('language_id')) {
    //         $language = Language::where('id', $request->language_id)
    //             ->where('created_by', Auth::id())
    //             ->firstOrFail();
    //         $languageId = $language->id;
    //     }

    //     $brandUser->update([
    //         'name' => $request->name,
    //         'email' => $request->email,
    //         'language_id' => $languageId,
    //     ]);

    //     if ($request->filled('password')) {
    //         $brandUser->update(['password' => Hash::make($request->password)]);
    //     }

    //     // Update user role
    //     $brandUser->syncRoles([$role]);

    //     // Sync brands (replace all existing with new selection)
    //     $brandUser->brands()->sync($requestBrandIds);

    //     return redirect()->route('brand-users.index')->with('success', 'User updated successfully.');
    // }

    public function update(Request $request, User $brandUser)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify user was created by this admin
        if ($brandUser->created_by !== Auth::id()) {
            abort(403, 'You can only update users created by you.');
        }

        // ✅ VALIDATION (multiple roles)
        $request->validate([
            'name'        => 'required|string|max:255',
            'email'       => 'required|string|email|max:255|unique:users,email,' . $brandUser->id,
            'password'    => 'nullable|string|min:8',
            'brand_ids'   => 'required|array|min:1',
            'brand_ids.*' => 'exists:brands,id',
            'role_id'     => 'required|array|min:1',
            'role_id.*'   => 'exists:roles,id',
            'language_id' => 'nullable|exists:languages,id',
        ]);

        /* -----------------------------------------
        Verify brands belong to logged-in admin
        ------------------------------------------*/
        $adminBrandIds = Brand::where('created_by', Auth::id())
            ->pluck('id')
            ->toArray();

        foreach ($request->brand_ids as $brandId) {
            if (!in_array($brandId, $adminBrandIds)) {
                return back()->withErrors([
                    'brand_ids' => 'You can only assign users to your own brands.'
                ])->withInput();
            }
        }

        /* -----------------------------------------
        Verify roles belong to logged-in admin
        ------------------------------------------*/
        $roles = Role::whereIn('id', $request->role_id)
            ->where('created_by', Auth::id())
            ->whereNotIn('name', ['SuperAdmin', 'Admin'])
            ->get();

        if ($roles->count() !== count($request->role_id)) {
            return back()->withErrors([
                'role_id' => 'Invalid role selection.'
            ])->withInput();
        }

        /* -----------------------------------------
        Verify language (optional)
        ------------------------------------------*/
        $languageId = null;
        if ($request->filled('language_id')) {
            $language = Language::where('id', $request->language_id)
                ->where('created_by', Auth::id())
                ->firstOrFail();

            $languageId = $language->id;
        }

        /* -----------------------------------------
        Update User
        ------------------------------------------*/
        $brandUser->update([
            'name'        => $request->name,
            'email'       => $request->email,
            'language_id' => $languageId,
        ]);

        if ($request->filled('password')) {
            $brandUser->update([
                'password' => Hash::make($request->password)
            ]);
        }

        /* -----------------------------------------
        ✅ Sync Multiple Roles
        ------------------------------------------*/
        $brandUser->syncRoles($roles);

        /* -----------------------------------------
        Sync Brands
        ------------------------------------------*/
        $brandUser->brands()->sync($request->brand_ids);

        return redirect()
            ->route('brand-users.index')
            ->with('success', 'User updated successfully with roles and brands.');
    }


    /**
     * Remove the specified user.
     */
    public function destroy(User $brandUser)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Verify user was created by this admin
        if ($brandUser->created_by !== Auth::id()) {
            abort(403, 'You can only delete users created by you.');
        }

        // Prevent deleting yourself
        if ($brandUser->id === Auth::id()) {
            return redirect()->route('brand-users.index')->with('error', 'Cannot delete your own account.');
        }

        // Soft delete the user
        $brandUser->delete();
        return redirect()->route('brand-users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Remove multiple brand users (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
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

            // Verify user was created by this admin
            if ($user->created_by !== Auth::id()) {
                $errors[] = "User '{$user->name}' cannot be deleted. You can only delete users created by you.";
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
                return redirect()->route('brand-users.index')->with('error', $message);
            }
            return redirect()->route('brand-users.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('brand-users.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('brand-users.index')->with('error', 'No users were deleted.');
    }
}
