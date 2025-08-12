<?php
namespace App\Models;

use App\Core\Model;

class Agence extends Model
{
    protected $table = 'agences';

    public function findAll(): array
    {
        return $this->query("SELECT * FROM {$this->table} ORDER BY nom ASC");
    }

    public function findById(int $id): ?array
    {
        return $this->queryOne("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
    }

    public function create(array $data): void
    {
        $this->query("INSERT INTO {$this->table} (nom) VALUES (?)", [
            trim($data['nom'] ?? '')
        ]);
    }

    public function update(int $id, array $data): void
    {
        $this->query("UPDATE {$this->table} SET nom = ? WHERE id = ?", [
            trim($data['nom'] ?? ''), $id
        ]);
    }

    public function delete(int $id): void
    {
        $this->query("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
}

