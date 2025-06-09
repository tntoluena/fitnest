<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FoodLog extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * Ini adalah daftar kolom yang boleh diisi saat membuat atau mengupdate data.
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'food_name',
        'calories',
        'protein',
        'fat',
        'carbs',
        'meal_type',
        'log_date',
    ];

    /**
     * The attributes that should be cast.
     * Ini untuk memastikan tipe data selalu konsisten saat diambil dari database.
     * @var array<string, string>
     */
    protected $casts = [
        'log_date' => 'date',         
        'calories' => 'integer',
        'protein' => 'decimal:2',   
        'fat' => 'decimal:2',
        'carbs' => 'decimal:2',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}