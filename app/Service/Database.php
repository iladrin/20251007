<?php

namespace App\Service;

class Database
{
    private static ?\PDO $connection = null;

    public static function getConnection(): \PDO
    {
        if (self::$connection === null) {
            // new \PDO('mysql:host=localhost;dbname=test', 'root', '');

            self::$connection = new \PDO('sqlite:' . PROJECT_PATH . '/var/db.sqlite', options: [
                \PDO::ATTR_ERRMODE,
                \PDO::ERRMODE_EXCEPTION,
                \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            ]);
        }

        return self::$connection;
    }
}
