<?php
require_once '../helpers.php';
require_once basePath('Database.php');
require_once basePath('Router.php');
$config = require_once basePath('config/db.php');

$db = new Database($config);

$router = new Router();

$routes = require basePath('routes.php');

$uri = $_SERVER['REQUEST_URI'];
$method = $_SERVER['REQUEST_METHOD'];

$router->route($uri, $method);
