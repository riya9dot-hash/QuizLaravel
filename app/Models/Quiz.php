<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'category_id',
        'brand_id',
        'question',
        'answer',
        'priority_id',
        'created_by',
    ];


    /**
     * Get the user who created this quiz.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Get the category this quiz belongs to.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(QuizCategory::class, 'category_id');
    }

    /**
     * Get all attempts for this quiz.
     */
    public function attempts(): HasMany
    {
        return $this->hasMany(QuizAttempt::class);
    }

    /**
     * Get all assignments for this quiz.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(QuizAssignment::class, 'quiz_id');
    }

    /**
     * Get the brand this quiz belongs to.
     */
    public function brand(): BelongsTo
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    /**
     * Get the priority this quiz belongs to.
     */
    public function priority(): BelongsTo
    {
        return $this->belongsTo(Priority::class, 'priority_id');
    }
}
