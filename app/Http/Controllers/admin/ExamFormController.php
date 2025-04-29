<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ExamForm; // Updated reference to the model's namespace
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\SubjectModel;


class ExamFormController extends Controller
{
    public function index()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        $examform = ExamForm::all();// Fetch all sections from the database
        return view('admin.examform.examform', compact('subjects', 'classes', 'examform'));
    }

    public function create()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        return view('admin.examform.create', compact('subjects', 'classes'));// View for adding a new section
    }

    public function store(Request $request)
    {
        // Validate the incoming request data
        $request->validate([
            'name' => 'required|string|max:100',
            'classes' => 'required|string',
            'subjects' => 'required|string',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'total_marks' => 'required|string|max:100',
        ]);

        // Check if the exam already exists for the same class and subject
        if (ExamForm::where('classes', $request->classes)
            ->where('subjects', $request->subjects)
            ->where('name', $request->name)
            ->exists()) {
            return response()->json(['error' => 'This Exam already exists for this Class and Subject!'], 400);
        }

        // Create a new ExamForm entry
        $examform = new ExamForm();
        $examform->name = $request->name;
        $examform->classes = $request->classes;
        $examform->subjects = $request->subjects;
        $examform->date = $request->date;
        $examform->start_time = $request->start_time;
        $examform->end_time = $request->end_time;
        $examform->total_marks = $request->total_marks;
        $examform->save();

        // Return a JSON success response
        return response()->json([
            'success' => true,
            'message' => 'Exam Schedule added successfully!',
        ]);
    }

    public function edit($id)
    {
        $examform = ExamForm::findOrFail($id);
        $subjects = SubjectModel::all();
        $classes = ClassModel::all();

        return view('admin.examform.edit', compact('examform', 'subjects', 'classes'));
    }

    public function update(Request $request, $id)
    {
        $examform = ExamForm::findOrFail($id);
        $examform->update([
            'name' => $request->name,
            'classes' => $request->classes,
            'subjects' => $request->subjects,
            'date' => $request->date,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'total_marks' => $request->total_marks,
        ]);
        return redirect()->route('admin.examform')->with('success', 'Exam Schedule updated successfully!');
    }

    public function destroy($id)
    {
        $examform = ExamForm::findOrFail($id);
        $examform->delete();

        return redirect()->route('admin.examform')->with('success', 'Exam Schedule deleted successfully!');
    }

}
