<?php
require_once __DIR__.'/../config/config.php';
require_once __DIR__.'/../controller/UserController.php';
require_once __DIR__.'/../helper/ViewHelper.php';

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

function isSessionValid() {
    // Check if session exists
    if (!isset($_SESSION['logged_in']) || $_SESSION['logged_in'] !== true) {
        $_SESSION['logged_in'] = false;
        return false;
    }
    
    // Check session timeout (30 minutes)
    if (time() - $_SESSION['last_activity'] > 3600) {
        $userController = new UserController();
        $userController->logout(false);
        return false;
    }
    
    // Update last activity
    $_SESSION['last_activity'] = time();
    return true;
}


// Get the requested path
$request = $_SERVER['REQUEST_URI'];
$request = strtok($request, '?'); // Remove query parameters
$isView = true;

// Remove trailing slash
$request = rtrim($request, '/');
if (empty($request)) $request = '/';

// Define private routes
$privateViewRoutes = [
    '/logout' => 'views/registered/profile/logout.php',
    '/dashboard' => 'views/dashboard.php',
    '/profile' => 'views/profile/profile.php',
];
$privateApiRoutes = [
    '/api/logout' => 'api/profile/logout.php'
];
// Define guest routes
$guestViewRoutes = [
    '/register' => 'views/profile/register.php',
    '/login' => 'views/profile/login.php',
];
$guestApiRoutes = [
    '/api/register' => 'api/profile/register.php',
    '/api/login' => 'api/profile/login.php',
];
// Define public routes
$viewRoutes = [
    '/' => 'views/home.php',
    '/about' => 'views/about.php',
    '/contact' => 'views/contact.php'
];
$apiRoutes = [];
// registered only
if (isSessionValid()) {
    if (isset($privateViewRoutes[$request])) {
        $file = __DIR__ . '/' . $privateViewRoutes[$request];
    } else if (isset($privateApiRoutes[$request])) {
        $file = __DIR__ . '/../' . $privateApiRoutes[$request];
        $isView = false;
    }
    $_SESSION['not_logged_in'] = true;

    // if accessing to logged in pages, redirect to home page
    if (isset($guestViewRoutes[$request]) || isset($guestApiRoutes[$request])) {
        ViewHelper::redirectToHome();
    }
// guest only
} else {
    if (isset($guestViewRoutes[$request])) {
        $file = __DIR__ . '/' . $guestViewRoutes[$request];
    } else if (isset($guestApiRoutes[$request])) {
        $file = __DIR__ . '/../' . $guestApiRoutes[$request];
        $isView = false;
    }
    $_SESSION['not_logged_in'] = false;

    // if accessing to guest pages as registered, redirect home
    if (isset($privateViewRoutes[$request]) || isset($privateApiRoutes[$request])) {
        ViewHelper::redirectToHome();
    }
}
// public
if (isset($viewRoutes[$request])) {
    $file = __DIR__ . '/' . $viewRoutes[$request];
} else if (isset($apiRoutes[$request])) {
    $file = __DIR__ . '/../' . $apiRoutes[$request];
    $isView = false;
}
// Load file ...
if (isset($file) && file_exists($file)) {
    if ($isView) {
        ViewHelper::loadWithMasterView($file);
    }
    require_once $file;
    exit;
}

// If no route found, show 404
http_response_code(404);
require_once __DIR__ . '/views/404.php';
