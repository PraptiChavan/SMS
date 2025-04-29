<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\ResultModel; // Updated reference to the model's namespace
use App\Models\admin\ClassModel;
use App\Models\admin\SubjectModel;
use App\Models\admin\Section;
use App\Models\admin\ExamForm;
use App\Models\admin\Student; // Import Student Model
use Barryvdh\DomPDF\Facade\Pdf; // Import PDF library


class TeacherResultController extends Controller
{
    public function index()
    {
        $classes = ClassModel::all();
        $sections = Section::all();
        $examform = ExamForm::selectRaw('MIN(id) as id, name')->groupBy('name')->get();
        $subjects = SubjectModel::all();

        $results = collect(); // Start with an empty collection (no results initially)

        // Only fetch results if filters are provided
        if (request()->has(['class_id', 'section_id']) && request('class_id') && request('section_id')) {
            $results = ResultModel::where('classes', request('class_id'))
                ->where('sections', request('section_id'))
                ->get()->map(function ($result) {
                    // Convert IDs to names
                    $exam = ExamForm::find($result->exam_name);
                    $result->exam_name = $exam ? $exam->name : 'N/A';

                    $subjectIds = explode(',', $result->subjects);
                    $subjectNames = SubjectModel::whereIn('id', $subjectIds)->pluck('name')->toArray();
                    $result->subjects = implode(', ', $subjectNames);

                    $class = ClassModel::find($result->classes);
                    $result->classes = $class ? $class->title : 'N/A';

                    $section = Section::find($result->sections);
                    $result->sections = $section ? $section->title : 'N/A';

                    return $result;
                });
        }

        return view('teacher.results.results', compact('classes', 'sections', 'results', 'examform', 'subjects'));
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
        $examform = ExamForm::selectRaw('MIN(id) as id, name')->groupBy('name')->get();
        $subjects = SubjectModel::all();
        return view('teacher.results.create', compact('sections', 'classes', 'examform', 'subjects'));// View for adding a new section
    }

    public function getStudentsByClassSection($classId, $sectionId)
    {
        $students = Student::where('classes', $classId)
                            ->where('sections', $sectionId)
                            ->pluck('name', 'id'); // Fetch student names

        if ($students->isEmpty()) {
            return response()->json(['error' => 'No students found'], 404);
        }
        
        return response()->json($students);
    }

    public function getExamTotal($examId)
    {
        $exam = ExamForm::find($examId);

        if ($exam) {
            return response()->json(['total_marks' => $exam->total_marks]);
        }

        return response()->json(['total_marks' => 0], 404);
    }   

    public function getExamsByClass($classId)
    {
        $exams = ExamForm::where('classes', $classId)->pluck('name', 'id');
        return response()->json($exams);
    }    

