<?php

namespace Winponta\Cani\Traits;

use Winponta\Cani\Contracts\Permission;
use Winponta\Cani\Contracts\Role;

trait CanHaveRoles
{
    use CanHavePermissions;
    use RefreshesPermissionCache;

    /**
     * A user may have multiple roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles()
    {
        return $this->embedsMany(
            config('cani.models.role')
        );
    }

    /**
     * A user may have multiple direct permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions()
    {
        return $this->embedsMany(
            config('cani.models.permission')
        );
    }

    /**
     * Assign the given role to the user.
     *
     * @param string|Role $role
     *
     * @return Role
     */
    public function attachRole($role)
    {
        $this->roles()->save($this->getStoredRole($role));
    }

    /**
     * Revoke the given role from the user.
     *
     * @param string|Role $role
     *
     * @return mixed
     */
    public function detachRole($role)
    {
        $this->roles()->detach($this->getStoredRole($role));
    }

    /**
     * Determine if the user has (one of) the given role(s).
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasRole($roles)
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }

        if (is_array($roles)) {
            foreach ($roles as $role) {
                if ($this->hasRole($role)) {
                    return true;
                }
            }

            return false;
        }

        return (bool) $roles->intersect($this->roles)->count();
    }

    /**
     * Determine if the user has any of the given role(s).
     *
     * @param string|array|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        return $this->hasRole($roles);
    }

    /**
     * Determine if the user has all of the given role(s).
     *
     * @param string|Role|\Illuminate\Support\Collection $roles
     *
     * @return bool
     */
    public function hasAllRoles($roles)
    {
        if (is_string($roles)) {
            return $this->roles->contains('name', $roles);
        }

        if ($roles instanceof Role) {
            return $this->roles->contains('id', $roles->id);
        }

        $roles = collect()->make($roles)->map(function ($role) {
            return $role instanceof Role ? $role->name : $role;
        });

        return $roles->intersect($this->roles->lists('name')) == $roles;
    }

    /**
     * Determine if the user may perform the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     */
    public function hasPermissionTo($permission)
    {
        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission);
        }

        return $this->hasDirectPermission($permission) || $this->hasPermissionViaRole($permission);
    }

    /**
     * @deprecated deprecated since version 1.0.1, use hasPermissionTo instead
     *
     * Determine if the user may perform the given permission.
     *
     * @param Permission $permission
     *
     * @return bool
     */
    public function hasPermission($permission)
    {
        return $this->hasPermissionTo($permission);
    }

    /**
     * Determine if the user has, via roles, the given permission.
     *
     * @param Permission $permission
     *
     * @return bool
     */
    protected function hasPermissionViaRole(Permission $permission)
    {
        return $this->hasRole($permission->roles);
    }

    /**
     * Determine if the user has the given permission.
     *
     * @param string|Permission $permission
     *
     * @return bool
     */
    protected function hasDirectPermission($permission)
    {
        if (is_string($permission)) {
            $permission = app(Permission::class)->findByName($permission);

            if (!$permission) {
                return false;
            }
        }

        return $this->permissions->contains('id', $permission->id);
    }

    /**
     * @param $role
     *
     * @return Role
     */
    protected function getStoredRole($role)
    {
        if (is_string($role)) {
            return app(Role::class)->findByName($role);
        }

        return $role;
    }
    
    public function setAsSuperUser() {
        $roles = $this->roles;
        
        if ( $roles->where('name', 'superuser')->isEmpty() ) {
            $role = new \Winponta\Cani\Models\Jenssegers\Mongodb\Role();
            $role->name = 'superuser';
            $role->label = 'Super User';
            $role->description = 'User that has the power to control all app';
            $this->roles()->associate($role);            
        }
    }
    
    public function isSuperUser() {
        return $this->hasRole('superuser');
    }
}
