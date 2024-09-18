<?php
require_once '../helpers.php';
require_once basePath('Router.php');
require_once basePath('Database.php');

// Instantiate the router
$router = new Router();

// Get router
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
