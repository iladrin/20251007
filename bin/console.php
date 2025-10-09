<?php

use App\Console\UserListCommand;
use Symfony\Component\VarDumper\Server\DumpServer;

require dirname(__DIR__) . '/vendor/autoload.php';

$application = new \Symfony\Component\Console\Application();

$application->add(new UserListCommand());
$application->add(new \App\Console\SecurityEncodePasswordCommand());
$application->add(new \Symfony\Component\VarDumper\Command\ServerDumpCommand(
    new DumpServer('127.0.0.1:9912', new \App\Service\Log\Logger(dirname(__DIR__) . '/var/log/dump.log'))
));
$application->run();
