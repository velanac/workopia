<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';
require_once '../helpers.php';

use Framework\Router;

// Instantiate the router
$router = new Router();

// Get router
$routes = require basePath('routes.php');

// Get current URI and HTTP method
$uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri);
