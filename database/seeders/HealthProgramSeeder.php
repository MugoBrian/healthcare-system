<?php

namespace Database\Seeders;

use App\Models\HealthProgram;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HealthProgramSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $programs = [
            [
                'name' => 'Tuberculosis (TB) Program',
                'description' => 'Comprehensive program for TB diagnosis, treatment, and prevention.',
            ],
            [
                'name' => 'HIV/AIDS Program',
                'description' => 'Treatment and support services for HIV positive patients.',
            ],
            [
                'name' => 'Malaria Prevention and Treatment',
                'description' => 'Services focused on malaria prevention, diagnosis, and treatment.',
            ],
            [
                'name' => 'Maternal and Child Health',
                'description' => 'Prenatal care, delivery services, and pediatric care for mothers and children.',
            ],
            [
                'name' => 'Diabetes Management',
                'description' => 'Monitoring and treatment services for diabetes patients.',
            ],
        ];

        foreach ($programs as $program) {
            HealthProgram::create($program);
        }
    }
}
