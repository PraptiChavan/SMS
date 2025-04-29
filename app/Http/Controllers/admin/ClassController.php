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
            'sections' => 'nullable|array', // Sections are optional
            'sections.*' => 'string|max:255',
        ]);

        // Ensure sections are stored as an array of strings
        $sections = $request->sections ? array_map('strval', $request->sections) : [];

        // Sort sections for consistency
        sort($sections);

        // Check if a class with the same title already exists
        $existingClass = ClassModel::where('title', $request->title)->first();

        if ($existingClass) {
            // Fetch the existing sections and ensure they are stored as an array of strings
            $existingSections = $existingClass->sections ? array_map('trim', explode(',', $existingClass->sections)) : [];
            sort($existingSections);

            // Debugging: Check what sections are being compared
            // logger("Existing Sections: " . implode(", ", $existingSections));
            // logger("New Sections: " . implode(", ", $sections));

            // Check if any of the new sections already exist
            $duplicateSections = array_intersect($sections, $existingSections);

            if (!empty($duplicateSections)) {
                return response()->json([
                    'error' => 'The following sections already exist for this class: ' . implode(', ', Section::whereIn('id', explode(',', implode(',', $duplicateSections)))->pluck('title')->toArray()),
                ], 400); // Return 400 Bad Request
            }

            // Merge new sections with existing ones
            $sections = array_merge($existingSections, $sections);
        }

        // Remove duplicates from the final list
        $sections = array_unique($sections);

        // Update or create the class with sections
        $class = $existingClass ?? new ClassModel;
        $class->title = $request->title;
        $class->sections = !empty($sections) ? implode(', ', $sections) : null;
        $class->save();

        return response()->json([
            'success' => 'Class with selected sections added successfully!',
            'newClass' => $class,
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
