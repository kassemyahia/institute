<?php

namespace Database\Factories;

use App\Models\MobileNumber;
use Illuminate\Database\Eloquent\Factories\Factory;

class MobileNumberFactory extends Factory
{
    protected $model = MobileNumber::class;

    public function definition(): array
    {
        return [
            // Ensure max length 20 per migration
            'phone_number' => fake()->unique()->numerify('+###########'),
        ];
    }
}
