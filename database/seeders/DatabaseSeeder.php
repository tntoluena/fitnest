<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Membuat user default yang sudah ada sebelumnya
        User::factory()->create([
            'name' => 'User Tester Dua',
            'email' => 'testerdua@example.com',
        ]);

        // Memanggil seeder untuk mengisi tabel makanan dan tabel latihan
        $this->call([
            FoodSeeder::class,
            ExerciseSeeder::class, // <-- Cukup tambahkan baris ini
        ]);
    }
}