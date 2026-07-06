<?php

declare(strict_types=1);

if (!defined('SESSION_NAME')) {
    define('SESSION_NAME', 'TEST_SESSION');
}
if (!defined('SESSION_HHTPONLY')) {
    define('SESSION_HHTPONLY', true);
}
if (!defined('SESSION_SECURE')) {
    define('SESSION_SECURE', false);
}
if (!defined('SESSION_SAMETIME')) {
    define('SESSION_SAMETIME', 'Strict');
}
if (!defined('SESSIONSTRICT_MODE')) {
    define('SESSIONSTRICT_MODE', true);
}
if (!defined('SESSION_TIME')) {
    define('SESSION_TIME', 3600);
}
if (!defined('SESSION_STRICT')) {
    define('SESSION_STRICT', 0);
}

require_once __DIR__ . '/../src/autoloader.php';
