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
        $grades = StudentGrade::with(['student', 'subject'])->get();

        return view('student_grade.index', compact('grades'));
    }

    public function create()
    {
        $students = Student::all();
        $subjects = Subject::all();

        return view('student_grade.create', compact('students', 'subjects'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'subject_id' => 'required|exists:subjects,id',
            'score' => 'nullable|numeric|min:0|max:100',
        ]);

        StudentGrade::create($validated);

        return redirect()->route('student_grade.index')->with('success', 'Grade recorded successfully ✅');
    }
}
