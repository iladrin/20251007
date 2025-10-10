<?php

namespace App\Controller\Security;

use App\EntityManager\UserManager;
use App\Service\Container;
use App\Service\Database;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class Login
{
    public function __construct(private readonly Container $container)
    {
    }

    public function __invoke(Request $request): void
    {

        if ($request->getMethod() === 'POST') {
            // 1st implementation using YAML
//            $users = Yaml::parseFile(dirname(dirname(dirname(__DIR__))) . '/config/users.yaml');
//            foreach ($users as $user) {
//                if ($user['username'] === $request->request->get('username')) {
//                    if (password_verify($request->request->get('password'), $user['password'])) {
//                        $_SESSION['user'] = $user;
//
//                        header('Location: /');
//                        exit;
//                    }
//                }
//            }

            // 2nd implementation using a database
//            $connection = dump((new Database())->getConnection());
//
//            $statement = $connection->prepare('SELECT * FROM user WHERE username = :username');
//            $statement->bindValue(':username', $request->request->get('username'));
//
//            $statement->execute();
//
//            $user = $statement->fetch();
//
//            if ($user !== false) {
//                if (password_verify($request->request->get('password'), $user['password'])) {
//                    $_SESSION['user'] = $user;
//
//                    header('Location: /');
//                    exit;
//                }
//            }

            // 3rd implementation using a UserManager service and a User entity
            $user = $this->container
                ->get(UserManager::class)
                ->findOneByUsername($request->request->get('username'));

            if ($user !== null) {
                if (password_verify($request->request->get('password'), $user->getPassword())) {
                    $_SESSION['user'] = $user;

                    header('Location: /');
                    exit;
                }
            }
            dump('Invalid credentials');
        }

        require TEMPLATES_PATH . '/security/login.php';
    }
}
