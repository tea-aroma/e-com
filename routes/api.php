<?php


use App\Standards\Enums\MiddlewareName;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;


Route::group([ 'prefix' => 'v1', 'middleware' => MiddlewareName::AUTH_SANCTUM->value ], function (Router $router)
{
    $router->group([ 'prefix' => 'auth' ], function (Router $router)
    {
        $router->post('register', [ App\Http\Api\Authorization\RegisterController::class, 'register' ])->withoutMiddleware(MiddlewareName::AUTH_SANCTUM->value);

        $router->post('login', [ App\Http\Api\Authorization\LoginController::class, 'login' ])->withoutMiddleware(MiddlewareName::AUTH_SANCTUM->value);

        $router->post('logout', [ App\Http\Api\Authorization\LogoutController::class, 'logout' ])->middleware(MiddlewareName::AUTH_SANCTUM->value);
    });

    $router->group([ 'prefix' => 'classifiers' ], function (Router $router)
    {
        $router->get('list', [ \App\Http\Api\Classifiers\ClassifiersController::class, 'list' ]);
    });

    $router->group([ 'prefix' => 'products' ], function (Router $router)
    {
        $router->get('get', [ \App\Http\Api\Products\ProductsController::class, 'get' ]);

        $router->get('list', [ \App\Http\Api\Products\ProductsController::class, 'list' ]);

        $router->post('create', [ \App\Http\Api\Products\ProductsController::class, 'create' ]);
    });

    $router->group([ 'prefix' => 'cart' ], function (Router $router)
    {
        $router->get('get', [ \App\Http\Api\Carts\CartController::class, 'get' ]);

        $router->get('products', [ \App\Http\Api\Carts\CartController::class, 'products' ]);

        $router->post('append', [ \App\Http\Api\Carts\CartController::class, 'append' ]);

        $router->post('delete', [ \App\Http\Api\Carts\CartController::class, 'delete' ]);

        $router->post('payment', [ \App\Http\Api\Carts\CartController::class, 'payment' ]);
    });

    $router->group([ 'prefix' => 'orders' ], function (Router $router)
    {
        $router->get('get', [ \App\Http\Api\Orders\OrdersController::class, 'get' ]);

        $router->get('list', [ \App\Http\Api\Orders\OrdersController::class, 'list' ]);
    });

    $router->group([ 'prefix' => 'payment' ], function (Router $router)
    {
        $router->get('accept', [ \App\Http\Api\Payments\PaymentController::class, 'accept' ]);
    });
});
