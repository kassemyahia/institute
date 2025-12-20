<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\MobileNumber;
use App\Models\Student;
use Illuminate\Http\Request;

class MobileNumberController extends Controller
{
    public function index()
    {
        $mobileNumbers = MobileNumber::with('owner')->get();

        return view('mobile_number.index', compact('mobileNumbers'));
    }

    public function create()
    {
        $students = Student::all();
        $employees = Employee::all();

        return view('mobile_number.create', compact('students', 'employees'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'owner_type' => 'required|in:' . addslashes(Student::class) . ',' . addslashes(Employee::class),
            'owner_id' => 'required|integer',
            'phone_number' => 'required|string|max:20',
        ]);

        // Ensure referenced owner exists
        if ($validated['owner_type'] === Student::class && !Student::whereKey($validated['owner_id'])->exists()) {
            return back()->withErrors(['owner_id' => 'الطالب غير موجود'])->withInput();
        }
        if ($validated['owner_type'] === Employee::class && !Employee::whereKey($validated['owner_id'])->exists()) {
            return back()->withErrors(['owner_id' => 'الموظف غير موجود'])->withInput();
        }

        MobileNumber::create($validated);

        return redirect()->route('mobile_number.index')->with('success', 'تم إضافة الرقم بنجاح ✅');
    }
}
