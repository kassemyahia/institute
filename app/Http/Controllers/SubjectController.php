<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('section')->get();

        return view('subject.index', compact('subjects'));
    }

    public function create()
    {
        $sections = Section::all();

        return view('subject.create', compact('sections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'section_id' => 'required|exists:sections,id',
        ]);

        Subject::create($validated);

        return redirect()->route('subject.index')->with('success', 'تمت إضافة المادة بنجاح ✅');
    }
}
