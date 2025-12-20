<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Installment;
use App\Models\MobileNumber;
use App\Models\Section;
use App\Models\Stage;
use App\Models\Student;
use App\Models\StudentGrade;
use App\Models\Subject;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $stages = collect();
        foreach (['Primary', 'Middle', 'High'] as $stageName) {
            $stages->push(Stage::firstOrCreate(['name' => $stageName]));
        }

        // Ensure sections are created (idempotent even if seeder is re-run)
        $sections = collect();
        foreach ([
            ['name' => 'Alpha', 'grade_level' => 'first'],
            ['name' => 'Beta', 'grade_level' => 'second'],
            ['name' => 'Gamma', 'grade_level' => 'third'],
        ] as $sectionData) {
            $sections->push(
                Section::firstOrCreate(
                    ['name' => $sectionData['name']],
                    array_merge($sectionData, ['stage_id' => $stages->random()->id])
                )
            );
        }

        $subjects = collect();
        foreach ($sections as $section) {
            $subjects = $subjects->merge(
                Subject::factory()
                    ->count(3)
                    ->state(['section_id' => $section->id])
                    ->create()
            );
        }

        $students = Student::factory()
            ->count(20)
            ->state(fn () => [
                'section_id' => $sections->random()->id,
                'stage_id' => $stages->random()->id,
                'full_price' => fake()->randomFloat(2, 500, 3000),
                'registration_date' => fake()->dateTimeBetween('-1 year', 'now')->format('Y-m-d'),
            ])
            ->create();

        $employees = Employee::factory()
            ->count(8)
            ->create();

        // Link employees to random subjects
        foreach ($employees as $employee) {
            $employee->subjects()->attach(
                $subjects->random(rand(1, 3))->pluck('id')->all()
            );
        }

        // Add grades, installments, and mobile numbers for students
        $subjectsBySection = $subjects->groupBy('section_id');
        foreach ($students as $student) {
            $sectionSubjects = $subjectsBySection[$student->section_id] ?? collect();
            $chosen = $sectionSubjects->isNotEmpty()
                ? $sectionSubjects->random(min(3, $sectionSubjects->count()))
                : collect();

            foreach ($chosen as $subject) {
                StudentGrade::create([
                    'student_id' => $student->id,
                    'subject_id' => $subject->id,
                    'score' => fake()->randomFloat(2, 50, 100),
                ]);
            }

            foreach (range(1, rand(1, 3)) as $_) {
                Installment::create([
                    'student_id' => $student->id,
                    'amount_paid' => fake()->randomFloat(2, 100, 1000),
                    'paid_at' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
                ]);
            }

            foreach (range(1, rand(1, 2)) as $_) {
                $student->mobileNumbers()->create([
                    'phone_number' => fake()->unique()->e164PhoneNumber(),
                ]);
            }
        }

        // Mobile numbers for employees
        foreach ($employees as $employee) {
            foreach (range(1, rand(1, 2)) as $_) {
                $employee->mobileNumbers()->create([
                    'phone_number' => fake()->unique()->e164PhoneNumber(),
                ]);
            }
        }

        User::firstOrCreate([
            'email' => 'test@example.com',
        ], [
            'name' => 'Test User',
            'password' => bcrypt('password'),
        ]);
    }
}
