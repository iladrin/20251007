<?php

namespace App\Service\Log;

use Psr\Log\AbstractLogger;
use Psr\Log\LoggerInterface;

class Logger extends AbstractLogger implements LoggerInterface
{
    public function __construct(private readonly string $filename)
    {
    }

    public function log(mixed $level, string|\Stringable $message, array $context = []): void
    {
        $message = '[' . date('Y-m-d H:i:s') . '] ' . $level . ': ' . $message;

        file_put_contents($this->filename, $message . PHP_EOL, FILE_APPEND);
    }
}
