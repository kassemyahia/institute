<?php

namespace App\Http\Controllers;

use App\Models\Section;
use App\Models\Subject;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    public function index()
    {
        $subjects = Subject::with('section.stage')->orderBy('name')->get();
        $sections = Section::with('stage')->orderBy('name')->get();

        return view('subject.index', compact('subjects', 'sections'));
    }

    public function create()
    {
        return redirect()->route('subject.index');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'section_id' => 'required|exists:sections,id',
        ]);

        Subject::create($validated);

        return redirect()->route('subject.index')->with('success', 'Subject added successfully ✅');
    }

    public function destroy(Subject $subject)
    {
        // Clean up related pivot records before deleting the subject
        $subject->students()->detach();
        $subject->employees()->detach();
        $subject->grades()->delete();

        $subject->delete();

        return redirect()->route('subject.index')->with('success', 'Subject deleted successfully ❌');
    }
}
