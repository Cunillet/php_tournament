<?php

class ViewHelper {
    private const BASE_PATH = __DIR__.'/../public/views/';
    public static function loadWithMasterView($view, $data = []) {
        // Include layout
        $data['BASE_PATH'] = self::BASE_PATH;
        include self::BASE_PATH.'layouts/master.php';
    }

    public static function redirectToHome() {
        $protocol = isset($_SERVER['HTTPS']) ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        $home_url = $protocol . $host . '/';
        
        header('Location: ' . $home_url);
        exit;
    }
}