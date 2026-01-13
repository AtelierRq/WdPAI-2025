<?php

namespace App\Database;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $instance = null;

    public static function getConnection(): PDO
    {
        if (self::$instance === null) {
            try {
                $dsn = sprintf(
                    'pgsql:host=%s;port=%s;dbname=%s',
                    getenv('DB_HOST'),
                    getenv('DB_PORT'),
                    getenv('DB_NAME')
                );

                self::$instance = new PDO(
                    $dsn,
                    getenv('DB_USER'),
                    getenv('DB_PASSWORD'),
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                    ]
                );
            } catch (PDOException $e) {
                // do testu
                die($e->getMessage());
            }
        }

        return self::$instance;
    }
}