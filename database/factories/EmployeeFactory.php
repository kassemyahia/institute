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
            'name'    => \fake()->name(),
            'subject' => \fake()->randomElement([
                'Math', 'Science', 'English', 'History', 'Physics', 'Chemistry'
            ]),
            'number'  => \fake()->phoneNumber(),
            'email'   => \fake()->unique()->safeEmail(),
        ];
    }
}
