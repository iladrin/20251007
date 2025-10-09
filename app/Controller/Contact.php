<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Request;

class Contact
{
    public function __invoke(Request $request): void
    {
        if ($request->getMethod() === 'POST') {
            $items = $request->request;

            dump($request->request->all());
            dump($request->request->getString('name'));

            // @todo: Send an email
        }

        require TEMPLATES_PATH . '/contact.php';
    }
}
