<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
// use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\CourseModel; // Updated reference to the model's namespace


class CourseController extends Controller
{
    public function index()
    {
        $courses = CourseModel::all();// Fetch all sections from the database
        return view('admin.courses.courses', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');// View for adding a new section
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if (CourseModel::where('name', $request->name)->exists()) {
            return response()->json(['error' => 'A course with this name already exists.'], 400);
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('courses', 'public');
        }

        $course = new CourseModel;
        $course->name = $request->name;
        $course->category = $request->category;
        $course->duration = $request->duration;
        $course->date = $request->date;
        $course->image = $imagePath;
        $course->save();

        return response()->json(['success' => 'Course added successfully!']);
    }

    public function edit($id)
    {
        $courses = CourseModel::findOrFail($id);

        return view('admin.courses.edit', compact('courses'));
    }

    public function update(Request $request, $id)
    {
        $courses = CourseModel::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'duration' => 'required|string|max:255',
            'date' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        $data = [
            'name' => $request->name,
            'category' => $request->category,
            'duration' => $request->duration,
            'date' => $request->date,
        ];

        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($courses->image && Storage::exists('public/' . $courses->image)) {
                Storage::delete('public/' . $courses->image);
            }

            // Store new image
            $data['image'] = $request->file('image')->store('courses', 'public');
        }

        $courses->update($data);

        return redirect()->route('admin.courses')->with('success', 'Course updated successfully, including the new image!');
    }

    public function destroy($id)
    {
        $courses = CourseModel::findOrFail($id);
        $courses->delete();

        return redirect()->route('admin.courses')->with('success', 'Course deleted successfully!');
    }
}
