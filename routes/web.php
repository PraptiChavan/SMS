<?php

use Illuminate\Support\Facades\Route;//Admin Route
use App\Http\Controllers\admin\ClassController;//Admin Route
use App\Http\Controllers\admin\SectionController;//Admin Route
use App\Http\Controllers\admin\CourseController;//Admin Route
use App\Http\Controllers\admin\SubjectController;//Admin Route
use App\Http\Controllers\admin\TimeController;//Admin Route
use App\Http\Controllers\admin\AuthManager;//Admin Route
use App\Http\Controllers\admin\UserAccountController;//Admin Route
use App\Http\Controllers\admin\PeriodController;//Admin Route
use App\Http\Controllers\admin\FeeController;//Admin Route
use App\Http\Controllers\admin\AttendanceController;//Admin Route
use App\Http\Controllers\admin\TAttendanceController;//Admin Route
use App\Http\Controllers\admin\StudyMaterialsController;//Admin Route
use App\Http\Controllers\admin\ExamFormController;//Admin Route
use App\Http\Controllers\admin\AdmitCardController;//Admin Route
use App\Http\Controllers\admin\ResultController;//Admin Route
use App\Http\Controllers\admin\EventController;//Admin Route
use App\Http\Controllers\admin\ParentMeetingController;//Admin Route
use App\Http\Controllers\DashboardController;

use App\Http\Controllers\student\StudentCourseController;//Student Route
use App\Http\Controllers\student\StudentSubjectController;//Student Route
use App\Http\Controllers\student\StudentPeriodController;//Student Route
use App\Http\Controllers\student\StudentTimeController;//Student Route
use App\Http\Controllers\student\StudentFeeController;//Student Route
use App\Http\Controllers\student\StudentAttendanceController;//Student Route
use App\Http\Controllers\student\StudentStudyMaterialsController;//Student Route
use App\Http\Controllers\student\StudentProfileController;//Student Route
use App\Http\Controllers\student\StudentExamFormController;//Student Route
use App\Http\Controllers\student\StudentAdmitCardController;//Student Route
use App\Http\Controllers\student\StudentResultController;//Student Route

use App\Http\Controllers\teacher\TeacherAttendanceController;//Teacher Route
use App\Http\Controllers\teacher\TeacherMyAttendanceController;//Teacher Route
use App\Http\Controllers\teacher\TeacherCourseController;//Teacher Route
use App\Http\Controllers\teacher\TeacherSubjectController;//Teacher Route
use App\Http\Controllers\teacher\TeacherPeriodController;//Teacher Route
use App\Http\Controllers\teacher\TeacherTimeController;//Teacher Route
use App\Http\Controllers\teacher\TeacherStudyMaterialsController;//Teacher Route
use App\Http\Controllers\teacher\TeacherMeetingController;//Teacher Route
use App\Http\Controllers\teacher\TeacherExamFormController;//Teacher Route
use App\Http\Controllers\teacher\TeacherResultController;//Teacher Route

use App\Http\Controllers\parent\ParentProfileController;//Parent Route
use App\Http\Controllers\parent\ParentCourseController;//Parent Route
use App\Http\Controllers\parent\ParentSubjectController;//Parent Route
use App\Http\Controllers\parent\ParentPeriodController;//Parent Route
use App\Http\Controllers\parent\ParentTimeController;//Parent Route
use App\Http\Controllers\parent\ParentAttendanceController;//Parent Route
use App\Http\Controllers\parent\ParentStudyMaterialsController;//Parent Route
use App\Http\Controllers\parent\ParentExamFormController;//Parent Route
use App\Http\Controllers\parent\ParentAdmitCardController;//Parent Route
use App\Http\Controllers\parent\ParentResultController;//Parent Route
use App\Http\Controllers\parent\MeetingController;//Parent Route

// Home route
Route::get('/', function () {
    $courses = \App\Models\admin\CourseModel::all(); // Fetch all courses from the database
    return view('welcome', compact('courses')); // Ensure 'welcome.blade.php' exists
})->name('home');

// Login routes
Route::get('/login', function () {
    return view('auth.login'); // Ensure 'auth/login.blade.php' exists
})->name('login');
Route::post('/login', [AuthManager::class, 'login'])->name('login.submit');

// Logout route 
Route::get('/logout', [AuthManager::class, 'logout'])->name('logout');

// Admin Dashboard route
Route::get('/admin/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');

