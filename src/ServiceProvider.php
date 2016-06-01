<?php

namespace Winponta\Cani;

use Illuminate\Support\ServiceProvider;

/**
 * Cani ServiceProvider
 *
 * @author ademir.mazer.jr@gmail.com
 */
class ServiceProvider extends ServiceProvider {

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot() {
        $this->initializeResources();
    }

    private function initializeResources() {
        // incluindo as rotas padrões
        include __DIR__ . '/../Http/routes.php';

        // registra o caminho das visões deste pacote
        $this->loadViewsFrom(__DIR__ . '/views', 'cani');

        $this->mergeConfigFrom(
                __DIR__ . '/../config/cani.php', 'cani'
        );

        // define um diretório para publicar as visões e configurações caso o desenvolvedor
        // usuário deste pacote deseje alterá-las na sua aplicação
        $this->publishes([
            __DIR__ . '/views' => base_path('resources/views/vendor/winponta/cani'),
                ], 'views');

        $this->publishes([
            __DIR__ . '/config' => config_path(),
                ], 'config');
    }

    /**
     * Register bindings in the container.
     *
     * @return void
     */
    public function register() {
        $this->app->singleton('cani', function ($app) {
            return new \Winponta\Cani\Cani($app, $app['defender.role'], $app['defender.permission']);
        });
        
        //  $this->app->make('Winponta\Cani\Http\Controllers\CaniController');
//        $this->app->singleton('Riak\Contracts\Connection', function ($app) {
//            return new Connection(config('riak'));
//        });
    }

}
