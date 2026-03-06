<?php

namespace App\Http\Controllers\admin;

use Cloudinary\Cloudinary;
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF library
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\AdmitModel; // Updated reference to the model's namespace
use App\Models\admin\ClassModel;
use App\Models\admin\SubjectModel;
use App\Models\admin\Section;
use App\Models\admin\ExamForm;
use App\Models\admin\Student; // Import Student Model


class AdmitCardController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();   // Fetch all classes
        $sections = Section::all();
        $admitcards =[];// Fetch all sections from the database
        return view('admin.admitcard.admitcard', compact('classes', 'sections', 'admitcards'));
    }

    public function getSectionsByClass($classId)
    {
        $classes = ClassModel::find($classId);
        if ($classes) {
            $sectionIds = explode(',', $classes->sections);
            $sections = Section::whereIn('id', $sectionIds)->pluck('title', 'id');
            return response()->json($sections);
        }
        return response()->json([]);
    }

    // Show the form to add a new subject
    public function create()
    {
        $classes = ClassModel::all();   // Fetch all classes
        $sections = Section::all();
        return view('admin.admitcard.create', compact('sections', 'classes'));// View for adding a new section
    }

    public function getStudentsByClassSection($classId, $sectionId)
    {
        $students = Student::where('classes', $classId)
                            ->where('sections', $sectionId)
                            ->pluck('name', 'id'); // Fetch student names
        
        return response()->json($students);
    }

    public function store(Request $request)
    {
        // Validate request
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fees_paid' => 'required|in:Yes,No',
            'classes' => 'required|string',
            'sections' => 'required|string',
        ]);

        // If fees are not paid, prevent admit card generation
        if ($request->fees_paid === 'No') {
            return redirect()->back()->with('error', 'Admit card cannot be generated as fees are not paid.');
        }

        // Get student details
        $student = Student::find($request->student_id);

        // Fetch subjects for the student's class
        $subjects = SubjectModel::where('classes', $student->classes)->pluck('id', 'name');

        // Get all exam forms for this class
        $examForms = ExamForm::where('classes', $student->classes)->get();

        $exams = []; 
        foreach ($subjects as $subjectName => $subjectId) {
            $matchedExam = null;

            foreach ($examForms as $exam) {

                // subjects column contains comma separated subject IDs
                $subjectArray = explode(',', $exam->subjects);

                if (in_array($subjectId, $subjectArray)) {
                    $matchedExam = $exam;
                    break;
                }
            }

            $exams[] = [
                'subject' => $subjectName,
                'exam_name' => $matchedExam->name ?? 'N/A',
                'date' => $matchedExam->date ?? 'N/A',
                'time' => $matchedExam 
                    ? $matchedExam->start_time . ' - ' . $matchedExam->end_time 
                    : 'N/A',
            ];
        }

        // Generate PDF content from the Blade template
        $pdf = Pdf::loadView('admin.admitcard.pdf', compact('student', 'subjects', 'exams'))->setPaper('A4', 'portrait');
        // Save temporary PDF file
        $tempFile = tempnam(sys_get_temp_dir(), 'admitcard');
        file_put_contents($tempFile, $pdf->output());

        // Cloudinary instance
        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        // Upload PDF
        $uploadResult = $cloudinary->uploadApi()->upload(
            $tempFile,
            [
                'folder' => 'admitcards',
                'resource_type' => 'raw'
            ]
        );

        // Get Cloudinary URL
        $admitCardPath = $uploadResult['secure_url'];
        // Define storage path
        // $admitCardPath = 'admitcards/admit_card_' . time() . '.pdf';

        // Save the generated PDF in the storage folder
        // Storage::disk('public')->put($admitCardPath, $pdf->output());

        // Store Data in Database
        AdmitModel::create([
            'student_name' => $student->name,
            'fees_paid' => $request->fees_paid,
            'admit_card' => $admitCardPath,
            'classes' => $request->classes,
            'sections' => $request->sections,
        ]);

        return redirect()->route('admin.admitcards')->with('success', 'Admit card generated successfully.');
    }

    public function filterAdmitCards(Request $request)
    {
        $classId = $request->class_id;
        $sectionId = $request->section_id;

        $admitcards = AdmitModel::where('classes', $classId)
                                ->where('sections', $sectionId)
                                ->get();

        return response()->json($admitcards);
    }

    public function destroy($id)
    {
        $admitcards = AdmitModel::findOrFail($id);
        $admitcards->delete();

        return redirect()->route('admin.admitcards')->with('success', 'Admit card deleted successfully!');
    }


}