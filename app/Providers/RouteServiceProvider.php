<?php

namespace App\Providers;

use Illuminate\Routing\Router;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * This namespace is applied to the controller routes in your routes file.
     *
     * In addition, it is set as the URL generator's root namespace.
     *
     * @var string
     */
    protected $namespace = 'App\Http\Controllers';

    protected $apiNamespace = 'App\Http\Controllers\Api';

    /**
     * Define your route model bindings, pattern filters, etc.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function boot(Router $router)
    {
        //

        parent::boot($router);
    }

    /**
     * Define the routes for the application.
     *
     * @param  \Illuminate\Routing\Router  $router
     * @return void
     */
    public function map(Router $router)
    {
        
        /*
        |--------------------------------------------------------------------------
        | Web Router 
        |--------------------------------------------------------------------------
        */
        $router->group(['namespace' => $this->namespace], function ($router) {

            require app_path('Http/routes.php');
        });

        

        /*
        |--------------------------------------------------------------------------
        | Api Router 
        |--------------------------------------------------------------------------
        */

        $router->group(['namespace' => $this->apiNamespace, 'prefix' => 'api'], function ($router) {

            $router->group(['namespace' => 'Seller', 'prefix' => 'seller'], function ($router) {

                $router->group(['namespace' => 'V1', 'prefix' => 'v1'], function ($router) {
            
                    require app_path('Http/Routes/Api/Sellers/routes.v1.php');
                });
            
            });

            $router->group(['namespace' => 'Buyer', 'prefix' => 'buyer'], function ($router) {
           
                $router->group(['namespace' => 'V1', 'prefix' => 'v1'], function ($router) {
                       
                    require app_path('Http/Routes/Api/Buyers/routes.v1.php');
                });
            });
        });

    }
}
