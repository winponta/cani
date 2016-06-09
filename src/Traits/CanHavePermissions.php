<?php

namespace Winponta\Cani\Traits;

use Winponta\Cani\Contracts\Permission;

trait CanHavePermissions
{
    /**
     * Grant the given permission to a role or user.
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
     * Revoke the given permission.
     *
     * @param $permission
     *
     * @return HasPermissions
     */
    public function dettachPermission($permission)
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
            return app(Permission::class)->findByName($permission);
        }

        return $permission;
    }
}
