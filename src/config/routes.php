<?php
declare(strict_types=1);

use App\Controller\UserController;
use App\Controller\WelcomeController;
use App\Router\Router;

return function (Router $router) {
    $router->get('/', WelcomeController::class, 'index');
    $router->get('/login', UserController::class, 'loginView');
    $router->post('/login', UserController::class, 'login');
    $router->get('/logout', UserController::class, 'logout');
    $router->get('/register', UserController::class, 'storeView');
    $router->post('/register', UserController::class, 'store');
    $router->get('/profile/{id}', UserController::class, 'profile');
    $router->post('/profile', UserController::class, 'store');
    $router->put('/profile/{id}', UserController::class, 'update');
    $router->delete('/profile/{id}', UserController::class, 'destroy');
    
    // With middleware
    // $router->post('/admin/users', UserController::class, 'adminCreate')
    //     ->setMiddlewares([AuthMiddleware::class, AdminMiddleware::class]);
};
