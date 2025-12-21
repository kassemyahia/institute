<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use Illuminate\Http\Request;

class StudentGradeController extends Controller
{
    public function index()
    {
        $stageId = request('stage_id');
        $sectionId = request('section_id');
        $subjectId = request('subject_id');

        $grades = StudentGrade::with(['student.section.stage', 'subject'])
            ->when($stageId, function ($query) use ($stageId) {
                $query->whereHas('student', function ($q) use ($stageId) {
                    $q->where('stage_id', $stageId);
                });
            })
            ->when($sectionId, function ($query) use ($sectionId) {
                $query->whereHas('student', function ($q) use ($sectionId) {
                    $q->where('section_id', $sectionId);
                });
            })
            ->when($subjectId, function ($query) use ($subjectId) {
                $query->where('subject_id', $subjectId);
            })
            ->get();

        $stages = \App\Models\Stage::with('sections')->orderBy('name')->get();
        $sections = $stageId
            ? $stages->firstWhere('id', (int) $stageId)?->sections ?? collect()
            : \App\Models\Section::orderBy('name')->get();
        $subjects = \App\Models\Subject::orderBy('name')->get();
        $subjectOptions = \App\Models\Subject::select('id', 'name', 'section_id')->orderBy('name')->get();
        $sectionOptions = $stages->flatMap(function ($stage) {
            return $stage->sections->map(function ($section) {
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                    'stage_id' => $section->stage_id,
                ];
            });
        });

        return view('student_grade.index', compact('grades', 'stages', 'sections', 'subjects', 'subjectOptions', 'stageId', 'sectionId', 'subjectId', 'sectionOptions'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();
        $selectedStudent = request('student_id');
        $selectedSubject = request('subject_id');

        return view('student_grade.create', compact('students', 'subjects', 'selectedStudent', 'selectedSubject'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        StudentGrade::updateOrCreate(
            [
                'student_id' => $validated['student_id'],
                'subject_id' => $validated['subject_id'],
            ],
            ['score' => $validated['score']]
        );

        return redirect()->route('student_grade.index')->with('success', 'Grade recorded successfully ✅');
    }
}
