<?php
namespace App\Models;

use App\Core\Model;
use App\Core\Database;
use PDO;

class Trajet extends Model
{
    // IMPORTANT : ne pas typer (doit matcher la déclaration dans App\Core\Model)
    protected $table = 'trajets';

    /** Liste complète (pour /trajets) */
    public function findAll(): array
    {
        return $this->query("
            SELECT t.*,
                   a1.nom AS agence_depart_nom,
                   a2.nom AS agence_arrivee_nom,
                   u.id  AS auteur_id,
                   u.nom AS auteur_nom, u.prenom AS auteur_prenom, u.email AS auteur_email, u.telephone AS auteur_telephone
            FROM {$this->table} t
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            JOIN utilisateurs u ON t.auteur_id = u.id
            ORDER BY t.date_heure_depart DESC
        ");
    }

    /** Détails par id */
    public function findById(int $id): ?array
    {
        return $this->queryOne("
            SELECT t.*,
                   a1.nom AS agence_depart_nom,
                   a2.nom AS agence_arrivee_nom,
                   u.id  AS auteur_id,
                   u.nom AS auteur_nom, u.prenom AS auteur_prenom, u.email AS auteur_email, u.telephone AS auteur_telephone
            FROM {$this->table} t
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            JOIN utilisateurs u ON t.auteur_id = u.id
            WHERE t.id = ?
        ", [$id]) ?: null;
    }

    /** Liste publique pour l’accueil : futurs + places restantes, tri ascendant */
    public function findPublic(): array
    {
        return $this->query("
            SELECT t.id, t.date_heure_depart, t.date_heure_arrivee, t.places_disponibles,
                   a1.nom AS agence_depart_nom,
                   a2.nom AS agence_arrivee_nom
            FROM {$this->table} t
            JOIN agences a1 ON t.agence_depart_id = a1.id
            JOIN agences a2 ON t.agence_arrivee_id = a2.id
            WHERE t.date_heure_depart >= NOW()
              AND t.places_disponibles > 0
            ORDER BY t.date_heure_depart ASC
        ");
    }

    /** Création d’un trajet : retourne l’ID inséré */
    public function create(array $data): int
    {
        $sql = "
            INSERT INTO {$this->table}
              (agence_depart_id, agence_arrivee_id, date_heure_depart, date_heure_arrivee, places_total, places_disponibles, auteur_id)
            VALUES
              (:dep, :arr, :dh_dep, :dh_arr, :tot, :dispo, :auteur)
        ";
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare($sql);
        $stmt->execute([
            ':dep'    => (int)$data['agence_depart_id'],
            ':arr'    => (int)$data['agence_arrivee_id'],
            ':dh_dep' => (string)$data['date_heure_depart'],
            ':dh_arr' => (string)$data['date_heure_arrivee'],
            ':tot'    => (int)$data['places_total'],
            ':dispo'  => (int)$data['places_disponibles'],
            ':auteur' => (int)$data['auteur_id'],
        ]);
        return (int)$pdo->lastInsertId();
    }

    /** Mise à jour d’un trajet */
    public function update(int $id, array $data): bool
    {
        $sql = "
            UPDATE {$this->table}
            SET
              agence_depart_id   = :dep,
              agence_arrivee_id  = :arr,
              date_heure_depart  = :dh_dep,
              date_heure_arrivee = :dh_arr,
              places_total       = :tot,
              places_disponibles = :dispo
            WHERE id = :id
        ";
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare($sql);
        return $stmt->execute([
            ':dep'    => (int)$data['agence_depart_id'],
            ':arr'    => (int)$data['agence_arrivee_id'],
            ':dh_dep' => (string)$data['date_heure_depart'],
            ':dh_arr' => (string)$data['date_heure_arrivee'],
            ':tot'    => (int)$data['places_total'],
            ':dispo'  => (int)$data['places_disponibles'],
            ':id'     => (int)$id,
        ]);
    }

    /** Suppression d’un trajet */
    public function delete(int $id): bool
    {
        $pdo = Database::getConnection();
        $stmt = $pdo->prepare("DELETE FROM {$this->table} WHERE id = :id");
        return $stmt->execute([':id' => (int)$id]);
    }
}