// Student Dashboard route
Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');

// Classes Management Routes
Route::get('/admin/classes', [ClassController::class, 'index'])->name('admin.classes');// View all classes
Route::get('/admin/classes/add', [ClassController::class, 'create'])->name('admin.classes.add');// Add class form
Route::post('/admin/classes/store', [ClassController::class, 'store'])->name('admin.classes.store');// Store class
// New Routes for Edit & Delete
Route::get('/admin/classes/edit/{id}', [ClassController::class, 'edit'])->name('admin.classes.edit');
Route::post('/admin/classes/update/{id}', [ClassController::class, 'update'])->name('admin.classes.update');
Route::delete('/admin/classes/destroy/{id}', [ClassController::class, 'destroy'])->name('admin.classes.destroy');

// Sections Management Routes
Route::get('/admin/sections', [SectionController::class, 'index'])->name('admin.sections');// View sections
Route::get('/admin/sections/create', [SectionController::class, 'create'])->name('admin.sections.create');// Add section form
Route::post('/admin/sections/store', [SectionController::class, 'store'])->name('admin.sections.store');// Store section
// New Routes for Edit & Delete
Route::get('/admin/sections/edit/{id}', [SectionController::class, 'edit'])->name('admin.sections.edit'); // Edit form
Route::post('/admin/sections/update/{id}', [SectionController::class, 'update'])->name('admin.sections.update'); // Update action
Route::delete('/admin/sections/destroy/{id}', [SectionController::class, 'destroy'])->name('admin.sections.destroy'); // Delete action

// Courses Management Routes
Route::get('/admin/courses', [CourseController::class, 'index'])->name('admin.courses');// View all classes
Route::get('/admin/courses/create', [CourseController::class, 'create'])->name('admin.courses.create');// Add class form
Route::post('/admin/courses/store', [CourseController::class, 'store'])->name('admin.courses.store');// Store class
// New Routes for Edit & Delete
Route::get('/admin/courses/edit/{id}', [CourseController::class, 'edit'])->name('admin.courses.edit');
Route::post('/admin/courses/update/{id}', [CourseController::class, 'update'])->name('admin.courses.update');
Route::delete('/admin/courses/destroy/{id}', [CourseController::class, 'destroy'])->name('admin.courses.destroy');

// User Account Management Routes
Route::get('/user-accounts/{user}', [UserAccountController::class, 'index'])->name('user.account');  // Show list of accounts
Route::get('/user-accounts/{user}/create', [UserAccountController::class, 'create'])->name('user.account.create');  // Show create form
Route::post('/user-accounts/store', [UserAccountController::class, 'store'])->name('user.account.store');  // Store new user
Route::get('get-sections/{classId}', [App\Http\Controllers\admin\UserAccountController::class, 'getSectionsByClass']);
// New Routes for Edit & Delete
Route::get('/admin/users/{id}/edit', [UserAccountController::class, 'edit'])->name('user.account.edit');
Route::post('/admin/users/{id}/update', [UserAccountController::class, 'update'])->name('user.account.update');
Route::get('/admin/users/{id}/delete', [UserAccountController::class, 'destroy'])->name('user.account.delete');

//Subject Management Routes
Route::get('/admin/subjects', [SubjectController::class, 'index'])->name('admin.subjects');// View all subjects
Route::get('/admin/subjects/create', [SubjectController::class, 'create'])->name('admin.subjects.create');// Add subjects form
Route::post('/admin/subjects', [SubjectController::class, 'store'])->name('admin.subjects.store');// Store subjects
Route::get('/get-sections/{classId}', [App\Http\Controllers\admin\SubjectController::class, 'getSectionsByClass']);// Fetch sections dynamically
// New Routes for Edit & Delete
Route::get('/admin/subjects/edit/{id}', [SubjectController::class, 'edit'])->name('admin.subjects.edit');
Route::post('/admin/subjects/update/{id}', [SubjectController::class, 'update'])->name('admin.subjects.update');
Route::delete('/admin/subjects/destroy/{id}', [SubjectController::class, 'destroy'])->name('admin.subjects.destroy');

// Lessons Management Routes
Route::get('/admin/lessons/lessons', function () {
    return view('admin.lessons.lessons'); 
})->name('admin.lessons');

