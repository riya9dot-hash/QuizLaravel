<?php

namespace App\Traits;

use App\Models\Permission;

trait HasModulePermissions
{
    /**
     * Check if user has permission for a specific module and action.
     * This works dynamically regardless of the permission name.
     * 
     * Example:
     * - hasModulePermission('language', 'create') will check for any permission
     *   with module='language' and action='create' that the user has
     * - Works even if permission name is 'language-create', 'add-language', etc.
     *
     * @param string $module The module name (e.g., 'language', 'quiz', 'brand')
     * @param string $action The action name (e.g., 'create', 'edit', 'delete', 'view', 'index')
     * @return bool
     */
    public function hasModulePermission(string $module, string $action): bool
    {
        // Get all permissions for this user (via roles and direct permissions)
        $userPermissions = $this->getAllPermissions();
        
        // Check if user has any permission with matching module and action
        foreach ($userPermissions as $permission) {
            if ($permission->module === $module && $permission->action === $action) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Check if user has any permission for a specific module.
     *
     * @param string $module The module name
     * @return bool
     */
    public function hasModuleAccess(string $module): bool
    {
        $userPermissions = $this->getAllPermissions();
        
        foreach ($userPermissions as $permission) {
            if ($permission->module === $module) {
                return true;
            }
        }
        
        return false;
    }

    /**
     * Get all permissions for a specific module.
     *
     * @param string $module The module name
     * @return \Illuminate\Support\Collection
     */
    public function getModulePermissions(string $module)
    {
        $userPermissions = $this->getAllPermissions();
        
        return $userPermissions->filter(function ($permission) use ($module) {
            return $permission->module === $module;
        });
    }

    /**
     * Check if user has permission for a specific module and action.
     * Alias for hasModulePermission for backward compatibility.
     *
     * @param string $module The module name
     * @param string $action The action name
     * @return bool
     */
    public function canModule(string $module, string $action): bool
    {
        return $this->hasModulePermission($module, $action);
    }
}

