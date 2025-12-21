<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Section;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        return view('home');
    }

    public function classrooms()
    {
        [$stages, $classroomData, $defaultStageId, $defaultSectionId] = $this->buildClassroomData();

        return view('classrooms', compact('stages', 'classroomData', 'defaultStageId', 'defaultSectionId'));
    }

    public function storeStage(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:100|unique:stages,name',
        ]);

        Stage::create($validated);

        return redirect()->route('classrooms.index')->with('success', 'Stage created successfully ✅');
    }

    public function storeSection(Request $request)
    {
        $validated = $request->validate([
            'stage_id' => 'required|exists:stages,id',
            'name' => 'required|string|max:100',
        ]);

        Section::create($validated);

        return redirect()->route('classrooms.index')->with('success', 'Section created successfully ✅');
    }

    private function buildClassroomData()
    {
        $stages = Stage::with(['sections.students' => function ($query) {
                $query->orderBy('last_name')->orderBy('first_name');
            }])
            ->orderBy('name')
            ->get();

        $classroomData = $stages->map(function ($stage) {
            return [
                'id' => $stage->id,
                'name' => $stage->name,
                'sections' => $stage->sections->map(function ($section) {
                    return [
                        'id' => $section->id,
                        'name' => $section->name,
                        'students' => $section->students->map(function ($student) {
                            return [
                                'id' => $student->id,
                                'first_name' => $student->first_name,
                                'last_name' => $student->last_name,
                                'gender' => $student->gender,
                            ];
                        })->values(),
                    ];
                })->values(),
            ];
        })->values();

        $defaultStageId = $stages->first()?->id;
        $defaultSectionId = $stages->first()?->sections->first()?->id;

        return [$stages, $classroomData, $defaultStageId, $defaultSectionId];
    }
}
