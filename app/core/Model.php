<?php
namespace App\Core;

use App\Core\Database;
use PDO;

abstract class Model
{
    protected $pdo;
    protected $table;

    public function __construct()
    {
        // Utilise la connexion PDO statique
        $this->pdo = Database::getConnection();
    }

    // Exécute une requête et retourne tous les résultats (tableau)
    public function query(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Exécute une requête et retourne un seul résultat
    public function queryOne(string $sql, array $params = [])
    {
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
