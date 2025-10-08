<?php

require '../vendor/autoload.php';

$routes = require '../config/routes.php';
$routes = Symfony\Component\Yaml\Yaml::parseFile('../config/routes.yaml');

$requestedPage = $_GET['page'] ?? 'home';

if (!array_key_exists($requestedPage, $routes)) {
    $requestedPage = 'error';
}

$container = (new \App\Service\Container())
    ->add(Psr\Log\LoggerInterface::class, function () {
        return new App\Service\Log\Logger(dirname(__DIR__) . '/var/log/dev.log');
    });


define('TEMPLATES_PATH', dirname(__DIR__) . '/templates');

$controllerName = $routes[$requestedPage]['controller'];

try {
    $controller = new $controllerName($container);
    $controller();

//    $logger = new App\Service\Log\Logger(dirname(__DIR__) . '/var/log/dev.log');
//    $logger->info('Controller called: ' . $controllerName);
} catch (Exception $e) {
    echo $e->getMessage();
}
