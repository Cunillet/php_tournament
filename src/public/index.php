<?php
declare(strict_types=1);
define('DEBUG_AUTOLOAD', true);
require_once __DIR__.'/../autoloader.php';
require_once __DIR__.'/../config/config.php';

use App\Container\Container;
use App\Controller\UserController;
use App\Router\Dispatcher;
use App\Router\Router;
use App\Middleware\CorsMiddleware;
use App\Middleware\AuthMiddleware;
use App\Middleware\SessionMiddleware;

// Create container
$container = new Container();

// Setup router
$router = new Router();
$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

// Create dispatcher
$dispatcher = new Dispatcher($router->getRouteCollection(), $container);

// Add global middlewares
$dispatcher->addMiddleware(new CorsMiddleware());
$dispatcher->addMiddleware(new SessionMiddleware());
$dispatcher->addMiddleware(new AuthMiddleware());

// Dispatch
try {
    $method = $_SERVER['REQUEST_METHOD'];
    $uri = $_SERVER['REQUEST_URI'];
    
    $response = $dispatcher->dispatch($method, $uri);
    echo $response;
} catch (\Exception $e) {
    http_response_code($e->getCode() ?: 500);
    echo json_encode(['error' => $e->getMessage()]);
}
