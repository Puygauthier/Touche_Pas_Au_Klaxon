<?php
namespace App\Core;

use PDO;
use PDOException;

class Database
{
    private static ?PDO $pdo = null;

    public static function getConnection(): PDO
    {
        if (self::$pdo === null) {
            // ⚙️ Paramètres de connexion (adapte seulement $db si besoin)
            $host    = '127.0.0.1';       // évite les soucis de socket avec "localhost"
            $port    = 3306;              // port MySQL/MariaDB par défaut sous Wamp
            $db      = 'covoiturage';     // <-- ton nom de base
            $user    = 'root';
            $pass    = '';                // Wamp par défaut
            $charset = 'utf8mb4';

            $dsn = "mysql:host={$host};port={$port};dbname={$db};charset={$charset}";

            $options = [
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                // S'assure que la connexion est bien en utf8mb4 côté serveur
                PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4 COLLATE utf8mb4_general_ci"
            ];

            try {
                self::$pdo = new PDO($dsn, $user, $pass, $options);
                // Ceinture + bretelles : s'assure de la collation de la connexion
                self::$pdo->exec("SET collation_connection = 'utf8mb4_general_ci'");
            } catch (PDOException $e) {
                // En dev, message explicite; en prod, log + message générique
                die('Erreur de connexion à la base de données : ' . $e->getMessage());
            }
        }

        return self::$pdo;
    }
}
