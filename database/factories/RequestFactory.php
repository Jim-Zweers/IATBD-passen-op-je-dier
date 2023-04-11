<?php

namespace Database\Factories;

use Carbon\Carbon;
use App\Models\Pet;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Request>
 */
class RequestFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'from' => Carbon::now(),
            'till' => $this->faker->dateTimeThisMonth('+20 days'),
            'hourly_rate' => 10.32,
            'pet_id' => 1,
            'owner_id' => 1,
            'sitter_id' => null,
            'status' => null,
        ];
    }
}
