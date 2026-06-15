<?php
// Get the requested path
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?'); // Remove query parameters

// Remove trailing slash
$request = rtrim($request, '/');
if (empty($request)) $request = '/';

// Define routes
$routes = [
    // Page routes (views)
    '/' => 'views/home.php',
    '/register' => 'views/profile/register.php',
    '/login' => 'views/profile/login.php',
    '/dashboard' => 'views/dashboard.php',
    '/profile' => 'views/profile/profile.php',
    '/about' => 'views/about.php',
    '/contact' => 'views/contact.php',
    
    // API routes (backend)
    '/api/register' => 'api/register.php',
    '/api/login' => 'api/login.php',
    '/api/logout' => 'api/logout.php',
];
// Check if route exists
if (isset($routes[$request])) {
    $file = __DIR__ . '/' . $routes[$request];
    
    if (file_exists($file)) {
        require_once $file;
        exit;
    }
}

// If no route found, show 404
http_response_code(404);
require_once __DIR__ . '/views/404.php';
