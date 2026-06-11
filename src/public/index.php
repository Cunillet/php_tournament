index.php
<?php
require_once '../controller/UserController.php';

$userController = new Usercontroller();
$method = $_SERVER['REQUEST_METHOD'];
$path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

if (preg_match('/\/users\/(\d+)/', $path, $matches) && $method === 'GET') {
    $userController->show($matches[1]);
} elseif ($path === '/users' && $method === 'POST') {
    $userController->store();
} elseif (preg_match('/\/users\/(\d+)/', $path, $matches) && $method === 'PUT') {
    $userController->update($matches[1]);
} elseif (preg_match('/\/users\/(\d+)/', $path, $matches) && $method === 'DELETE') {
    $userController->destroy($matches[1]);
} elseif ($path === '/users/login' && $method === 'POST') {
    $userController->login();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Route not found']);
}


    // volumes:
    //   - ./src/:/var/www/html/
    //   - ./xdebug.ini:/usr/local/etc/php/conf.d/xdebug.ini
    //   - ./php.ini:/usr/local/etc/php/php.ini
?>