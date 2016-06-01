<?php

namespace Winponta\Cani\Models\Jenssegers\Mongodb;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * Base Permission class to use with Jenssegers/Mongodb driver.
 */
class Permission extends Model {
    protected $table = 'cani_permissions';

    protected $fillable = ['name', 'label', 'description'];
}
