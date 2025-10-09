<?php

namespace App\Controller\Security;

class Logout
{
    public function __invoke(): void
    {
        unset($_SESSION['user']);

        header('Location: /');
    }
}
