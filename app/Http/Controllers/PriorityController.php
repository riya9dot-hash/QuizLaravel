<?php

namespace App\Http\Controllers;

use App\Models\Priority;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PriorityController extends Controller
{
    /**
     * Display a listing of priorities.
     */
    public function index()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only priorities created by the logged-in admin
        $priorities = Priority::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('priorities.index', compact('priorities'));
    }

    /**
     * Show the form for creating a new priority.
     */
    public function create()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        return view('priorities.create');
    }

    /**
     * Store a newly created priority.
     */
    public function store(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name,NULL,id,created_by,' . Auth::id(),
            'point' => 'required|integer|min:0',
        ]);

        Priority::create([
            'name' => $request->name,
            'point' => (int)$request->point,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('priority.index')->with('success', 'Priority created successfully.');
    }

    /**
     * Display the specified priority.
     */
    public function show(Priority $priority)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only view priorities they created
        if ($priority->created_by !== Auth::id()) {
            abort(403, 'You can only view priorities created by you.');
        }

        // Load relationships
        $priority->load('creator');

        return view('priorities.show', compact('priority'));
    }

    /**
     * Show the form for editing the specified priority.
     */
    public function edit(Priority $priority)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only edit priorities they created
        if ($priority->created_by !== Auth::id()) {
            abort(403, 'You can only edit priorities created by you.');
        }

        return view('priorities.edit', compact('priority'));
    }

    /**
     * Update the specified priority.
     */
    public function update(Request $request, Priority $priority)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only update priorities they created
        if ($priority->created_by !== Auth::id()) {
            abort(403, 'You can only update priorities created by you.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:priorities,name,' . $priority->id . ',id,created_by,' . Auth::id(),
            'point' => 'required|integer|min:0',
        ]);

        $priority->update([
            'name' => $request->name,
            'point' => (int)$request->point,
        ]);

        return redirect()->route('priority.index')->with('success', 'Priority updated successfully.');
    }

    /**
     * Remove the specified priority (soft delete).
     */
    public function destroy(Priority $priority)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only delete priorities they created
        if ($priority->created_by !== Auth::id()) {
            abort(403, 'You can only delete priorities created by you.');
        }

        // Soft delete the priority
        $priority->delete();

        return redirect()->route('priority.index')->with('success', 'Priority deleted successfully.');
    }

    /**
     * Remove multiple priorities (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'priority_ids' => 'required|array',
            'priority_ids.*' => 'exists:priorities,id',
        ]);

        $priorityIds = $request->priority_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($priorityIds as $priorityId) {
            $priority = Priority::find($priorityId);

            // Verify priority belongs to this admin
            if ($priority->created_by !== Auth::id()) {
                $errors[] = "Priority '{$priority->name}' cannot be deleted. You can only delete priorities created by you.";
                continue;
            }

            // Soft delete the priority
            $priority->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} priority(ies) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('priority.index')->with('error', $message);
            }
            return redirect()->route('priority.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('priority.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('priority.index')->with('error', 'No priorities were deleted.');
    }
}
