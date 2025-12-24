<?php

namespace App\Http\Controllers;

use App\Models\QuizCategory;
use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Show only categories created by the logged-in admin
        $categories = QuizCategory::where('created_by', Auth::id())
            ->with('brands')
            ->orderBy('name', 'asc')
            ->get();

        return view('quiz-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
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

        return view('quiz-category.create', compact('brands'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:quiz_categories,name,NULL,id,created_by,' . Auth::id(),
            'brand_ids' => 'required|array',
            'brand_ids.*' => 'exists:brands,id',
        ]);

        // Verify all brands belong to this admin
        $brandIds = $request->brand_ids;
        $brands = Brand::whereIn('id', $brandIds)
            ->where('created_by', Auth::id())
            ->get();

        if ($brands->count() !== count($brandIds)) {
            return back()->withErrors(['brand_ids' => 'One or more selected brands are invalid.'])->withInput();
        }

        // Create category (brand_id is now optional, using pivot table for multiple brands)
        $category = QuizCategory::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
        ]);

        // Attach all brands
        $category->brands()->attach($brandIds);

        return redirect()->route('quiz-category.index')->with('success', 'Quiz category created successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(QuizCategory $quizCategory)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only view categories they created
        if ($quizCategory->created_by !== Auth::id()) {
            abort(403, 'You can only view categories created by you.');
        }

        return view('quiz-category.show', compact('quizCategory'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuizCategory $quizCategory)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only edit categories they created
        if ($quizCategory->created_by !== Auth::id()) {
            abort(403, 'You can only edit categories created by you.');
        }

        // Get brands created by this admin
        $brands = Brand::where('created_by', Auth::id())
            ->orderBy('name', 'asc')
            ->get();

        // Load brands relationship
        $quizCategory->load('brands');

        return view('quiz-category.edit', compact('quizCategory', 'brands'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, QuizCategory $quizCategory)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only update categories they created
        if ($quizCategory->created_by !== Auth::id()) {
            abort(403, 'You can only update categories created by you.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:quiz_categories,name,' . $quizCategory->id . ',id,created_by,' . Auth::id(),
            'brand_ids' => 'required|array',
            'brand_ids.*' => 'exists:brands,id',
        ]);

        // Verify all brands belong to this admin
        $brandIds = $request->brand_ids;
        $brands = Brand::whereIn('id', $brandIds)
            ->where('created_by', Auth::id())
            ->get();

        if ($brands->count() !== count($brandIds)) {
            return back()->withErrors(['brand_ids' => 'One or more selected brands are invalid.'])->withInput();
        }

        // Update category (brand_id is now optional, using pivot table for multiple brands)
        $quizCategory->update([
            'name' => $request->name,
        ]);

        // Sync all brands
        $quizCategory->brands()->sync($brandIds);

        return redirect()->route('quiz-category.index')->with('success', 'Quiz category updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuizCategory $quizCategory)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        // Admin can only delete categories they created
        if ($quizCategory->created_by !== Auth::id()) {
            abort(403, 'You can only delete categories created by you.');
        }

        // Check if category has quizzes
        if ($quizCategory->quizzes()->count() > 0) {
            return redirect()->route('quiz-category.index')->with('error', 'Cannot delete category. It has associated quizzes.');
        }

        // Soft delete the category
        $quizCategory->delete();
        return redirect()->route('quiz-category.index')->with('success', 'Quiz category deleted successfully.');
    }

    /**
     * Remove multiple quiz categories (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Only Admin can access
        if (!Auth::user()->hasRole('Admin')) {
            abort(403, 'Unauthorized access');
        }

        $request->validate([
            'category_ids' => 'required|array',
            'category_ids.*' => 'exists:quiz_categories,id',
        ]);

        $categoryIds = $request->category_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($categoryIds as $categoryId) {
            $category = QuizCategory::find($categoryId);

            // Verify category belongs to this admin
            if ($category->created_by !== Auth::id()) {
                $errors[] = "Category '{$category->name}' cannot be deleted. You can only delete categories created by you.";
                continue;
            }

            // Check if category has quizzes
            if ($category->quizzes()->count() > 0) {
                $errors[] = "Category '{$category->name}' cannot be deleted. It has associated quizzes.";
                continue;
            }

            // Soft delete the category
            $category->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} category(ies) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('quiz-category.index')->with('error', $message);
            }
            return redirect()->route('quiz-category.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('quiz-category.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('quiz-category.index')->with('error', 'No categories were deleted.');
    }
}
