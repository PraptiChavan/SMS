<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;

class ClassController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();// Fetch classes with associated sections
        foreach ($classes as $class) {
            // Convert comma-separated section IDs into an array
            $sectionIds = explode(',', $class->sections);
    
            // Fetch the section titles using the IDs
            $class->sectionTitles = Section::whereIn('id', $sectionIds)->pluck('title')->toArray();
        }
        return view('admin.classes.classes', compact('classes'));
    }

    public function create()
    {
        $sections = Section::all();
        return view('admin.classes.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'nullable|array',
            'sections.*' => 'integer|exists:sections,id',
        ]);

        $sections = $request->sections ?? [];
        $sections = array_map('intval', $sections);
        sort($sections);

        $existingClass = ClassModel::where('title', $request->title)->first();

        if ($existingClass) {

            $existingSections = $existingClass->sections
                ? explode(',', $existingClass->sections)
                : [];

            $existingSections = array_map('intval', $existingSections);
            sort($existingSections);

            $duplicateSections = array_intersect($sections, $existingSections);

            if (!empty($duplicateSections)) {

                $duplicateTitles = Section::whereIn('id', $duplicateSections)
                    ->pluck('title')
                    ->toArray();

                return response()->json([
                    'error' => 'The following sections already exist for this class: '
                        . implode(', ', $duplicateTitles),
                ], 400);
            }

            $sections = array_merge($existingSections, $sections);
        }

        $sections = array_unique($sections);

        $class = $existingClass ?? new ClassModel;
        $class->title = $request->title;
        $class->sections = !empty($sections)
            ? implode(',', $sections)
            : null;

        $class->save();

        return response()->json([
            'success' => 'Class added successfully!'
        ]);
    }

    public function edit($id)
    {
        $classes = ClassModel::findOrFail($id);
        $sections = Section::all();

        return view('admin.classes.edit', compact('classes', 'sections'));
    }

    public function update(Request $request, $id)
    {
        // dd($request->sections);
        $classes = ClassModel::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:255',
            'sections' => 'nullable|array',
            'sections.*' => 'integer|exists:sections,id',
        ]);

        // Get new selected sections from the request
        $newSections = $request->sections ?? [];

        // Convert to a comma-separated string for storage
        $sections = !empty($newSections) ? implode(',', $newSections) : null;

        // Update the class with the new sections
        $classes->update([
            'title' => $request->title,
            'sections' => $sections, // This will update the sections column
        ]);

        return redirect()->route('admin.classes')->with('success', 'Class updated successfully!');
    }

    public function destroy($id)
    {
        $classes = ClassModel::findOrFail($id);
        $classes->delete();

        return redirect()->route('admin.classes')->with('success', 'Class deleted successfully!');
    }
}
