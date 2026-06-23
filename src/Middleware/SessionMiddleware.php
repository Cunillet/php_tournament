<?php
namespace App\Middleware;

use App\Router\Route;
use App\Middleware\MiddlewareInterface;

class SessionMiddleware implements MiddlewareInterface {
    public function handle(Route $route): void {
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
    }
}