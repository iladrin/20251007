<?php

namespace App\Controller;

use App\Service\Container;
use Psr\Log\LoggerInterface;

class Homepage
{
    public function __construct(private readonly Container $container)
    {
    }

    public function __invoke(): void
    {
        // ...
        dump($_SESSION);

        $this->container->get(LoggerInterface::class)->debug('Homepage controller called');

        require TEMPLATES_PATH . '/homepage.php';
    }
}
