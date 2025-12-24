<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizAttempt extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'user_id',
        'session_id',
        'quiz_id',
        'user_answer',
        'is_correct',
    ];

    protected $casts = [
        'is_correct' => 'boolean',
    ];

    /**
     * Get the user who attempted the quiz.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class);
    }

    /**
     * Get the quiz that was attempted.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Get the quiz session this attempt belongs to.
     */
    public function session(): BelongsTo
    {
        return $this->belongsTo(QuizSession::class, 'session_id');
    }
}
