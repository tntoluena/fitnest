<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('food_logs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->string('food_name');
            $table->unsignedInteger('calories'); 
            $table->decimal('protein', 8, 2);    
            $table->decimal('fat', 8, 2);
            $table->decimal('carbs', 8, 2);

            $table->enum('meal_type', ['breakfast', 'lunch', 'dinner', 'snack']);

            $table->date('log_date'); 
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('food_logs');
    }
};