// Periods Management Routes
Route::get('/admin/periods', [PeriodController::class, 'index'])->name('admin.periods');// View all periods
Route::get('/admin/periods/create', [PeriodController::class, 'create'])->name('admin.periods.create');// Add periods form
Route::post('/admin/periods', [PeriodController::class, 'store'])->name('admin.periods.store');// Store periods
// New Routes for Edit & Delete
Route::get('/admin/periods/edit/{id}', [PeriodController::class, 'edit'])->name('admin.periods.edit');
Route::post('/admin/periods/update/{id}', [PeriodController::class, 'update'])->name('admin.periods.update');
Route::delete('/admin/periods/destroy/{id}', [PeriodController::class, 'destroy'])->name('admin.periods.destroy');

// Time Table Management Routes
Route::get('admin/time-table', [TimeController::class, 'index'])->name('admin.time-table');// View all time-table
Route::get('/get-sections/{classId}', [App\Http\Controllers\admin\TimeController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('admin/time-table/create', [TimeController::class, 'create'])->name('admin.time-table.create');// Add time-table form
Route::post('admin/time-table/store', [TimeController::class, 'store'])->name('admin.time-table.store');// Store time-table
Route::get('/filter-time-table', [TimeController::class, 'filterTimeTable']);
Route::get('/filter-time-table-by-teacher', [TimeController::class, 'filterTimeTableByTeacher']);
// New Routes for Edit & Delete
Route::get('/admin/time-table/edit/{id}', [TimeController::class, 'edit'])->name('admin.time-table.edit');
Route::post('/admin/time-table/update/{id}', [TimeController::class, 'update'])->name('admin.time-table.update');
Route::delete('/admin/time-table/destroy/{id}', [TimeController::class, 'destroy'])->name('admin.time-table.destroy');
Route::get('admin/time-table/check-teacher-availability', [TimeController::class, 'checkTeacherAvailability']);

// Fee Management Routes
Route::get('admin/student-fee', [FeeController::class, 'index'])->name('admin.student-fee');

// Student's-Attendance Management Routes
Route::get('admin/attendance', [AttendanceController::class, 'index'])->name('admin.attendance');
Route::get('/get-sections/{classId}', [App\Http\Controllers\admin\AttendanceController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('/get-students/{classId}/{sectionId}', [App\Http\Controllers\admin\AttendanceController::class, 'getStudentsByClassAndSection']);
Route::get('/get-attendance/{classId}/{sectionId}', [App\Http\Controllers\admin\AttendanceController::class, 'getAttendanceData']);
Route::post('/save-attendance', [AttendanceController::class, 'saveAttendance'])->name('save.attendance');
// Teacher's-Attendance Management Routes
Route::get('admin/tattendance', [TAttendanceController::class, 'index'])->name('admin.tattendance');
Route::post('save-teacher-attendance', [TAttendanceController::class, 'saveAttendance'])->name('save.teacher.attendance');
Route::get('/attendance/fetch', [TAttendanceController::class, 'getAttendanceData'])->name('attendance.fetch');

// Study-Materials Management Routes
Route::get('/admin/studymaterials', [StudyMaterialsController::class, 'index'])->name('admin.studymaterials');// View all classes
Route::get('/admin/studymaterials/create', [StudyMaterialsController::class, 'create'])->name('admin.studymaterials.create');// Add class form
Route::post('/admin/studymaterials/store', [StudyMaterialsController::class, 'store'])->name('admin.studymaterials.store');// Store class
// New Routes for Edit & Delete
Route::get('/admin/studymaterials/edit/{id}', [StudyMaterialsController::class, 'edit'])->name('admin.studymaterials.edit');
Route::post('/admin/studymaterials/update/{id}', [StudyMaterialsController::class, 'update'])->name('admin.studymaterials.update');
Route::delete('/admin/studymaterials/destroy/{id}', [StudyMaterialsController::class, 'destroy'])->name('admin.studymaterials.destroy');

// Exam-Form Management Routes
Route::get('/admin/examform', [ExamFormController::class, 'index'])->name('admin.examform');// View all classes
Route::get('/admin/examform/create', [ExamFormController::class, 'create'])->name('admin.examform.create');// Add class form
Route::post('/admin/examform/store', [ExamFormController::class, 'store'])->name('admin.examform.store');// Store class
// New Routes for Edit & Delete
Route::get('/admin/examform/edit/{id}', [ExamFormController::class, 'edit'])->name('admin.examform.edit'); // Edit form
Route::post('/admin/examform/update/{id}', [ExamFormController::class, 'update'])->name('admin.examform.update'); // Update action
Route::delete('/admin/examform/destroy/{id}', [ExamFormController::class, 'destroy'])->name('admin.examform.destroy'); // Delete action

// Admit-Card Management Routes
Route::get('/admin/admitcards', [AdmitCardController::class, 'index'])->name('admin.admitcards');// View all classes
Route::get('/admin/admitcards/create', [AdmitCardController::class, 'create'])->name('admin.admitcards.create');// Add class form
Route::post('/admin/admitcards/store', [AdmitCardController::class, 'store'])->name('admin.admitcards.store');// Store class
// New Routes for Edit & Delete
Route::delete('/admin/admitcards/destroy/{id}', [AdmitCardController::class, 'destroy'])->name('admin.admitcards.destroy'); // Delete action
Route::get('/get-sections/{classId}', [App\Http\Controllers\admin\AdmitCardController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('/admin/get-students/{classId}/{sectionId}', [AdmitCardController::class, 'getStudentsByClassSection']);
Route::get('/admin/admitcards/filter', [AdmitCardController::class, 'filterAdmitCards'])->name('admin.admitcards.filter');

// Result Management Routes
Route::get('/admin/results', [ResultController::class, 'index'])->name('admin.results');// View all classes
Route::get('/admin/results/create', [ResultController::class, 'create'])->name('admin.results.create');// Add class form
Route::post('/admin/results/store', [ResultController::class, 'store'])->name('admin.results.store');// Store class
// New Routes for Edit & Delete
Route::get('/admin/results/edit/{id}', [ResultController::class, 'edit'])->name('admin.results.edit'); // Edit form
Route::post('/admin/results/update/{id}', [ResultController::class, 'update'])->name('admin.results.update'); // Update action
Route::delete('/admin/results/destroy/{id}', [ResultController::class, 'destroy'])->name('admin.results.destroy'); // Delete action
Route::get('/get-sections/{classId}', [App\Http\Controllers\admin\ResultController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('/admin/get-students/{classId}/{sectionId}', [ResultController::class, 'getStudentsByClassSection'])->name('admin.get-students');
Route::get('admin/results/filter', [ResultController::class, 'filter'])->name('admin.results.filter');
Route::get('/admin/get-exam-total/{examId}', [ResultController::class, 'getExamTotal']);
Route::get('/admin/get-exams/{classId}', [App\Http\Controllers\admin\ResultController::class, 'getExamsByClass']);
Route::get('/admin/get-subjects/{examId}', [App\Http\Controllers\admin\ResultController::class, 'getSubjectsByExam']);
Route::post('/admin/check-duplicate-result', [ResultController::class, 'checkDuplicateResult'])->name('admin.results.checkDuplicate');

// Events Management Routes
Route::get('/admin/events', [EventController::class, 'index'])->name('admin.events');// View all classes

// Parents Meeting Management Routes
Route::get('/admin/meetings', [ParentMeetingController::class, 'index'])->name('admin.meetings');
Route::post('admin/meetings/store', [ParentMeetingController::class, 'store']);
Route::get('admin/meetings/fetch', [ParentMeetingController::class, 'fetchMeetings']);
Route::post('admin/meetings/update-status/{id}', [ParentMeetingController::class, 'updateStatus']);
Route::get('/admin/dashboard/meetings', [ParentMeetingController::class, 'getUpcomingMeetings']);
Route::get('/get-meetings/{classId}', [ParentMeetingController::class, 'getMeetings']);










// Student profile route
Route::get('student/profile', [StudentProfileController::class, 'index'])->name('student.profile');

// Student Dashboard route
Route::get('/student/dashboard', [DashboardController::class, 'student'])->name('student.dashboard');

// Student courses route
Route::get('student/courses', [StudentCourseController::class, 'index'])->name('student.courses');

// Student subjects route
Route::get('student/subjects', [StudentSubjectController::class, 'index'])->name('student.subjects');
Route::get('/get-sections/{classId}', [App\Http\Controllers\student\StudentSubjectController::class, 'getSectionsByClass']);// Fetch sections dynamically

// Student lessons route
Route::get('/student/lessons/lessons', function () {
    return view('student.lessons.lessons'); 
})->name('student.lessons');

// Student periods route
Route::get('student/periods', [StudentPeriodController::class, 'index'])->name('student.periods');

// Student Time Table Management Routes
Route::get('student/time-table', [StudentTimeController::class, 'index'])->name('student.time-table');// View all time-table

// Student Fee Management Routes
Route::get('student/student-fee', [StudentFeeController::class, 'index'])->name('student.student-fee');

// Attendance Management Routes
Route::get('student/attendance', [StudentAttendanceController::class, 'index'])->name('student.attendance');
Route::get('get-student-attendance/{studentId}', [StudentAttendanceController::class, 'getAttendanceData']);

// Student studymaterials route
Route::get('student/studymaterials', [StudentStudyMaterialsController::class, 'index'])->name('student.studymaterials');

// Student exam schedule route
Route::get('student/examform', [StudentExamFormController::class, 'index'])->name('student.examform');

// Student admit card route
Route::get('student/admitcards', [StudentAdmitCardController::class, 'index'])->name('student.admitcards');

// Student results route
Route::get('student/results', [StudentResultController::class, 'index'])->name('student.results');






// Teacher Dashboard route
Route::get('/teacher/dashboard', [DashboardController::class, 'teacher'])->name('teacher.dashboard');

// Student-Attendance Management Routes
Route::get('teacher/attendance', [TeacherAttendanceController::class, 'index'])->name('teacher.attendance');
Route::get('/get-sections/{classId}', [App\Http\Controllers\teacher\TeacherAttendanceController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('/get-students/{classId}/{sectionId}', [App\Http\Controllers\teacher\TeacherAttendanceController::class, 'getStudentsByClassAndSection']);
Route::get('/get-attendance/{classId}/{sectionId}', [App\Http\Controllers\teacher\TeacherAttendanceController::class, 'getAttendanceData']);
Route::post('/save-attendance', [TeacherAttendanceController::class, 'saveAttendance'])->name('save.attendance');
// Attendance Management Routes
Route::get('teacher/my-attendance', [TeacherMyAttendanceController::class, 'index'])->name('teacher.my_attendance');
Route::get('get-teacher-attendance/{teacherId}', [TeacherMyAttendanceController::class, 'getAttendanceData']);// Route for fetching attendance data

// Teacher courses route
Route::get('teacher/courses', [TeacherCourseController::class, 'index'])->name('teacher.courses');

// Teacher subjects route
Route::get('teacher/subjects', [TeacherSubjectController::class, 'index'])->name('teacher.subjects');
Route::get('/get-sections/{classId}', [App\Http\Controllers\teacher\TeacherSubjectController::class, 'getSectionsByClass']);// Fetch sections dynamically

// Teacher lessons route
Route::get('/teacher/lessons/lessons', function () {
    return view('teacher.lessons.lessons'); 
})->name('teacher.lessons');

// Teacher periods route
Route::get('teacher/periods', [TeacherPeriodController::class, 'index'])->name('teacher.periods');

// Teacher Time Table Management Routes
Route::get('teacher/time-table', [TeacherTimeController::class, 'index'])->name('teacher.time-table');// View all time-table

// Teacher Study-Materials Management Routes
Route::get('/teacher/studymaterials', [TeacherStudyMaterialsController::class, 'index'])->name('teacher.studymaterials');// View all classes
Route::get('/teacher/studymaterials/create', [TeacherStudyMaterialsController::class, 'create'])->name('teacher.studymaterials.create');// Add class form
Route::post('/teacher/studymaterials/store', [TeacherStudyMaterialsController::class, 'store'])->name('teacher.studymaterials.store');// Store class

// Teacher meetings route
Route::get('teacher/meetings', [\App\Http\Controllers\teacher\TeacherMeetingController::class, 'index'])->name('teacher.meetings');
Route::get('/teacher/dashboard/meetings', [TeacherMeetingController::class, 'getMeetingsForTeacher']);
Route::post('teacher/meetings/update-status/{id}', [\App\Http\Controllers\teacher\TeacherMeetingController::class, 'updateStatus'])->name('teacher.meetings.update-status');

// Teacher exam schedule route
Route::get('teacher/examform', [TeacherExamFormController::class, 'index'])->name('teacher.examform');

// Teacher Result Management Routes
Route::get('/teacher/results', [TeacherResultController::class, 'index'])->name('teacher.results');// View all classes
Route::get('/teacher/results/create', [TeacherResultController::class, 'create'])->name('teacher.results.create');// Add class form
Route::post('/teacher/results/store', [TeacherResultController::class, 'store'])->name('teacher.results.store');// Store class
// New Routes for Edit & Delete
Route::get('/teacher/results/edit/{id}', [TeacherResultController::class, 'edit'])->name('teacher.results.edit'); // Edit form
Route::post('/teacher/results/update/{id}', [TeacherResultController::class, 'update'])->name('teacher.results.update'); // Update action
Route::delete('/teacher/results/destroy/{id}', [TeacherResultController::class, 'destroy'])->name('teacher.results.destroy'); // Delete action
Route::get('/get-sections/{classId}', [App\Http\Controllers\teacher\TeacherResultController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('/teacher/get-students/{classId}/{sectionId}', [TeacherResultController::class, 'getStudentsByClassSection'])->name('teacher.get-students');
Route::get('teacher/results/filter', [TeacherResultController::class, 'filter'])->name('teacher.results.filter');
Route::get('/teacher/get-exam-total/{examId}', [TeacherResultController::class, 'getExamTotal']);
Route::get('/teacher/get-exams/{classId}', [App\Http\Controllers\teacher\TeacherResultController::class, 'getExamsByClass']);
Route::get('/teacher/get-subjects/{examId}', [App\Http\Controllers\teacher\TeacherResultController::class, 'getSubjectsByExam']);
Route::post('/teacher/check-duplicate-result', [TeacherResultController::class, 'checkDuplicateResult'])->name('teacher.results.checkDuplicate');




// Parent Dashboard route
Route::get('/parent/dashboard', [DashboardController::class, 'parent'])->name('parent.dashboard');

// Parent profile route
Route::get('parent/profile', [ParentProfileController::class, 'index'])->name('parent.profile');

// Parent courses route
Route::get('parent/courses', [ParentCourseController::class, 'index'])->name('parent.courses');

// Parent subjects route
Route::get('parent/subjects', [ParentSubjectController::class, 'index'])->name('parent.subjects');
Route::get('/get-sections/{classId}', [App\Http\Controllers\parent\ParentSubjectController::class, 'getSectionsByClass']);// Fetch sections dynamically
Route::get('parent/get-subjects/{studentId}', [ParentSubjectController::class, 'getSubjectsByStudent']);

// Parent lessons route
Route::get('/parent/lessons/lessons', function () {
    return view('parent.lessons.lessons'); 
})->name('parent.lessons');

// Parent periods route
Route::get('parent/periods', [ParentPeriodController::class, 'index'])->name('parent.periods');

// Parent Time Table Management Routes
Route::get('parent/time-table', [ParentTimeController::class, 'index'])->name('parent.time-table'); // View timetable
Route::get('/filter-time-table', [ParentTimeController::class, 'filterTimeTable']);

// Parent attendance route
Route::get('parent/attendance', [ParentAttendanceController::class, 'index'])->name('parent.attendance');
Route::get('get-student-attendance/{studentId}', [ParentAttendanceController::class, 'getAttendanceData']);

// Parent studymaterials route
Route::get('/parent/studymaterials', [ParentStudyMaterialsController::class, 'index'])->name('parent.studymaterials');
Route::post('/parent/fetch-studymaterials', [ParentStudyMaterialsController::class, 'fetchStudyMaterials']);

// Parent exam route
Route::get('parent/examform', [ParentExamFormController::class, 'index'])->name('parent.examform');
Route::post('parent/fetch-examform', [ParentExamFormController::class, 'fetchExamForm']);

// Parent admitcards route
Route::get('parent/admitcards', [ParentAdmitCardController::class, 'index'])->name('parent.admitcards');
Route::post('/parent/fetch-admitcards', [ParentAdmitCardController::class, 'fetchAdmitCards']);

// Parent results route
Route::get('parent/results', [ParentResultController::class, 'index'])->name('parent.results');
Route::post('/parent/fetch-results', [ParentResultController::class, 'fetchResults']);

// Parent meetings route
Route::get('parent/meetings', [MeetingController::class, 'index'])->name('parent.meetings');
Route::get('parent/meetings/fetch', [MeetingController::class, 'fetch'])->name('parent.meetings.fetch');
Route::post('parent/meetings/update-status/{id}', [MeetingController::class, 'updateStatus'])->name('parent.meetings.update-status');
Route::post('parent/meetings/reschedule/{id}', [MeetingController::class, 'reschedule'])->name('parent.meetings.reschedule');
Route::get('/parent/dashboard/meetings', [MeetingController::class, 'getMeetingsForParent']);
