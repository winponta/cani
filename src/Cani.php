<?php

namespace Winponta\Cani;

use Illuminate\Contracts\Foundation\Application;

/**
 * Cani class
 */
class Cani 
{
    /**
     * The Laravel Application.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;

    /**
     * Class constructor.
     *
     * @param Application          $app
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
    }

    /**
     * Check if the authenticated user can execute/do/has 
     * the given permission.
     *
     * @param string $permission
     * @param bool   $force
     *
     * @return bool
     */
    public function run($permission, $force = false)
    {
        //TODO several permissions
        if (\Auth::check()) {
            return \Auth::user()->canRun($permission, $force);
        }

        return false;
    }

    /**
     * Return if the authenticated user can act/has the given role.
     *
     * @param string $roleName
     *
     * @return bool
     */
    public function act($roleName)
    {
        //TODO several roles
        if (\Auth::check()) {
            return \Auth::user()->canAct($roleName);
        }

        return false;
    }

    /**
     * @return Javascript
     */
    public function javascript()
    {
        if (! $this->javascript) {
            $this->javascript = new Javascript($this);
        }

        return $this->javascript;
    }
}
