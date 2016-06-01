<?php

namespace Winponta\Cani\Models\Jenssegers\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;
use Winponta\Cani\Contracts\Role as RoleContract;

/**
 * Base Role class to use with Jenssegers/Mongodb driver.
 */
class Role extends Model implements RoleContract {
    protected $table = 'cani_roles';

    protected $fillable = ['name', 'label', 'description'];

    public function permissions() {
        return $this->embedsOne(Permission::class);
    }

}
