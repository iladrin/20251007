<?php

namespace App\Service;

class Container
{
    private array $services = [];

    public function add(string $name, \Closure $callback): static
    {
        $this->services[$name] = $callback;

        return $this;
    }

    public function get(string $name): object
    {
        if (!\array_key_exists($name, $this->services)) {
            throw new \Exception("Service $name not found");
        }

        return $this->services[$name]();
    }
}
