<?php

namespace App\Http\Controllers\admin;

use Cloudinary\Cloudinary;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\admin\AdmitModel;
use App\Models\admin\ClassModel;
use App\Models\admin\SubjectModel;
use App\Models\admin\Section;
use App\Models\admin\ExamForm;
use App\Models\admin\Student;

class AdmitCardController extends Controller
{

    public function index()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $admitcards = [];

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


    public function create()
    {
        $classes = ClassModel::all();
        $sections = Section::all();

        return view('admin.admitcard.create', compact('sections', 'classes'));
    }


    public function getStudentsByClassSection($classId, $sectionId)
    {
        $students = Student::where('classes', $classId)
            ->where('sections', $sectionId)
            ->pluck('name', 'id');

        return response()->json($students);
    }


    public function store(Request $request)
    {

        $request->validate([
            'student_id' => 'required|exists:students,id',
            'fees_paid' => 'required|in:Yes,No',
            'classes' => 'required|string',
            'sections' => 'required|string',
        ]);


        if ($request->fees_paid === 'No') {
            return redirect()->back()->with('error', 'Admit card cannot be generated as fees are not paid.');
        }


        $student = Student::find($request->student_id);


        $subjects = SubjectModel::where('classes', $student->classes)->pluck('id', 'name');


        $examForms = ExamForm::where('classes', $student->classes)->get();


        $exams = [];

        foreach ($subjects as $subjectName => $subjectId) {

            $matchedExam = null;

            foreach ($examForms as $exam) {

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


        /*
        |--------------------------------------------------------------------------
        | Generate PDF
        |--------------------------------------------------------------------------
        */

        $pdf = Pdf::loadView('admin.admitcard.pdf', compact('student','subjects','exams'))
            ->setPaper('A4','portrait');


        $tempPath = storage_path('app/admit_card_' . time() . '.pdf');

        file_put_contents($tempPath, $pdf->output());


        /*
        |--------------------------------------------------------------------------
        | Upload PDF to Cloudinary
        |--------------------------------------------------------------------------
        */

        $cloudinary = new Cloudinary(env('CLOUDINARY_URL'));

        $uploadResult = $cloudinary->uploadApi()->upload(
            $tempPath,
            [
                'folder' => 'admitcards',
                'resource_type' => 'image',
                'type' => 'upload',
                'access_mode' => 'public',
                'public_id' => 'admit_card_' . time()
            ]
        );

        $admitCardPath = $uploadResult['secure_url'];


        /*
        |--------------------------------------------------------------------------
        | Delete Temporary File
        |--------------------------------------------------------------------------
        */

        if (file_exists($tempPath)) {
            unlink($tempPath);
        }


        /*
        |--------------------------------------------------------------------------
        | Save Record in Database
        |--------------------------------------------------------------------------
        */

        AdmitModel::create([
            'student_name' => $student->name,
            'fees_paid' => $request->fees_paid,
            'admit_card' => $admitCardPath,
            'classes' => $request->classes,
            'sections' => $request->sections,
        ]);


        return redirect()->route('admin.admitcards')
            ->with('success', 'Admit card generated successfully.');
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

        return redirect()->route('admin.admitcards')
            ->with('success', 'Admit card deleted successfully!');
    }
}