<?php
declare(strict_types=1);

use App\Router\Router;
use App\Controller\GameTypeController;
use App\Controller\TournamentController;
use App\Controller\UserController;
use App\Controller\WelcomeController;

return function (Router $router) {
    $router->get('/', WelcomeController::class, 'index');
    $router->get('/login', UserController::class, 'loginView');
    $router->post('/login', UserController::class, 'login');
    $router->get('/logout', UserController::class, 'logout');
    $router->get('/register', UserController::class, 'storeView');
    $router->post('/register', UserController::class, 'store');
    $router->get('/profile/{id}', UserController::class, 'profileView');
    $router->post('/profile', UserController::class, 'store');
    $router->put('/profile/{id}', UserController::class, 'update');
    $router->delete('/profile/{id}', UserController::class, 'destroy');
    
    $router->get('/tournaments', TournamentController::class, 'index');
    $router->get('/tournaments/{id}', TournamentController::class, 'show');
    $router->post('/tournaments/join/{id}', TournamentController::class, 'join');
    $router->get('/tournaments/create', TournamentController::class, 'create');
    $router->post('/tournaments', TournamentController::class, 'store');
    $router->post('/rounds/create/{id}', TournamentController::class, 'createRoundGames');

    $router->get('/gameTypes', GameTypeController::class, 'index');
    $router->get('/gameTypes/create', GameTypeController::class, 'create');
    $router->post('/gameTypes', GameTypeController::class, 'store');
    
    // With middleware
    // $router->post('/admin/users', UserController::class, 'adminCreate')
    //     ->setMiddlewares([AuthMiddleware::class, AdminMiddleware::class]);
};
