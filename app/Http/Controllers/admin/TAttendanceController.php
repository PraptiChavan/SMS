<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\PeriodModel;
use App\Models\admin\Account;
use App\Models\admin\TAttendance;
use Carbon\Carbon;

class TAttendanceController extends Controller
{
    public function index()
    {
        $teachers = Account::where('type', 'teacher')->get();
        $periods = PeriodModel::where('id', '!=', 5)->get();
        $daysInMonth = Carbon::now()->daysInMonth;

        return view('admin.attendance.tattendance', compact('periods', 'teachers', 'daysInMonth'));
    }   

    public function getAttendanceData(Request $request)
    {
        $teacherId = $request->query('teacher_id'); // Changed from period_id
        $month = $request->query('month');
        $year = $request->query('year');

        $attendance = TAttendance::where('teacher_id', $teacherId)
            ->whereYear('date', $year)
            ->whereMonth('date', $month)
            ->get(['period_id', 'teacher_id', 'date', 'status']);

        return response()->json($attendance->map(function ($record) {
            return [
                'period_id' => $record->period_id, // Changed from teacher_id
                'day' => Carbon::parse($record->date)->day,
                'status' => $record->status,
            ];
        }));
    }

    public function saveAttendance(Request $request)
    {
        foreach ($request->attendance as $record) {
            TAttendance::updateOrCreate(
                ['period_id' => $record['period_id'], 'date' => Carbon::create($request->year, $request->month, $record['day']), 'teacher_id' => $request->teacher_id],
                ['status' => $record['status']]
            );
        }

        return response()->json(['success' => true]);
    }
}

