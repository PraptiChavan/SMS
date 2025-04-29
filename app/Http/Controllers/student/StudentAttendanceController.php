<?php

namespace App\Http\Controllers\student;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session; 
use App\Http\Controllers\Controller;
use App\Models\admin\Account;
use App\Models\admin\Student;
use App\Models\admin\Section;
use App\Models\admin\PeriodModel;
use App\Models\admin\Attendance; // Import Attendance model
use Carbon\Carbon;

class StudentAttendanceController extends Controller
{
    public function index()
    {
        // Get the logged-in student's ID from the session
        $userId = Session::get('user_id');

        // Fetch student details from the accounts table
        $student = Account::where('id', $userId)->first();

        // Fetch student class from the students table (if exists)
        $studentClass = Student::where('email', $student->email)->value('classes');

        // Fetch student section IDs
        $studentSectionIds = Student::where('email', $student->email)->value('sections');

        // Convert section IDs to an array (assuming it's stored as JSON or comma-separated)
        $studentSectionIds = explode(',', $studentSectionIds);

        // Fetch section names from the sections table
        $studentSections = Section::whereIn('id', $studentSectionIds)->pluck('title')->toArray();

        $periods = PeriodModel::where('id', '!=', 5)->get();

        // Get current month and year
        $today = Carbon::now();
        $totalPeriods = $periods->count();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        return view('student.attendance.attendance', compact('student', 'studentClass', 'studentSections', 'periods', 'totalPeriods', 'currentMonth', 'currentYear'));
    }

    // New method to fetch attendance data based on the selected month, year, and period
    public function getAttendanceData($studentId, Request $request)
    {
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);
        $periodId = $request->query('period_id');

        $attendance = Attendance::where('student_id', $studentId)
            ->where('period_id', $periodId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'ASC')
            ->get(['student_id', 'date', 'status']);

        return response()->json($attendance->map(function ($record) {
            return [
                'day' => Carbon::parse($record->date)->day,
                'status' => $record->status === 'P' ? '✅' : '❌', // Mark 'P' as ✅ and 'A' as ❌
            ];
        }));
    }
}
