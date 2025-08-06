<?php
namespace App\Core;

class Auth {
    public static function isLoggedIn(): bool {
        return isset($_SESSION['user']);
    }

    public static function getUser() {
        return $_SESSION['user'] ?? null;
    }

    public static function isAdmin(): bool {
        return self::isLoggedIn() && $_SESSION['user']['role'] === 'admin';
    }

    public static function login(array $user): void {
        $_SESSION['user'] = $user;
    }

    public static function logout(): void {
        unset($_SESSION['user']);
        session_destroy();
    }
}
