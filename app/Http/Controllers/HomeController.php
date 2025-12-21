<?php

namespace App\Http\Controllers;

use App\Models\Stage;
use App\Models\Section;
use App\Models\Student;
use Illuminate\Support\Collection;
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

    public function topStudents(Request $request)
    {
        $stageId = $request->query('stage_id');
        $sectionId = $request->query('section_id');

        $stages = Stage::with(['sections' => function ($query) {
                $query->orderBy('name');
            }])
            ->orderBy('name')
            ->get();

        $students = Student::query()
            ->with(['section.stage', 'grades'])
            ->when($stageId, function ($query) use ($stageId) {
                $query->where('stage_id', $stageId);
            })
            ->when($sectionId && $stageId, function ($query) use ($sectionId) {
                $query->where('section_id', $sectionId);
            })
            ->get()
            ->map(function ($student) {
                $scores = $student->grades->pluck('score')->filter(function ($score) {
                    return $score !== null;
                });
                $average = $scores->count() ? round($scores->avg(), 2) : 0;
                $student->average_score = $average;
                $student->grades_count = $scores->count();
                return $student;
            })
            ->sortByDesc('average_score')
            ->values();

        $activeStageId = $stageId ?? ($stages->first()?->id);
        $sections = $activeStageId
            ? ($stages->firstWhere('id', (int) $activeStageId)?->sections ?? collect())
            : collect();

        $sectionOptions = $stages->flatMap(function ($stage) {
            return $stage->sections->map(function ($section) {
                return [
                    'id' => $section->id,
                    'name' => $section->name,
                    'stage_id' => $section->stage_id,
                ];
            });
        });

        return view('top_students', compact('stages', 'students', 'activeStageId', 'sectionId', 'sections', 'sectionOptions'));
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
