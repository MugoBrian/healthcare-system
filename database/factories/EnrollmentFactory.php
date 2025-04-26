<?php

namespace Database\Factories;

use App\Models\Client;
use App\Models\HealthProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
 */
class EnrollmentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'client_id' => Client::factory(),
            'health_program_id' => HealthProgram::factory(),
            'enrollment_date' => $this->faker->date,
            'end_date' => $this->faker->optional(0.3)->date,
            'status' => $this->faker->randomElement(['active', 'completed', 'withdrawn']),
            'notes' => $this->faker->optional(0.7)->sentence,
        ];
    }

    /**
     * Indicate the enrollment is active.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function active()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'active',
                'end_date' => null,
            ];
        });
    }

    /**
     * Indicate the enrollment is completed.
     *
     * @return \Illuminate\Database\Eloquent\Factories\Factory
     */
    public function completed()
    {
        return $this->state(function (array $attributes) {
            return [
                'status' => 'completed',
                'end_date' => $this->faker->dateTimeBetween('-1 year', 'now'),
            ];
        });
    }
}
