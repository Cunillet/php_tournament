<?php
namespace App\Middleware;

use App\Router\Route;
use App\Middleware\MiddlewareInterface;
use App\Helper\ViewHelper;
use App\Controller\UserController;

class AuthMiddleware implements MiddlewareInterface {
    private array $privatePaths;
    private array $guestPaths;

    public function __construct() {
        $this->privatePaths = [
            '/logout',
        ];
        $this->guestPaths = [
            '/login',
            '/register',
        ];
    }

    private function isPrivateOnly(Route $route): bool {
        foreach($this->privatePaths as $privatePath) {
            if ($route->getPath() === $privatePath) {
                return true;
            }
        }
        return false;
    }

    private function isGuestOnly(Route $route): bool {
        foreach($this->guestPaths as $guestPath) {
            if ($route->getPath() === $guestPath) {
                return true;
            }
        }
        return false;
    }

    public function handle(Route $route): void {
        // Check if session exists
        if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
            $_SESSION['logged_in'] = false;
            if ($this->isPrivateOnly($route)) {
                ViewHelper::redirectHome();
                exit(0);
            }
        } else {
            if ($this->isGuestOnly($route)) {
                ViewHelper::redirectHome();
                exit(0);
            }
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
