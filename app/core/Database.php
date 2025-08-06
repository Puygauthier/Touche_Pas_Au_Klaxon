<?php
namespace App\Core;

use PDO;
use PDOException;

class Database {
    private static $pdo;

    public static function getConnection(): PDO {
        if (!self::$pdo) {
            try {
                self::$pdo = new PDO(
                    'mysql:host=localhost;dbname=covoiturage;charset=utf8mb4',
                    'root', // utilisateur MySQL
                    '',     // mot de passe
                    [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
                    ]
                );
            } catch (PDOException $e) {
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }
        return self::$pdo;
    }
}
