<?php

namespace App\Http\Controllers\teacher;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session; 
use App\Models\admin\PeriodModel;
use App\Models\admin\Account;
use App\Models\admin\TAttendance;
use Carbon\Carbon;

class TeacherMyAttendanceController extends Controller
{
    public function index()
    {
        $userId = Session::get('user_id');

        $teacher = Account::where('id', $userId)->first();
        $periods = PeriodModel::all();
        $today = Carbon::now();
        $currentMonth = $today->month;
        $currentYear = $today->year;

        return view('teacher.attendance.my_attendance', compact('teacher','periods', 'currentMonth', 'currentYear'));
    }

    // New method to fetch attendance data based on the selected month, year, and period
    public function getAttendanceData($teacherId, Request $request)
    {
        $periodId = $request->query('period_id');
        $month = $request->query('month', Carbon::now()->month);
        $year = $request->query('year', Carbon::now()->year);

        $attendance = TAttendance::where('teacher_id', $teacherId)
            ->where('period_id', $periodId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->orderBy('date', 'ASC')
            ->get(['teacher_id', 'date', 'status']);

        return response()->json($attendance->map(function ($record) {
            return [
                'day' => Carbon::parse($record->date)->day,
                'status' => $record->status === 'P' ? '✅' : '❌',
            ];
        }));
    }
}
