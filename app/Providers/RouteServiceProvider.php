<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * O namespace padrão para as rotas.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    /**
     * Define os mapeamentos de rota para a aplicação.
     *
     * @return void
     */
    public function map()
    {
        $this->mapApiRoutes();
        $this->mapWebRoutes();
    }

    /**
     * Mapeia as rotas da API.
     *
     * @return void
     */
    protected function mapApiRoutes()
    {
        Route::prefix('api')
             ->middleware('api')
             ->namespace($this->namespace)
             ->group(base_path('routes/api.php'));
    }

    /**
     * Mapeia as rotas da web.
     *
     * @return void
     */
    protected function mapWebRoutes()
    {
        Route::middleware('web') 
             ->namespace($this->namespace)
             ->group(base_path('routes/web.php'));
    } 
}
