<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class QuizSession extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'category_id',
        'category_name',
        'total_questions',
        'correct_answers',
        'wrong_answers',
        'score',
        'completed',
    ];

    protected $casts = [
        'completed' => 'boolean',
        'score' => 'decimal:2',
    ];

    /**
     * Get the user who took this quiz session.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the category for this quiz session.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class);
    }

    /**
     * Get all attempts for this quiz session.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class, 'session_id');
    }
}
