<?php

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\RequestContext;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\RouteCollection;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Exception\ResourceNotFoundException;

include_once dirname(__DIR__) . '/vendor/autoload.php';

$request = Request::createFromGlobals();

$context = new RequestContext();
$context->fromRequest($request);

$routes = new RouteCollection();

$matcher = new UrlMatcher($routes, $context);

require "../routes/web.php";
require "../helper.php";

try {
    $route = $matcher->match($request->getPathInfo());

    list($controller, $action) = explode('@', $route['_route']);

    if (! class_exists($controller)) {
        throw new Exception("Controller $controller não existe.");
    }

    $controller = new $controller();
    if (! method_exists($controller, $action)) {
        $_controller = get_class($controller);
        throw new Exception("Action $action da Controller $_controller não existe.");
    }
    
    unset($route['_route']);

    ob_start();

    echo call_user_func_array([$controller, $action], $route);

    $response = new Response(ob_get_clean());
} catch (ResourceNotFoundException $exception) {
    $response = new Response('Not Found', 404);
} catch (Exception $exception) {
    $response = new Response('An error occurred: ' . $exception->getMessage(), 500);
}

$response->send();