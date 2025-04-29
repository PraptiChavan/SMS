<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\StudyMaterials; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\SubjectModel;


class StudyMaterialsController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        $studymaterials = StudyMaterials::all();// Fetch all sections from the database
        return view('admin.studymaterials.studymaterials', compact('subjects', 'classes', 'studymaterials'));
    }

    public function create()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        return view('admin.studymaterials.create', compact('subjects', 'classes'));// View for adding a new section
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
            'classes' => 'required|string',
            'subjects' => 'required|string',
            'date' => 'required|date',
        ]);

        // Handle file upload if provided
        $attachmentPath = null;
        if ($request->hasFile('attachment')) {
            $attachmentPath = $request->file('attachment')->store('studyMaterial', 'public');
        }

        // Create a new StudyMaterial entry
        $studyMaterial = new StudyMaterials();
        $studyMaterial->title = $request->title;
        $studyMaterial->description = $request->description;
        $studyMaterial->attachment = $attachmentPath;
        $studyMaterial->classes = $request->classes;
        $studyMaterial->subjects = $request->subjects;
        $studyMaterial->date = $request->date;
        $studyMaterial->save();

        // Return a JSON success response
        return response()->json([
            'success' => true,
            'message' => 'Study material added successfully!',
        ]);
    }

    public function edit($id)
    {
        $studymaterials = StudyMaterials::findOrFail($id);
        $subjects = SubjectModel::all();
        $classes = ClassModel::all();

        return view('admin.studymaterials.edit', compact('studymaterials', 'subjects', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $studymaterials = StudyMaterials::findOrFail($id);

        $request->validate([
            'title' => 'required|string|max:100',
            'description' => 'nullable|string',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,jpg,jpeg,png',
            'classes' => 'required|string',
            'subjects' => 'required|string',
            'date' => 'required|date',
        ]);

        $data = [
            'title' => $request->title,
            'description' => $request->description,
            'classes' => $request->classes,
            'subjects' => $request->subjects,
            'date' => $request->date,
        ];

        if ($request->hasFile('attachment')) {
            // Delete old image if exists
            if ($studymaterials->attachment && Storage::exists('public/' . $studymaterials->attachment)) {
                Storage::delete('public/' . $studymaterials->attachment);
            }

            // Store new image
            $data['attachment'] = $request->file('attachment')->store('study_materials', 'public');
        }

        $studymaterials->update($data);

        return redirect()->route('admin.studymaterials')->with('success', 'Study Materials updated successfully!');
    }

    public function destroy($id)
    {
        $studymaterials = StudyMaterials::findOrFail($id);
        $studymaterials->delete();

        return redirect()->route('admin.studymaterials')->with('success', 'Study Materials deleted successfully!');
    }

}
