<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;

class StudentController extends Controller
{
    // عرض صفحة جميع الطلاب
    public function index(Request $request)
    {
        $search = $request->query('q');

        $students = Student::query()
            ->with(['section', 'stage'])
            ->withSum('installments as total_paid', 'amount_paid')
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'ILIKE', "%{$search}%")
                    ->orWhere('last_name', 'ILIKE', "%{$search}%")
                    ->orWhere('gender', 'ILIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('student.index', compact('students', 'search'));
    }

    public function show(Student $student)
    {
        $student->load('section', 'stage', 'mobileNumbers', 'grades.subject', 'installments');
        $totalPaid = $student->installments->sum('amount_paid');
        $amountLeft = max(0, ($student->full_price ?? 0) - $totalPaid);

        return view('student.show', compact('student', 'totalPaid', 'amountLeft'));
    }

    public function edit(Student $student)
    {
        $sections = Section::with('stage')->get();
        $stages = \App\Models\Stage::all();

        return view('student.edit', compact('student', 'sections', 'stages'));
    }

    public function update(Request $request, Student $student)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date',
            'registration_date' => 'nullable|date',
            'section_id' => 'required|exists:sections,id',
            'stage_id' => 'nullable|exists:stages,id',
            'full_price' => 'nullable|numeric|min:0',
            'is_fully_paid' => 'sometimes|boolean',
        ]);

        $validated['registration_date'] = $validated['registration_date'] ?? now()->toDateString();

        $student->update($validated);

        return redirect()->route('student.show', $student)->with('success', 'Student updated successfully');
    }

    // عرض صفحة إضافة طالب جديد
    public function create()
    {
        $sections = Section::with('stage')->get();
        $stages = \App\Models\Stage::all();

        return view('student.create', compact('sections', 'stages'));
    }

    // حفظ الطالب الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'gender' => 'nullable|string|max:10',
            'birth_date' => 'nullable|date',
            'section_id' => 'required|exists:sections,id',
            'stage_id' => 'nullable|exists:stages,id',
            'full_price' => 'nullable|numeric|min:0',
            'is_fully_paid' => 'sometimes|boolean',
            'registration_date' => 'nullable|date',
        ]);

        $validated['registration_date'] = $validated['registration_date'] ?? now()->toDateString();

        Student::create($validated);


        return redirect()->route('student.index')->with('success', 'تمت إضافة الطالب بنجاح ✅');
    }
}
