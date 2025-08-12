<?php
namespace App\Core;

final class Auth
{
    private const SESSION_KEY = 'user';

    /** Connecte l'utilisateur (données minimales utilisées par le layout) */
    public static function login(array $user): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $_SESSION[self::SESSION_KEY] = [
            'id'     => isset($user['id']) ? (int)$user['id'] : null,
            'prenom' => (string)($user['prenom'] ?? ''),
            'nom'    => (string)($user['nom'] ?? ''),
            'role'   => (string)($user['role'] ?? 'utilisateur'),
            'email'  => (string)($user['email'] ?? ''),
        ];
        // Renouvelle l’ID de session pour sécurité
        session_regenerate_id(true);
    }

    /** Déconnecte l’utilisateur */
    public static function logout(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        unset($_SESSION[self::SESSION_KEY]);
        session_regenerate_id(true);
    }

    /** Retourne l’utilisateur courant ou null */
    public static function getUser(): ?array
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            session_start();
        }
        $u = $_SESSION[self::SESSION_KEY] ?? null;
        return (is_array($u) && !empty($u['id'])) ? $u : null;
    }

    /** Est connecté ? */
    public static function isLoggedIn(): bool
    {
        return self::getUser() !== null;
    }

    /** Est admin ? */
    public static function isAdmin(): bool
    {
        $u = self::getUser();
        if (!$u) return false;
        $role = mb_strtolower((string)($u['role'] ?? ''));
        return in_array($role, ['admin', 'administrateur'], true);
    }
}
