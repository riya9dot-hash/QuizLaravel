<?php

namespace App\Http\Controllers;

use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ModuleController extends Controller
{
    /**
     * Display a listing of modules.
     * Only Super Admin can access.
     */
    public function index(Request $request)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $query = Module::with('creator')
            ->withCount('permissions');

        // Search functionality
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'like', '%' . $search . '%');
        }

        $modules = $query->latest()->paginate(10);

        return view('modules.index', compact('modules'));
    }

    /**
     * Show the form for creating a new module.
     */
    public function create()
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        return view('modules.create');
    }

    /**
     * Store a newly created module.
     */
    public function store(Request $request)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:191|unique:modules,name',
        ]);

        Module::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('modules.index')->with('success', 'Module created successfully.');
    }

    /**
     * Display the specified module.
     */
    public function show(Module $module)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $module->load('permissions', 'creator');
        return view('modules.show', compact('module'));
    }

    /**
     * Show the form for editing the specified module.
     */
    public function edit(Module $module)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        return view('modules.edit', compact('module'));
    }

    /**
     * Update the specified module.
     */
    public function update(Request $request, Module $module)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:191|unique:modules,name,' . $module->id,
        ]);

        $module->update([
            'name' => $request->name,
        ]);

        return redirect()->route('modules.index')->with('success', 'Module updated successfully.');
    }

    /**
     * Remove the specified module.
     */
    public function destroy(Module $module)
    {
        if (!Auth::user()->hasRole('SuperAdmin')) {
            abort(403, 'Unauthorized access');
        }

        // Check if module has permissions
        if ($module->permissions()->count() > 0) {
            return redirect()->route('modules.index')->with('error', 'Cannot delete module. It has associated permissions.');
        }

        $module->delete();
        return redirect()->route('modules.index')->with('success', 'Module deleted successfully.');
    }
}
