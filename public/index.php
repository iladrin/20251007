<?php
use Symfony\Component\Yaml\Yaml;

require '../vendor/autoload.php';

$routes = require '../config/routes.php';
$routes = Yaml::parseFile('../config/routes.yaml');

$requestedPage = $_GET['page'] ?? 'home';

if (!array_key_exists($requestedPage, $routes)) {
    $requestedPage = '404';
}

define('TEMPLATES_PATH', dirname(__DIR__) . '/templates');

//require '../app/Controller/' . $routes[$requestedPage]['controller'] . '.php';
require "../app/Controller/{$routes[$requestedPage]['controller']}.php";
render();
