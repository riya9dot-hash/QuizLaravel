<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Brand extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * Get the user who created this brand.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all users belonging to this brand (many-to-many).
     */
    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }

    /**
     * Get all quizzes belonging to this brand.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class, 'brand_id');
    }

    /**
     * Get all quiz categories belonging to this brand (many-to-many).
     */
    public function quizCategories(): BelongsToMany
    {
        return $this->belongsToMany(QuizCategory::class, 'brand_quiz_category', 'brand_id', 'quiz_category_id');
    }

    /**
     * Get all users belonging to this brand (many-to-many).
     */
    public function brandUsers(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'brand_user');
    }
}
