<?php
namespace App\Middleware;

use App\Router\Route;
use App\Middleware\MiddlewareInterface;

class AuthMiddleware implements MiddlewareInterface {
    public function handle(Route $route): void {
        // Check if session exists
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['logged_in'] = false;
        }
        
        // Check session timeout (30 minutes)
        if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity'] > 3600)) {
            $userController = new UserController();
            $userController->logout(false);
        }
        
        // Update last activity
        $_SESSION['last_activity'] = time();
    }

}
