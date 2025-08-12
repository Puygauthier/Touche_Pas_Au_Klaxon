<?php
namespace App\Models;

use App\Core\Model;

class User extends Model
{
    protected $table = 'utilisateurs';

    /**
     * Retourne tous les utilisateurs triés par nom.
     *
     * @return array
     */
    public function findAll(): array
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY nom");
    }

    /**
     * Trouve un utilisateur par son ID.
     *
     * @param int $id
     * @return array|null
     */
    public function findById(int $id): ?array
    {
        return $this->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    /**
     * Trouve un utilisateur par son adresse email.
     *
     * @param string $email
     * @return array|null
     */
    public function findByEmail(string $email): ?array
    {
        return $this->queryOne("SELECT * FROM {$this->table} WHERE email = ?", [$email]);
    }
}
