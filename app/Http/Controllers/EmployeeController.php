<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // عرض صفحة جميع المدرسين
    public function index()
    {
        $employees = Employee::all();
        return view('employee.index', compact('employees'));
    }

    // عرض صفحة إضافة مدرس جديد
    public function create()
    {
        return view('employee.create');
    }

    // حفظ المدرس الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        // التحقق من صحة البيانات
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'required|string|max:255',
            'number' => 'required|string|max:20',
            'email' => 'required|email|max:255',
        ]);

        // إنشاء المدرس
        Employee::create($request->all());

        // إعادة التوجيه مع رسالة نجاح
        return redirect()->route('employee.index')->with('success', 'تمت إضافة المدرس بنجاح ✅');
    }
}
