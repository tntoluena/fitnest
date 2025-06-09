<?php

namespace Database\Seeders;

use App\Models\Exercise;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExerciseSeeder extends Seeder
{

    public function run(): void
    {
        Exercise::query()->delete();

        $exercises = [
            ['name' => 'Lari (kecepatan sedang)', 'type' => 'Cardio', 'met_value' => 9.8],
            ['name' => 'Bersepeda (statis, kecepatan sedang)', 'type' => 'Cardio', 'met_value' => 7.0],
            ['name' => 'Jumping Jacks', 'type' => 'Cardio', 'met_value' => 8.0],
            ['name' => 'Push-up (standar)', 'type' => 'Strength', 'met_value' => 8.0],
            ['name' => 'Squat (tanpa beban)', 'type' => 'Strength', 'met_value' => 5.0],
            ['name' => 'Plank', 'type' => 'Strength', 'met_value' => 2.5],
            ['name' => 'Yoga (Hatha)', 'type' => 'Flexibility', 'met_value' => 2.5],
            ['name' => 'Jalan Cepat', 'type' => 'Cardio', 'met_value' => 4.3],
        ];

        foreach ($exercises as $exercise) {
            Exercise::create($exercise);
        }
    }
}