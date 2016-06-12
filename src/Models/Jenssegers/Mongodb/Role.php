<?php

namespace Winponta\Cani\Models\Jenssegers\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;
use Winponta\Cani\Contracts\Role as RoleContract;
use Winponta\Cani\Exceptions\RoleDoesNotExist;
use Winponta\Cani\Traits\CanHavePermissions;
use Winponta\Cani\Traits\RefreshesPermissionCache;

/**
 * Base Role class to use with Jenssegers/Mongodb driver.
 */
class Role extends Model implements RoleContract {
    use CanHavePermissions;
    use RefreshesPermissionCache;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    protected $fillable = ['name', 'label', 'description'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('cani.collections.roles'));
    }

    //protected $table = 'cani_roles';

    /**
     * A role may be given various permissions.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function permissions() {
        return $this->embedsMany(config('cani.models.permission'));
    }

    /**
     * A role may be assigned to various users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users()
    {
        return $this->belongsToMany(
            config('auth.model') ?: config('auth.providers.users.model'),
                null, 
                config('cani.collections.user_roles_propertie')
        );
    }

    /**
     * Find a role by its name.
     *
     * @param string $name
     *
     * @return Role
     *
     * @throws RoleDoesNotExist
     */
    public static function findByName($name)
    {
        $role = static::where('name', $name)->first();

        if (!$role) {
            throw new RoleDoesNotExist();
        }

        return $role;
    }

    /**
     * Determine if the role may perform the given permission.
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

        return $this->permissions->contains('id', $permission->id);
    }
}