    public function store(Request $request)
    {
        // ✅ Validate incoming data
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'classes' => 'required|string',
            'sections' => 'required|string',
            'exam_name' => 'required|string',
            'subjects' => 'required|array',
            'total_marks' => 'required|array',
            'obtained_marks' => 'required|array',
            'percentage' => 'required|array',
            'grade' => 'required|array',
        ]);

        // ✅ Fetch student data
        $student = Student::findOrFail($request->student_id);

        // ✅ Convert arrays to comma-separated strings
        $cleanSubjects = array_map(function($subject) {
            return trim(str_replace('*', '', $subject));
        }, $request->subjects);

        $subjects = implode(',', $cleanSubjects);
        $totalMarks = implode(',', $request->total_marks);
        $obtainedMarks = implode(',', $request->obtained_marks);
        $percentages = implode(',', $request->percentage);
        $grades = implode(',', $request->grade);

        // ✅ Store result data into the database
        $result = ResultModel::create([
            'student_name' => $student->name,
            'results' => json_encode([
                'total_marks' => $totalMarks,
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentages,
                'grade' => $grades,
            ]),
            'classes' => $request->classes,
            'sections' => $request->sections,
            'exam_name' => $request->exam_name,
            'subjects' => $subjects,
            'total_marks' => $totalMarks,
            'obtained_marks' => $obtainedMarks,
            'percentage' => $percentages,
            'grade' => $grades,
        ]);

        // ✅ Prepare data for the PDF
        $pdfData = [
            'student' => $student,
            'exam_name' => ExamForm::find($request->exam_name)->name ?? 'N/A',
            'subjects' => $subjects, // ✅ Already clean and comma-separated
            'total_marks' => $totalMarks,
            'obtained_marks' => $obtainedMarks,
            'percentage' => $percentages,
            'grade' => $grades,
        ];

        // ✅ Generate PDF file
        $pdf = Pdf::loadView('teacher.results.pdf', $pdfData)->setPaper('A4', 'portrait');

        // ✅ Define path to store result PDF
        $resultPath = 'results/result_' . time() . '.pdf';
        Storage::disk('public')->put($resultPath, $pdf->output());

        // ✅ Save the PDF path to the result record
        $result->update(['results' => $resultPath]);

        return redirect()->route('teacher.results')->with('success', 'Result generated successfully!');
    }

    private function calculateGrade($percentage)
    {
        if ($percentage >= 90) return 'A+';
        if ($percentage >= 80) return 'A';
        if ($percentage >= 70) return 'B';
        if ($percentage >= 60) return 'C';
        if ($percentage >= 50) return 'D';
        return 'F'; // Below 50% is a fail
    }

    public function filter(Request $request)
    {
        $results = ResultModel::where('classes', $request->class_id)
            ->where('sections', $request->section_id)
            ->get()
            ->map(function ($result) {
                // Convert Exam ID to Name
                $exam = ExamForm::find($result->exam_name);
                $result->exam_name = $exam ? $exam->name : 'N/A';

                // Convert Subject IDs to Names
                $subjectIds = explode(',', $result->subjects);
                $subjectNames = SubjectModel::whereIn('id', $subjectIds)->pluck('name')->toArray();
                $result->subjects = implode(', ', $subjectNames);

                return $result;
            });

        return response()->json($results);
    }

    public function checkDuplicateResult(Request $request)
    {
        $student = Student::find($request->student_name); // Ensure it's an ID
        $exists = ResultModel::where('student_name', $student->name) // Match by name from student record
            ->where('classes', $request->classes)
            ->where('sections', $request->sections)
            ->where('exam_name', $request->exam_name)
            ->exists();

        return response()->json(['exists' => $exists]);
    }

    public function edit($id)
    {
        $result = ResultModel::findOrFail($id);
        $classes = ClassModel::all();
        $sections = Section::all();
        $examform = ExamForm::selectRaw('MIN(id) as id, name')->groupBy('name')->get();
        $subjects = SubjectModel::all();

        // Fetch students by class and section
        $students = Student::where('classes', $result->classes)
                            ->where('sections', $result->sections)
                            ->get();

        // Ensure the selected student is marked
        $selectedStudent = Student::where('name', $result->student_name)->first();
        $result->results = json_decode($result->results, true);

        return view('teacher.results.edit', compact('classes', 'sections', 'result', 'examform', 'subjects', 'students', 'selectedStudent'));
    }

    // Update Method: Saves changes to the existing record
    public function update(Request $request, $id)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'classes' => 'required|string',
            'sections' => 'required|string',
            'exam_name' => 'required|string',
            'subjects' => 'required|array',
            'total_marks' => 'required|array',
            'obtained_marks' => 'required|array',
            'percentage' => 'required|array',
            'grade' => 'required|array',
        ]);

        // ✅ Fetch student data
        $student = Student::findOrFail($request->student_id);

        // ✅ Convert arrays to comma-separated strings
        $cleanSubjects = array_map(fn($subject) => trim(str_replace('*', '', $subject)), $request->subjects);

        $subjects = implode(',', $cleanSubjects);
        $totalMarks = implode(',', $request->total_marks);
        $obtainedMarks = implode(',', $request->obtained_marks);
        $percentages = implode(',', $request->percentage);
        $grades = implode(',', $request->grade);

        // ✅ Fetch the existing result record
        $result = ResultModel::findOrFail($id);

        // ✅ Update the record
        $result->update([
            'student_name' => $student->name,
            'results' => json_encode([
                'total_marks' => $totalMarks,
                'obtained_marks' => $obtainedMarks,
                'percentage' => $percentages,
                'grade' => $grades,
            ]),
            'classes' => $request->classes,
            'sections' => $request->sections,
            'exam_name' => $request->exam_name,
            'subjects' => $subjects,
            'total_marks' => $totalMarks,
            'obtained_marks' => $obtainedMarks,
            'percentage' => $percentages,
            'grade' => $grades,
        ]);

        // ✅ Prepare data for the PDF
        $pdfData = [
            'student' => $student,
            'exam_name' => ExamForm::find($request->exam_name)->name ?? 'N/A',
            'subjects' => $subjects,
            'total_marks' => $totalMarks,
            'obtained_marks' => $obtainedMarks,
            'percentage' => $percentages,
            'grade' => $grades,
        ];

        // ✅ Generate PDF file
        $pdf = Pdf::loadView('teacher.results.pdf', $pdfData)->setPaper('A4', 'portrait');

        // ✅ Define path to store result PDF (replace old PDF if exists)
        $resultPath = 'results/result_' . $result->id . '.pdf';

        if (Storage::disk('public')->exists($resultPath)) {
            Storage::disk('public')->delete($resultPath); // Delete old PDF
        }

        Storage::disk('public')->put($resultPath, $pdf->output());

        // ✅ Save the PDF path to the result record
        $result->update(['results' => $resultPath]);

        return redirect()->route('teacher.results')->with('success', 'Result updated successfully!');
    }

    public function destroy($id)
    {
        $results = ResultModel::findOrFail($id);
        $results->delete();

        return redirect()->route('teacher.results')->with('success', 'Result deleted successfully!');
    }

    public function getSubjectsByExam($examId)
    {
        try {
            // Find the exam by ID
            $exam = ExamForm::find($examId);

            // Ensure the exam exists before proceeding
            if (!$exam) {
                return response()->json(['error' => 'Exam not found'], 404);
            }

            // Fetch all subjects related to this exam (by exam name) with clear table prefixes
            $subjects = ExamForm::where('examform.name', $exam->name) // Specify table name for 'name'
                ->join('subjects', 'examform.subjects', '=', 'subjects.id') // Join with subjects table
                ->select('subjects.name as subject_name', 'examform.total_marks') // Get subject name & marks
                ->get();

            // Map and return subject data
            $subjectData = $subjects->map(function ($exam) {
                return [
                    'name' => $exam->subject_name,
                    'total_marks' => $exam->total_marks
                ];
            });

            return response()->json($subjectData);

        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch subjects', 'message' => $e->getMessage()], 500);
        }
    }


}