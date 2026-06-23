<?php
declare(strict_types=1);

spl_autoload_register(function ($class) {
    // Define possible base directories
    $baseDirs = [
        __DIR__ . '/',
        __DIR__ . '/../src/',
        __DIR__ . '/../',
    ];
    
    // Check if it's our namespace
    $prefix = 'App\\';
    if (strpos($class, $prefix) !== 0) {
        return false;
    }
    
    // Remove prefix and convert to path
    $relativeClass = substr($class, strlen($prefix));
    $classPath = str_replace('\\', '/', $relativeClass) . '.php';
    
    // Try each base directory
    foreach ($baseDirs as $baseDir) {
        $file = $baseDir . $classPath;
        
        if (file_exists($file)) {
            require $file;
            return true;
        }
    }
    
    // If we're in debug mode, log the failure
    if (defined('DEBUG_AUTOLOAD') && DEBUG_AUTOLOAD) {
        error_log("Autoloader failed to find: {$class}");
        error_log("Tried paths: " . implode(', ', array_map(function($dir) use ($classPath) {
            return $dir . $classPath;
        }, $baseDirs)));
    }
    
    return false;
});