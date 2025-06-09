<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->id();
            $table->string('food_name');
            $table->integer('calories');
            $table->decimal('protein', 8, 2)->default(0);
            $table->decimal('fat', 8, 2)->default(0);
            $table->decimal('carbs', 8, 2)->default(0);
            $table->string('serving_size')->default('100g'); 
            $table->timestamps();
        });
    }
};
