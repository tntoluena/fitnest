<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Food; 

class FoodSeeder extends Seeder
{
    public function run(): void
    {

        Food::truncate();

        $foods = [
            ['food_name' => 'Nasi Putih', 'calories' => 130, 'carbs' => 28, 'protein' => 2.7, 'fat' => 0.3, 'serving_size' => '100g', 'meal_type' => 'breakfast,lunch,dinner'],
            ['food_name' => 'Dada Ayam Bakar', 'calories' => 165, 'carbs' => 0, 'protein' => 31, 'fat' => 3.6, 'serving_size' => '100g', 'meal_type' => 'lunch,dinner'],
            ['food_name' => 'Telur Rebus', 'calories' => 78, 'carbs' => 0.6, 'protein' => 6, 'fat' => 5, 'serving_size' => '1 butir (50g)', 'meal_type' => 'breakfast,snack'],
            ['food_name' => 'Tahu Goreng', 'calories' => 110, 'carbs' => 2.5, 'protein' => 10, 'fat' => 7, 'serving_size' => '100g', 'meal_type' => 'lunch,dinner,snack'],
            ['food_name' => 'Tempe Goreng', 'calories' => 192, 'carbs' => 9, 'protein' => 19, 'fat' => 11, 'serving_size' => '100g', 'meal_type' => 'lunch,dinner,snack'],
            ['food_name' => 'Sate Ayam', 'calories' => 350, 'carbs' => 10, 'protein' => 25, 'fat' => 20, 'serving_size' => '5 tusuk', 'meal_type' => 'lunch,dinner'],
            ['food_name' => 'Gado-Gado', 'calories' => 300, 'carbs' => 25, 'protein' => 15, 'fat' => 18, 'serving_size' => '1 porsi', 'meal_type' => 'lunch'],
            ['food_name' => 'Apel', 'calories' => 52, 'carbs' => 14, 'protein' => 0.3, 'fat' => 0.2, 'serving_size' => '1 buah (100g)', 'meal_type' => 'snack'],
            ['food_name' => 'Pisang', 'calories' => 89, 'carbs' => 23, 'protein' => 1.1, 'fat' => 0.3, 'serving_size' => '1 buah (100g)', 'meal_type' => 'breakfast,snack'],
            ['food_name' => 'Ikan Kembung Bakar', 'calories' => 180, 'carbs' => 0, 'protein' => 22, 'fat' => 10, 'serving_size' => '100g', 'meal_type' => 'lunch,dinner'],
        ];

        foreach ($foods as $food) {
            Food::create($food);
        }
    }
}