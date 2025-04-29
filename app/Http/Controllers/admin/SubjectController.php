<?php
namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ClassModel; // Updated reference to the model's namespace
use App\Models\admin\Section;
use App\Models\admin\SubjectModel;



class SubjectController extends Controller
{
    // Display the list of subjects
    public function index()
    {
        $subjects = SubjectModel::all(); // Fetch all subjects
        $classes = ClassModel::all();   // Fetch all classes
        $sections = Section::all();     // Fetch all sections
        foreach ($subjects as $subject) {
            // Get the class ID
            $classId = $subject->classes;
    
            // Find the corresponding class title
            $class = ClassModel::find($classId);
            $subject->classTitle = $class ? $class->title : 'N/A'; 
    
            // Get section titles (if any)
            $sectionIds = explode(',', $subject->sections);
            $subject->sectionTitles = Section::whereIn('id', $sectionIds)->pluck('title')->toArray(); 
        }
        return view('admin.subjects.subjects', compact('subjects', 'classes', 'sections'));
    }

    // Show the form to add a new subject
    public function create()
    {
        $classes = ClassModel::all(); // Fetch all classes
        $sections = Section::all();   // Fetch all sections
        return view('admin.subjects.create', compact('classes', 'sections'));
    }

    // Store a new subject in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'classes' => 'required|string|max:255',
            'sections' => 'required|string|max:255',
        ]);

        // Check if subject already exists for the same class and section
        $existingSubject = SubjectModel::where('name', $request->name)
            ->where('classes', $request->classes)
            ->first();

        if ($existingSubject) {
            // Convert existing sections into an array
            $existingSections = explode(',', $existingSubject->sections);
            $newSections = explode(',', $request->sections);

            // Check if the new section is already in the existing sections
            if (!array_diff($newSections, $existingSections)) {
                return response()->json([
                    'error' => 'This subject already exists for the selected class and section!'
                ], 400);
            }

            // Append the new section(s) to the existing ones
            $mergedSections = array_unique(array_merge($existingSections, $newSections));
            $existingSubject->sections = implode(',', $mergedSections);
            $existingSubject->save();

            // Fetch updated section titles
            $sections = Section::whereIn('id', $mergedSections)->pluck('title')->toArray();
            $class = ClassModel::find($existingSubject->classes);

            return response()->json([
                'success' => 'Subject updated successfully!',
                'updatedSubject' => [
                    'name' => $existingSubject->name,
                    'classTitle' => $class ? $class->title : 'N/A',
                    'sectionTitles' => $sections
                ]
            ]);
        }

        // If not exists, create a new subject
        $newSubject = SubjectModel::create([
            'name' => $request->name,
            'classes' => $request->classes,
            'sections' => $request->sections
        ]);

        $class = ClassModel::find($newSubject->classes);
        $sectionIds = explode(',', $newSubject->sections);
        $sections = Section::whereIn('id', $sectionIds)->pluck('title')->toArray();

        return response()->json([
            'success' => 'Subject added successfully!',
            'newSubject' => [
                'name' => $newSubject->name,
                'classTitle' => $class ? $class->title : 'N/A',
                'sectionTitles' => $sections
            ]
        ]);
    }

    public function getSectionsByClass($classId)
    {
        $class = ClassModel::find($classId);
        if ($class) {
            $sectionIds = explode(',', $class->sections);
            $sections = Section::whereIn('id', $sectionIds)->pluck('title', 'id');
            return response()->json($sections);
        }
        return response()->json([]);
    }

    public function edit($id)
    {
        $subjects = SubjectModel::findOrFail($id);
        $classes = ClassModel::all();
        $sections = Section::all();     // Fetch all sections

        return view('admin.subjects.edit', compact('subjects', 'classes', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $subjects = SubjectModel::findOrFail($id);
        
        // Get existing sections from the database
        $existingSections = explode(',', $subjects->sections);
        
        // Get new selected sections from the request
        $newSections = $request->sections ? $request->sections : [];
        
        // Identify removed sections
        $removedSections = array_diff($existingSections, $newSections);
        
        // Update the subject with new sections
        $subjects->update([
            'name' => $request->name,
            'classes' => $request->classes,
            'sections' => implode(',', $newSections),
        ]);
        
        return redirect()->route('admin.subjects')->with('success', 'Subjects updated successfully!');
    }

    public function destroy($id)
    {
        $examform = ExamForm::findOrFail($id);
        $examform->delete();

        return redirect()->route('admin.subjects')->with('success', 'Subjects deleted successfully!');
    }
}
