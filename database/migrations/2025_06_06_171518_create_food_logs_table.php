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
        Schema::create('food_logs', function (Blueprint $table) {
            $table->id();

            // Membuat foreign key ke tabel users.
            // constrained() akan otomatis mengaitkan ke 'id' di tabel 'users'.
            // onDelete('cascade') berarti jika user dihapus, semua log makanannya juga ikut terhapus.
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('food_name');
            $table->unsignedInteger('calories'); // Kalori tidak mungkin minus
            $table->decimal('protein', 8, 2);    // Angka desimal untuk gram, total 8 digit, 2 di belakang koma
            $table->decimal('fat', 8, 2);
            $table->decimal('carbs', 8, 2);

            // Kolom enum untuk pilihan yang sudah pasti
            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);

            $table->date('log_date'); // Menyimpan tanggal saja, tanpa waktu
            $table->timestamps(); // Membuat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('food_logs');
    }
};