<?php

namespace App\Http\Controllers\admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller; // Import the base Controller class
use App\Models\admin\Account; // Updated reference to the model's namespace
use App\Models\admin\Student;
use App\Models\admin\Counseller;
use App\Models\admin\Teacher;
use App\Models\admin\SParent;
use App\Models\admin\Librarian;
use App\Models\admin\ClassModel; 
use App\Models\admin\Section;

class UserAccountController extends Controller
{
    public function index(Request $request, $user)
    {
        $validUsers = ['counseller', 'teacher', 'student', 'parent', 'librarian'];

        if (!in_array($user, $validUsers)) {
            abort(404);
        }

        $accounts = Account::where('type', $user)->get();

        if ($user === 'parent') {
            foreach ($accounts as $account) {
                // Find students whose parent details match this parent's email or mobile
                $students = Student::where('father_email', $account->email)
                    ->orWhere('mother_email', $account->email)
                    ->orWhere('father_mobile', $account->name)
                    ->orWhere('mother_mobile', $account->name)
                    ->pluck('name')
                    ->toArray();

                $account->students = implode(', ', $students); // Store student names as a comma-separated string
            }
        }

        return view('admin.users.user-account', [
            'accounts' => $accounts,
            'user' => $user,
            'message' => $accounts->isEmpty() ? "No accounts found for {$user}" : null,
        ]);
    }

    public function create($user)
    {
        $classes = ClassModel::all();
        // Return view to create new account
        return view('admin.users.create', compact('user', 'classes'));
    }

    public function store(Request $request)
    {
        // Default validation rules for name and email (applicable to all types)
        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:accounts,email',
        ];

        // Additional validation rules for student and other user types (but NOT for counseller)
        // if ($request->type !== 'counseller'  && $request->type !== 'teacher' && $request->type !== 'parent' && $request->type !== 'librarian') {
        if ($request->type === 'student') {
            $validationRules = array_merge($validationRules, [
                'dob' => 'required|date',
                'mobile' => 'required|digits:10',
                'address' => 'nullable|string|max:255',
                'country' => 'nullable|string|max:100',
                'state' => 'nullable|string|max:100',
                'zip' => 'nullable|string|max:10',

                'father_name' => 'nullable|string|max:255',
                'father_mobile' => 'required|digits:10',
                'father_email' => 'nullable|email',
                'mother_name' => 'nullable|string|max:255',
                'mother_mobile' => 'required|digits:10',
                'mother_email' => 'nullable|email',
                'parents_address' => 'nullable|string|max:255',
                'parents_country' => 'nullable|string|max:100',
                'parents_state' => 'nullable|string|max:100',
                'parents_zip' => 'nullable|string|max:10',

                'school_name' => 'nullable|string|max:255',
                'previous_class' => 'nullable|string|max:255',
                'status' => 'nullable|string|max:255',
                'total_marks' => 'nullable|string|max:5',
                'obtain_marks' => 'nullable|string|max:5',
                'previous_percentage' => 'nullable|string|max:5',

                'classes' => 'nullable|string|max:255',
                'sections' => 'nullable|string|max:255',
                'stream' => 'nullable|string|max:255',
                'doa' => 'required|date',
            ]);
            // Require receipt_number and registration_fee only if payment method is Offline
            if ($request->payment_method === 'Offline') {
                $validationRules['receipt_number'] = 'required|string|max:50';
                $validationRules['registration_fee'] = 'required|string|min:0';
            }
        }

        // Perform the validation based on the type
        $request->validate($validationRules);

        // Check if the user already exists by email or name
        $existingUser = Account::where('email', $request->email)
            ->orWhere('name', $request->name)
            ->first();

        if ($existingUser) {
            $message = $existingUser->email === $request->email
                ? 'A user with this email already exists.'
                : 'A user with this name already exists.';

            return response()->json([
                'success' => false,
                'message' => $message,
            ], 422);
        }

        // Generate a random secure password
        $randomPassword = Str::random(12);
        $hashedPassword = Hash::make($randomPassword);

        // Create the account
        $account = Account::create([
            'type' => $request->type,  // 'counseller', 'teacher' 
            'name' => $request->name,
            'email' => $request->email,
            'password' => $hashedPassword,
        ]);

