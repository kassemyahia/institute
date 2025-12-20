<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;

class EmployeeController extends Controller
{
    // عرض صفحة جميع الموظفين
    public function index(Request $request)
    {
        $search = $request->query('q');

        $employees = Employee::query()
            ->when($search, function ($query) use ($search) {
                $query->where('first_name', 'ILIKE', "%{$search}%")
                    ->orWhere('last_name', 'ILIKE', "%{$search}%")
                    ->orWhere('job_title', 'ILIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('employee.index', compact('employees', 'search'));
    }

    public function show(Employee $employee)
    {
        $employee->load('mobileNumbers', 'subjects');

        return view('employee.show', compact('employee'));
    }

    public function edit(Employee $employee)
    {
        return view('employee.edit', compact('employee'));
    }

    public function update(Request $request, Employee $employee)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:150',
            'salary' => 'nullable|integer|min:0',
            'birth_date' => 'nullable|date',
        ]);

        $employee->update($validated);

        return redirect()->route('employee.show', $employee)->with('success', 'Employee updated successfully');
    }

    // عرض صفحة إضافة موظف جديد
    public function create()
    {
        return view('employee.create');
    }

    // حفظ الموظف الجديد في قاعدة البيانات
    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:100',
            'last_name' => 'required|string|max:100',
            'job_title' => 'nullable|string|max:150',
            'salary' => 'nullable|integer|min:0',
            'birth_date' => 'nullable|date',
        ]);

        Employee::create($validated);

        return redirect()->route('employee.index')->with('success', 'تمت إضافة الموظف بنجاح ✅');
    }
}
