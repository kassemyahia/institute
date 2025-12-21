<?php

namespace App\Http\Controllers;

use App\Models\Installment;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class InstallmentController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->query('q');

        $installments = Installment::with('student')
            ->when($search, function ($query) use ($search) {
                $query->whereHas('student', function ($q) use ($search) {
                    $q->where('first_name', 'ILIKE', "%{$search}%")
                        ->orWhere('last_name', 'ILIKE', "%{$search}%");
                })->orWhere('paid_at', 'ILIKE', "%{$search}%");
            })
            ->orderBy('id', 'desc')
            ->get();

        return view('installment.index', compact('installments', 'search'));
    }

    public function create()
    {
        $students = Student::all();

        return view('installment.create', compact('students'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'amount_paid' => 'required|numeric|min:0',
            'paid_at' => 'nullable|date',
        ]);

        $validated['paid_at'] = $validated['paid_at'] ?? Carbon::now()->toDateString();

        Installment::create($validated);

        return redirect()->route('installment.index')->with('success', 'Installment added successfully ✅');
    }
}
