<?php

namespace Database\Factories;

use App\Models\Installment;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;

class InstallmentFactory extends Factory
{
    protected $model = Installment::class;

    public function definition(): array
    {
        return [
            'student_id' => Student::factory(),
            'amount_paid' => fake()->randomFloat(2, 100, 1000),
            'paid_at' => fake()->dateTimeBetween('-6 months', 'now')->format('Y-m-d'),
        ];
    }
}
