<?php
require_once (__DIR__.'/../controller/UserController.php');

$userController = new Usercontroller();
$method = $_SERVER['REQUEST_METHOD'];

if ($method === 'POST') {
    $userController->register();
} else {
    http_response_code(404);
    echo json_encode(['error' => 'Error on request']);
}