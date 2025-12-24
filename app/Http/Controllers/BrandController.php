<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BrandController extends Controller
{
    /**
     * Display a listing of brands.
     */
    public function index()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only brands created by the logged-in admin
        $brands = Brand::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        return view('brands.create');
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,NULL,id,created_by,' . Auth::id(),
        ]);

        Brand::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand created successfully.');
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only view brands they created
        if ($brand->created_by !== Auth::id()) {
            abort(403, 'You can only view brands created by you.');
        }

        // Load relationships
        $brand->load(['creator', 'users', 'quizzes', 'quizCategories']);

        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only edit brands they created
        if ($brand->created_by !== Auth::id()) {
            abort(403, 'You can only edit brands created by you.');
        }

        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, Brand $brand)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only update brands they created
        if ($brand->created_by !== Auth::id()) {
            abort(403, 'You can only update brands created by you.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id . ',id,created_by,' . Auth::id(),
        ]);

        $brand->update([
            'name' => $request->name,
        ]);

        return redirect()->route('brands.index')->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified brand (soft delete).
     */
    public function destroy(Brand $brand)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only delete brands they created
        if ($brand->created_by !== Auth::id()) {
            abort(403, 'You can only delete brands created by you.');
        }

        // Check if brand has associated users
        if ($brand->users()->count() > 0) {
            return redirect()->route('brands.index')->with('error', 'Cannot delete brand. It has associated users.');
        }

        // Check if brand has associated quizzes
        if ($brand->quizzes()->count() > 0) {
            return redirect()->route('brands.index')->with('error', 'Cannot delete brand. It has associated quizzes.');
        }

        // Check if brand has associated categories
        if ($brand->quizCategories()->count() > 0) {
            return redirect()->route('brands.index')->with('error', 'Cannot delete brand. It has associated quiz categories.');
        }

        // Soft delete the brand
        $brand->delete();

        return redirect()->route('brands.index')->with('success', 'Brand deleted successfully.');
    }

    /**
     * Remove multiple brands (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // dd($request->all());

        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'brand_ids' => 'required|array',
            'brand_ids.*' => 'exists:brands,id',
        ]);

        $brandIds = $request->brand_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($brandIds as $brandId) {
            $brand = Brand::find($brandId);

            // Verify brand belongs to this admin
            if ($brand->created_by !== Auth::id()) {
                $errors[] = "Brand '{$brand->name}' cannot be deleted. You can only delete brands created by you.";
                continue;
            }

            // Check if brand has associated users
            if ($brand->users()->count() > 0) {
                $errors[] = "Brand '{$brand->name}' cannot be deleted. It has associated users.";
                continue;
            }

            // Check if brand has associated quizzes
            if ($brand->quizzes()->count() > 0) {
                $errors[] = "Brand '{$brand->name}' cannot be deleted. It has associated quizzes.";
                continue;
            }

            // Check if brand has associated categories
            if ($brand->quizCategories()->count() > 0) {
                $errors[] = "Brand '{$brand->name}' cannot be deleted. It has associated quiz categories.";
                continue;
            }

            // Soft delete the brand
            $brand->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} brand(s) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('brands.index')->with('error', $message);
            }
            return redirect()->route('brands.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('brands.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('brands.index')->with('error', 'No brands were deleted.');
    }
}
