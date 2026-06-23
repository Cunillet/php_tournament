<?php
declare(strict_types=1);

namespace App\Controller;

abstract class BaseController
{
    // Common controller functionality
    protected function jsonResponse(array $data, int $statusCode = 200): string
    {
        header('Content-Type: application/json');
        http_response_code($statusCode);
        return json_encode($data);
    }
}
