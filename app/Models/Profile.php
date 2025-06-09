<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Profile extends Model
{
    use HasFactory;

    protected $table = 'profiles';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'age', 
        'gender',
        'height',
        'weight',
        'activity_level',
        'calorie_goal',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
