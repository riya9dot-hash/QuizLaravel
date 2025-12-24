<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Priority extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'point',
        'created_by',
    ];

    /**
     * Get the user who created this priority.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}

