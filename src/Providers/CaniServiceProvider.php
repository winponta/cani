<?php

namespace Winponta\Cani\Providers;

use Illuminate\Support\ServiceProvider;

/**
 * CaniServiceProvider
 *
 * @author ademir.mazer.jr@gmail.com
 */
class CaniServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->initializeResources();
    }

    private function initializeResources() {
        $this->mergeConfigFrom(
                __DIR__ . '/../config/cani.php', 'cani'
        );

        $this->publishes([
            __DIR__ . '/../config' => config_path(),
        ], 'config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('cani', function ($app) {
            //return new \Winponta\Cani\Cani($app, $app['cani.models.role'], $app['cani.models.permission']);
            return new \Winponta\Cani\Cani($app);
        });
    }

}
