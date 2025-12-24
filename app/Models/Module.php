<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Module extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'created_by',
    ];

    /**
     * Get the user who created this module.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Get all permissions for this module.
     */
    public function permissions(): HasMany
    {
        return $this->hasMany(Permission::class, 'module_id');
    }
}
