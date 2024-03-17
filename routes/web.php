<?php

use App\Controllers\IndexController;
use Symfony\Component\Routing\Route;

$controller = IndexController::class;

$routes->add("$controller@workflows", new Route('/'));
$routes->add("$controller@customers", new Route('/customers'));
$routes->add("$controller@storeCustomer", new Route('/customers/store'));

// Transitions
$routes->add("$controller@transition", new Route('/workflows/{id}/transitions/{transition}'));