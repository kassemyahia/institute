<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;

class StudentController extends Controller
{
    // عرض صفحة جميع المدرسين
    public function index()
    {
        $students = Student::all();
        return view('student.index', compact('students'));
    }

    // عرض صفحة إضافة مدرس جديد
    public function create()
    {
        return view('student.create');
    }

    // حفظ المدرس الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'gender' => 'required|in:male,female',
            'birth_date' => 'required|date',
        ]);


        Student::create($request->all());


        return redirect()->route('student.index')->with('success', 'تمت إضافة الطالب بنجاح ✅');
    }
}
