<?php

namespace Database\Factories;

use App\Models\Section;
use App\Models\Student;
use Illuminate\Database\Eloquent\Factories\Factory;
class StudentFactory extends Factory
{
    protected $model = Student::class;
    public function definition()
    {

        return [
            'first_name' => fake()->firstName(),
            'last_name'  => fake()->lastName(),
            'gender'     => fake()->randomElement(['male', 'female']),
            'birth_date' => fake()->date('Y-m-d', '2015-01-01'),
            'registration_date' => fake()->dateTimeBetween('-1 years', 'now')->format('Y-m-d'),
            'section_id' => Section::factory(),
            'stage_id' => \App\Models\Stage::factory(),
            'full_price' => fake()->randomFloat(2, 500, 3000),
        ];
    }
}
