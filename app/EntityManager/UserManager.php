<?php

namespace App\EntityManager;

use App\Entity\User;
use App\Service\Container;
use App\Service\Database;

class UserManager
{
    public function __construct(private readonly Container $container)
    {
    }

    public function findOneByUsername(string $username): ?User
    {
        $connection = $this->container->get(Database::class)->getConnection();

        $statement = $connection->prepare('SELECT * FROM user WHERE username = :username');
        $statement->bindValue(':username', $username);

        $statement->execute();

        $row = $statement->fetch();

        if ($row === false) {
            return null;
        }

        // hydrate the User object
        return (new User())
            ->setId($row['id'])
            ->setUsername($username)
            ->setPassword($row['password'])
            ->setRoles(explode(',', $row['roles']))
        ;
    }
}
