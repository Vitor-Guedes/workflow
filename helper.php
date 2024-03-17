<?php

use Symfony\Component\HttpFoundation\Request;

if (! function_exists('view')) {
    function view(string $file, $vars = []) {
        extract($vars);
        include sprintf(
            __DIR__ . '/src/pages/%s.php',
            $file
        );
    }
}

if (! function_exists('request')) {
    function request() {
        return Request::createFromGlobals();
    }
}

if (! function_exists('redirect')) {
    function redirect(string $location, $permanent = false) {
        header('Location: ' . $location, true, $permanent ? 301 : 302);
        exit;
    }
}

