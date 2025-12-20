<?php

namespace App\Http\Controllers;

use App\Models\Section;
use Illuminate\Http\Request;

class SectionController extends Controller
{
    public function index()
    {
        $sections = Section::all();

        return view('section.index', compact('sections'));
    }

    public function create()
    {
        return view('section.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:sections,name',
            'grade_level' => 'nullable|in:first,second,third',
        ]);

        Section::create($validated);

        return redirect()->route('section.index')->with('success', 'تمت إضافة الشعبة بنجاح ✅');
    }
}
