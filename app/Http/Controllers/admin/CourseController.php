<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\admin\CourseModel;
use Cloudinary\Cloudinary;   // ✅ CHANGED (important)

class CourseController extends Controller
{
    public function index()
    {
        $courses = CourseModel::all();
        return view('admin.courses.courses', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
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

            // ✅ Create Cloudinary instance using ENV directly
            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'courses']
            );

            $imagePath = $uploadResult['secure_url'];
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

            $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

            // Delete old image if exists
            if ($courses->image) {
                $publicId = basename($courses->image, '.' . pathinfo($courses->image, PATHINFO_EXTENSION));
                $cloudinary->uploadApi()->destroy('courses/' . $publicId);
            }

            $uploadResult = $cloudinary->uploadApi()->upload(
                $request->file('image')->getRealPath(),
                ['folder' => 'courses']
            );

            $data['image'] = $uploadResult['secure_url'];
        }

        $courses->update($data);

        return redirect()->route('admin.courses')
            ->with('success', 'Course updated successfully, including the new image!');
    }

    public function destroy($id)
    {
        $courses = CourseModel::findOrFail($id);
        $courses->delete();

        return redirect()->route('admin.courses')
            ->with('success', 'Course deleted successfully!');
    }
}