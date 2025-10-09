<?php

namespace App\Controller\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class Login
{
    public function __invoke(Request $request): void
    {

        if ($request->getMethod() === 'POST') {
            $users = Yaml::parseFile(dirname(dirname(dirname(__DIR__))) . '/config/users.yaml');

            foreach ($users as $user) {
                if ($user['username'] === $request->request->get('username')) {
                    if (password_verify($request->request->get('password'), $user['password'])) {
                        $_SESSION['user'] = $user;

                        header('Location: /');
                        exit;
                    }
                }
            }

            dump('Invalid credentials');
        }

        require TEMPLATES_PATH . '/security/login.php';
    }
}
