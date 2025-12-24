<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LanguageController extends Controller
{
    /**
     * Display a listing of languages.
     */
    public function index()
    {
        // Check dynamic permission for language module index action
        // if (!Auth::user()->hasModulePermission('language', 'index')) {
        //     abort(403, 'Unauthorized access');
        // }

        // Show only languages created by the logged-in admin
        $languages = Language::where('created_by', Auth::id())
            ->orderBy('created_at', 'desc')
            ->get();

        return view('languages.index', compact('languages'));
    }

    /**
     * Show the form for creating a new language.
     */
    public function create()
    {
        // Check dynamic permission for language module create action
        // if (!Auth::user()->hasModulePermission('language', 'create')) {
        //     abort(403, 'Unauthorized access');
        // }

        return view('languages.create');
    }

    /**
     * Store a newly created language.
     */
    public function store(Request $request)
    {
        // Check dynamic permission for language module create action
        // if (!Auth::user()->hasModulePermission('language', 'create')) {
        //     abort(403, 'Unauthorized access');
        // }

        $request->validate([
            'name' => 'required|string|max:255|unique:languages,name,NULL,id,created_by,' . Auth::id(),
        ]);

        Language::create([
            'name' => $request->name,
            'created_by' => Auth::id(),
        ]);

        return redirect()->route('languages.index')->with('success', 'Language created successfully.');
    }

    /**
     * Display the specified language.
     */
    public function show(Language $language)
    {
        // Check dynamic permission for language module view action
        // if (!Auth::user()->hasModulePermission('language', 'view')) {
        //     abort(403, 'Unauthorized access');
        // }

        // Admin can only view languages they created
        if ($language->created_by !== Auth::id()) {
            abort(403, 'You can only view languages created by you.');
        }

        // Load relationships
        $language->load('creator');

        return view('languages.show', compact('language'));
    }

    /**
     * Show the form for editing the specified language.
     */
    public function edit(Language $language)
    {
        // Check dynamic permission for language module edit action
        // if (!Auth::user()->hasModulePermission('language', 'edit')) {
        //     abort(403, 'Unauthorized access');
        // }

        // Admin can only edit languages they created
        if ($language->created_by !== Auth::id()) {
            abort(403, 'You can only edit languages created by you.');
        }

        return view('languages.edit', compact('language'));
    }

    /**
     * Update the specified language.
     */
    public function update(Request $request, Language $language)
    {
        // Check dynamic permission for language module edit action
        // if (!Auth::user()->hasModulePermission('language', 'edit')) {
        //     abort(403, 'Unauthorized access');
        // }

        // Admin can only update languages they created
        if ($language->created_by !== Auth::id()) {
            abort(403, 'You can only update languages created by you.');
        }

        $request->validate([
            'name' => 'required|string|max:255|unique:languages,name,' . $language->id . ',id,created_by,' . Auth::id(),
        ]);

        $language->update([
            'name' => $request->name,
        ]);

        return redirect()->route('languages.index')->with('success', 'Language updated successfully.');
    }

    /**
     * Remove the specified language (soft delete).
     */
    public function destroy(Language $language)
    {
        // Check dynamic permission for language module delete action
        // if (!Auth::user()->hasModulePermission('language', 'delete')) {
        //     abort(403, 'Unauthorized access');
        // }

        // Admin can only delete languages they created
        if ($language->created_by !== Auth::id()) {
            abort(403, 'You can only delete languages created by you.');
        }

        // Soft delete the language
        $language->delete();

        return redirect()->route('languages.index')->with('success', 'Language deleted successfully.');
    }

    /**
     * Remove multiple languages (bulk delete).
     */
    public function bulkDestroy(Request $request)
    {
        // Check dynamic permission for language module delete action
        // if (!Auth::user()->hasModulePermission('language', 'delete')) {
        //     abort(403, 'Unauthorized access');
        // }

        $request->validate([
            'language_ids' => 'required|array',
            'language_ids.*' => 'exists:languages,id',
        ]);

        $languageIds = $request->language_ids;
        $deletedCount = 0;
        $errors = [];

        foreach ($languageIds as $languageId) {
            $language = Language::find($languageId);

            // Verify language belongs to this admin
            if ($language->created_by !== Auth::id()) {
                $errors[] = "Language '{$language->name}' cannot be deleted. You can only delete languages created by you.";
                continue;
            }

            // Soft delete the language
            $language->delete();
            $deletedCount++;
        }

        if ($deletedCount > 0) {
            $message = "{$deletedCount} language(s) deleted successfully.";
            if (count($errors) > 0) {
                $message .= " " . implode(' ', $errors);
                return redirect()->route('languages.index')->with('error', $message);
            }
            return redirect()->route('languages.index')->with('success', $message);
        }

        if (count($errors) > 0) {
            return redirect()->route('languages.index')->with('error', implode(' ', $errors));
        }

        return redirect()->route('languages.index')->with('error', 'No languages were deleted.');
    }
}
