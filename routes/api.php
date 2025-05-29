<?php

use App\Http\Api\Authorization\LoginController;
use App\Http\Api\Authorization\LogoutController;
use App\Http\Api\Authorization\RegisterController;
use App\Standards\Enums\MiddlewareName;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;

Route::group([ 'prefix' => 'v1' ], function (Router $router)
{
    $router->group([ 'prefix' => 'auth' ], function (Router $router)
    {
        $router->post('register', [ RegisterController::class, 'register' ]);

        $router->post('login', [ LoginController::class, 'login' ]);

        $router->post('logout', [ LogoutController::class, 'logout' ])->middleware(MiddlewareName::AUTH_SANCTUM->value);
    });
});
