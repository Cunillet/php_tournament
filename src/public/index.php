<?php
declare(strict_types=1);
define('DEBUG_AUTOLOAD', true);
require_once __DIR__.'/../autoloader.php';
require_once __DIR__.'/../config/config.php';

session_name(SESSION_NAME);
session_set_cookie_params([
    'path' => '/',
    'httponly' => SESSION_HHTPONLY,  // Prevents JavaScript access to session cookie
    'secure' => SESSION_SECURE,    // Only send cookie over HTTPS
    'samesite' => SESSION_SAMETIME, // Protects against CSRF
]);

ini_set('session.use_strict_mode', SESSION_STRICT);
ini_set('session.gc_maxlifetime', SESSION_TIME);
ini_set('session.cookie_secure', SESSION_SECURE);
session_start();


use App\Container\Container;
use App\Controller\UserController;
use App\Router\Dispatcher;
use App\Router\Router;
use App\Middleware\CorsMiddleware;

// Create container
$container = new Container();

// Setup router
$router = new Router();
$routes = require __DIR__ . '/../config/routes.php';
$routes($router);

// Create dispatcher
$dispatcher = new Dispatcher($router->getRouteCollection(), $container);

// Add global middlewares
// $dispatcher->addMiddleware(new CorsMiddleware());

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
