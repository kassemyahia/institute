<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Section;
use App\Models\Stage;

class StudentController extends Controller
{
    // عرض صفحة جميع الطلاب
    public function index(Request $request)
    {
        $search = $request->query('q');
        $stageId = $request->query('stage_id');
        $sectionId = $request->query('section_id');

        $students = Student::query()
            ->with(['section', 'stage'])
            ->withSum('installments as total_paid', 'amount_paid')
            ->when($search, function ($query) use ($search) {
                $query->where(function ($subQuery) use ($search) {
                    $subQuery->where('first_name', 'ILIKE', "%{$search}%")
                        ->orWhere('last_name', 'ILIKE', "%{$search}%")
                        ->orWhere('gender', 'ILIKE', "%{$search}%");
                });
            })
            ->when($stageId, function ($query) use ($stageId) {
                $query->where('stage_id', $stageId);
            })
            ->when($sectionId && $stageId, function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->orderBy('id', 'desc')
            ->get();

        $stages = Stage::with(['sections' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();
        $sections = Section::orderBy('name')->get();
        $sectionOptions = $sections->map(function ($section) {
            return [
                'id' => $section->id,
                'name' => $section->name,
                'stage_id' => $section->stage_id,
            ];
        });

        return view('student.index', compact('students', 'search', 'stageId', 'sectionId', 'stages', 'sections', 'sectionOptions'));
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


        return redirect()->route('student.index')->with('success', 'Student added successfully ✅');
    }
}
