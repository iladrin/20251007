<?php

namespace App\Controller;

use JetBrains\PhpStorm\NoReturn;

class Error
{
    #[NoReturn]
    public function __invoke(): void
    {
        dd('Error 404');
    }
}
