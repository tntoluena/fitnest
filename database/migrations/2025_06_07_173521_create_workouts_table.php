<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('workouts', function (Blueprint $table) {
            $table->id();

            // Foreign key ke tabel users, sama seperti di food_logs
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('activity_name'); // e.g., "Lari Pagi"
            $table->unsignedInteger('duration_minutes'); // Durasi dalam menit
            $table->unsignedInteger('calories_burned'); // Kalori tidak mungkin minus
            
            // Kolom ini fleksibel, bisa diisi "Cardio", "Strength Training", dll.
            $table->string('activity_type')->nullable(); 

            // Menggunakan tipe data date, konsisten dengan food_logs
            $table->date('log_date'); 
            
            $table->timestamps(); // Kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workouts');
    }
};