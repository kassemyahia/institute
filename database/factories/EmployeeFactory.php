<?php

namespace Database\Factories;

use App\Models\Employee;
use Illuminate\Database\Eloquent\Factories\Factory;

class EmployeeFactory extends Factory
{
    protected $model = Employee::class; // REQUIRED

    public function definition()
    {
        return [
            'name'    => $this->faker->name(),
            'subject' => $this->faker->randomElement([
                'Math', 'Science', 'English', 'History', 'Physics', 'Chemistry'
            ]),
            'number'  => $this->faker->phoneNumber(),
            'email'   => $this->faker->unique()->safeEmail(),
        ];
    }
}
