<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\HealthProgram>
 */
class HealthProgramFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $programTypes = [
            'Tuberculosis (TB) Program',
            'HIV/AIDS Program',
            'Malaria Prevention',
            'Diabetes Management',
            'Hypertension Control',
            'Maternal Health',
            'Child Immunization',
            'Mental Health Services',
            'Nutrition Program',
            'Cancer Screening'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($programTypes),
            'description' => $this->faker->paragraph,
        ];
    }
}
