<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\Section; // Updated reference to the model's namespace

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();// Fetch all sections from the database
        return view('admin.sections.sections', compact('sections'));
    }

    public function create()
    {
        return view('admin.sections.create');// View for adding a new section
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
        ]);

        // Check if section title already exists
        if (Section::where('title', $request->title)->exists()) {
            return response()->json(['error' => 'Section already exists!'], 400);
        }

        // If not exists, create the section
        $newSection = Section::create(['title' => $request->title]);

        return response()->json([
            'success' => 'Section added successfully!',
            'newSection' => $newSection
        ]);
    }

    public function edit($id)
    {
        $sections = Section::findOrFail($id);

        return view('admin.sections.edit', compact('sections'));
    }

    public function update(Request $request, $id)
    {
        $sections = Section::findOrFail($id);
        $sections->update([
            'title' => $request->title,
        ]);
        return redirect()->route('admin.sections')->with('success', 'Sections updated successfully!');
    }

    public function destroy($id)
    {
        $sections = Section::findOrFail($id);
        $sections->delete();

        return redirect()->route('admin.sections')->with('success', 'Sections deleted successfully!');
    }
}
