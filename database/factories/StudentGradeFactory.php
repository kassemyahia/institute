<?php

namespace Database\Factories;

use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

class StudentGradeFactory extends Factory
{
    protected $model = StudentGrade::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'subject_id' => Subject::factory(),
            'score' => fake()->randomFloat(2, 50, 100),
        ];
    }
}
