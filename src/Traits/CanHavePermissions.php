<?php

namespace Winponta\Cani\Traits;

use Winponta\Cani\Contracts\Permission;

trait CanHavePermissions {

    use RefreshesPermissionCache;

    /**
     * Grant the given permission to a role or user, persist.
     *
     * @param  $permission
     *
     * @return HasPermissions
     */
    public function attachPermission($permission)
    {
        $this->permissions()->save($this->getStoredPermission($permission));

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Grant the given permission to a role or user, associate it on memory.
     *
     * @param  $permission
     *
     * @return HasPermissions
     */
    public function associatePermission($permission)
    {
        $this->permissions()->associate($this->getStoredPermission($permission));

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * Revoke the given permission.
     *
     * @param $permission
     *
     * @return HasPermissions
     */
    public function detachPermission($permission)
    {
        $this->permissions()->detach($this->getStoredPermission($permission));

        $this->forgetCachedPermissions();

        return $this;
    }

    /**
     * @param $permission
     *
     * @return Permission
     */
    protected function getStoredPermission($permission)
    {
        if (is_string($permission)) {
            return app(config('cani.models.permission'))->findByName($permission);
        }

        return $permission;
    }
}
