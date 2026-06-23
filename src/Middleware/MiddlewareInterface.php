<?php
declare(strict_types=1);

namespace App\Middleware;

use App\Router\Route;

interface MiddlewareInterface {
    public function handle(Route $route): void;
}
