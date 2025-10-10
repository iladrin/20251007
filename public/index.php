<?php

use Symfony\Component\VarDumper\Cloner\VarCloner;
use Symfony\Component\VarDumper\Dumper\CliDumper;
use Symfony\Component\VarDumper\Dumper\ContextProvider\CliContextProvider;
use Symfony\Component\VarDumper\Dumper\ContextProvider\SourceContextProvider;
use Symfony\Component\VarDumper\Dumper\HtmlDumper;
use Symfony\Component\VarDumper\Dumper\ServerDumper;
use Symfony\Component\VarDumper\VarDumper;

// Autoload files using Composer autoload
// No more need to require_once files
require '../vendor/autoload.php';

// Initialize the session
session_start();

// Enable the VarDumper to be collected by the server dump command
// @example vendor/bin/var-dump-server
// @example php bin/console.php server:dump
$cloner = new VarCloner();
$fallbackDumper = \in_array(\PHP_SAPI, ['cli', 'phpdbg']) ? new CliDumper() : new HtmlDumper();
$dumper = new ServerDumper('tcp://127.0.0.1:9912', $fallbackDumper, [
    'cli' => new CliContextProvider(),
    'source' => new SourceContextProvider(),
]);

VarDumper::setHandler(function (mixed $var) use ($cloner, $dumper): ?string {
    return $dumper->dump($cloner->cloneVar($var));
});

// Create a request from super globals
// @see $_GET, $_POST, $_COOKIE, $_FILES, $_SERVER
$request = \Symfony\Component\HttpFoundation\Request::createFromGlobals();

// Load routes from YAML file
$routes = Symfony\Component\Yaml\Yaml::parseFile('../config/routes.yaml');

// Get the requested page from the URL
$requestedPage = $_GET['page'] ?? 'home';

if (!array_key_exists($requestedPage, $routes)) {
    $requestedPage = 'error';
}

// Create a container with services
$container = (new \App\Service\Container())
    ->add(App\Service\Database::class, function () {
        return new App\Service\Database();
    })
    ->add(\App\EntityManager\UserManager::class, function () use (&$container) {
        return new \App\EntityManager\UserManager($container);
    })
    ->add(Psr\Log\LoggerInterface::class, function () {
        return new App\Service\Log\Logger(dirname(__DIR__) . '/var/log/dev.log');
    });


define('PROJECT_PATH', dirname(__DIR__));
const TEMPLATES_PATH = PROJECT_PATH . '/templates';

$controllerName = $routes[$requestedPage]['controller'];

try {
    // Call the controller
    $controller = new $controllerName($container);
    $controller($request);
} catch (Exception $e) {
    echo $e->getMessage();
}