        // Additional logic for student data (if type is student)
        if ($request->type === 'student') {
            Student::create([
                'id' => $account->id,
                'name' => $account->name,
                'dob' => $request->dob,
                'mobile' => $request->mobile,
                'email' => $account->email,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'zip' => $request->zip,

                'father_name' => $request->father_name,
                'father_mobile' => $request->father_mobile,
                'father_email' => $request->father_email,
                'mother_name' => $request->mother_name,
                'mother_mobile' => $request->mother_mobile,
                'mother_email' => $request->mother_email,
                'parents_address' => $request->parents_address,
                'parents_country' => $request->parents_country,
                'parents_state' => $request->parents_state,
                'parents_zip' => $request->parents_zip,

                'school_name' => $request->school_name,
                'previous_class' => $request->previous_class,
                'status' => $request->status,
                'total_marks' => $request->total_marks,
                'obtain_marks' => $request->obtain_marks,
                'previous_percentage' => $request->previous_percentage,

                'classes' => $request->classes,
                'sections' => $request->sections,
                'stream' => $request->stream,
                'doa' => $request->doa,

                'payment_method' => $request->payment_method, // Store value
                'receipt_number' => $request->payment_method === 'Offline' ? $request->receipt_number : null,
                'registration_fee' => $request->payment_method === 'Offline' ? $request->registration_fee : null,
            ]);

            if ($request->father_email) {
                $existingFather = Account::where('email', $request->father_email)->first();
                if (!$existingFather) {
                    Account::create([
                        'type' => 'parent',
                        'name' => $request->father_name,
                        'email' => $request->father_email,
                        'password' => Hash::make(Str::random(12)),
                    ]);
                }
            }
            
            if ($request->mother_email) {
                $existingMother = Account::where('email', $request->mother_email)->first();
                if (!$existingMother) {
                    Account::create([
                        'type' => 'parent',
                        'name' => $request->mother_name,
                        'email' => $request->mother_email,
                        'password' => Hash::make(Str::random(12)),
                    ]);
                }
            }
        }

        // For Counseller, Teacher no additional table needed, just create the account

        return response()->json([
            'success' => true,
            'message' => 'Account created successfully.',
            'user' => $account,
        ]);
    }

    public function getSectionsByClass($classId)
    {
        $class = ClassModel::find($classId);

        if (!$class) {
            return response()->json([]); // Class not found, return empty
        }

        $sectionIds = explode(',', $class->sections); // Ensure 'sections' column is comma-separated IDs

        $sections = Section::whereIn('id', $sectionIds)->pluck('title', 'id'); // Fetch matching sections

        return response()->json($sections);
    }  

    public function edit($id)
    {
        $account = Account::findOrFail($id);
        $classes = ClassModel::all();
        $student = null;
        $sections = collect(); // Default empty collection

        if ($account->type === 'student') {
            $student = Student::where('id', $account->id)->first();

            if ($student && $student->classes) {
                $class = ClassModel::find($student->classes);
                if ($class) {
                    $sectionIds = explode(',', $class->sections);
                    $sections = Section::whereIn('id', $sectionIds)->get();
                }
            }
        }

        return view('admin.users.edit', compact('account', 'student', 'classes', 'sections'));
    }

    public function update(Request $request, $id)
    {
        $account = Account::findOrFail($id);
        $userType = $account->type;

        // Update account details
        $account->update([
            'name' => $request->name,
            'email' => $request->email,
        ]);
        // Update student details if the user is a student
        if ($userType === 'student') {
            Student::where('id', $account->id)->update([
                'dob' => $request->dob,
                'mobile' => $request->mobile,
                'address' => $request->address,
                'country' => $request->country,
                'state' => $request->state,
                'zip' => $request->zip,

                'father_name' => $request->father_name,
                'father_mobile' => $request->father_mobile,
                'father_email' => $request->father_email,
                'mother_name' => $request->mother_name,
                'mother_mobile' => $request->mother_mobile,
                'mother_email' => $request->mother_email,
                'parents_address' => $request->parents_address,
                'parents_country' => $request->parents_country,
                'parents_state' => $request->parents_state,
                'parents_zip' => $request->parents_zip,

                'school_name' => $request->school_name,
                'previous_class' => $request->previous_class,
                'status' => $request->status,
                'total_marks' => $request->total_marks,
                'obtain_marks' => $request->obtain_marks,
                'previous_percentage' => $request->previous_percentage,

                'classes' => $request->classes,
                'sections' => $request->sections,
                'stream' => $request->stream,
                'doa' => $request->doa,

            ]);
        }

        return redirect()->route('user.account', ['user' => $userType])
            ->with('success', 'User updated successfully!');
    }

    public function destroy($id)
    {
        $account = Account::findOrFail($id);
        $account->delete();

        return redirect()->route('user.account', ['user' => $account->type])->with('success', 'User deleted successfully!');
    }
}




