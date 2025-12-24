<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;
use App\Traits\HasModulePermissions;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, SoftDeletes, HasModulePermissions;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'language_id',
        'created_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Get all quiz assignments for this user.
     */
    public function quizAssignments()
    {
        return $this->hasMany(QuizAssignment::class, 'user_id');
    }

    /**
     * Get all quiz assignments created by this user (admin).
     */
    public function assignedQuizzes()
    {
        return $this->hasMany(QuizAssignment::class, 'assigned_by');
    }

    /**
     * Get all brands this user belongs to (many-to-many).
     */
    public function brands()
    {
        return $this->belongsToMany(Brand::class, 'brand_user');
    }

    /**
     * Get the primary brand this user belongs to (first brand from brands relationship).
     * Kept for backward compatibility - returns a model instance, not a relationship.
     */
    public function getBrandAttribute()
    {
        return $this->brands()->first();
    }

    /**
     * Get the language assigned to this user.
     */
    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id');
    }

    /**
     * Get the admin who created this user.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if user has any permission for a specific module (by module name).
     *
     * @param string $moduleName The module name (e.g., 'Roles', 'Dashboard', 'Quiz')
     * @return bool
     */
    public function hasModulePermissionByName(string $moduleName): bool
    {
        $module = \App\Models\Module::where('name', $moduleName)->first();
        
        if (!$module) {
            return false;
        }

        $userPermissions = $this->getAllPermissions();
        
        foreach ($userPermissions as $permission) {
            if ($permission->module_id == $module->id) {
                return true;
            }
        }
        
        return false;
    }
}
