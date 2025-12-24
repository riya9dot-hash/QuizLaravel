<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAssignment extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'quiz_id',
        'user_id',
        'assigned_by',
        'due_date',
        'status',
        'started_at',
        'completed_at',
    ];

    protected $casts = [
        'due_date' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * Get the category this assignment is for.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class, 'category_id');
    }

    /**
     * Get the quiz this assignment is for.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    /**
     * Get the user this assignment is assigned to.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }

    /**
     * Get the admin who assigned this quiz.
     */
    public function assigner(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'assigned_by');
    }

    /**
     * Check if assignment is for a category (not individual quiz).
     */
    public function isCategoryAssignment(): bool
    {
        return $this->category_id !== null;
    }

    /**
     * Check if assignment is for an individual quiz.
     */
    public function isQuizAssignment(): bool
    {
        return $this->quiz_id !== null;
    }
}
