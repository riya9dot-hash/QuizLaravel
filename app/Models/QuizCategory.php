<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class QuizCategory extends Model
{
    use SoftDeletes;
    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * Get the user who created this category.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Get all quizzes in this category.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'category_id');
    }

    /**
     * Get all assignments for this category.
     */
    public function assignments(): HasMany
    {
        return $this->hasMany(QuizAssignment::class, 'category_id');
    }

    /**
     * Get all brands this category belongs to (many-to-many).
     * Categories can have multiple brands via brand_quiz_category pivot table.
     */
    public function brands(): BelongsToMany
    {
        return $this->belongsToMany(Brand::class, 'brand_quiz_category', 'quiz_category_id', 'brand_id');
    }
}
