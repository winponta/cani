<?php

namespace Winponta\Cani\Models\Jenssegers\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;
use Winponta\Cani\Contracts\Permission as PermissionContract;
use Winponta\Cani\Exceptions\PermissionDoesNotExist;
use Winponta\Cani\Traits\RefreshesPermissionCache;

/**
 * Base Permission class to use with Jenssegers/Mongodb driver.
 */
class Permission extends Model implements PermissionContract {

    use RefreshesPermissionCache;

    //protected $table = 'cani_permissions';
    protected $fillable = ['name', 'label', 'description'];

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    public $guarded = ['id'];

    /**
     * Create a new Eloquent model instance.
     *
     * @param array $attributes
     */
    public function __construct(array $attributes = []) {
        parent::__construct($attributes);

        $this->setTable(config('cani.collections.permissions'));
    }

    /**
     * A permission can be applied to roles.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function roles() {
        $roleClass = config('cani.models.role');
        $rolePropertieInPermission = config('cani.collections.role_permissions_propertie');
        
        return $this->belongsToMany(
                        $roleClass, null, $rolePropertieInPermission . '._id'
        );
    }

    /**
     * A permission can be applied to users.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function users() {
        return $this->belongsToMany(
                        config('auth.model') ? : config('auth.providers.users.model'), 
                        null,
                        config('cani.collections.user_permissions_propertie') . '_id'
        );
    }

    /**
     * Find a permission by its name.
     *
     * @param string $name
     *
     * @throws PermissionDoesNotExist
     */
    public static function findByName($name) {
        $permission = static::where('name', $name)->first();

        if (!$permission) {
            throw new PermissionDoesNotExist();
        }

        return $permission;
    }

}
