<?php
class Auth
{
    public static function login($user)
    {
        session_regenerate_id(true);
        $_SESSION['user'] = [
            'id'    => $user['id'],
            'name'  => $user['name'],
            'email' => $user['email'],
            'role'  => $user['role']
        ];
    }

    public static function logout()
    {
        session_unset();
        session_destroy();
        header("Location: /ticketflow/public/auth/login");
        exit;
    }

    public static function check()
    {
        return isset($_SESSION['user']);
    }

    public static function user()
    {
        return $_SESSION['user'] ?? null;
    }

    public static function requireLogin()
    {
        if (!self::check()) {
            header("Location: /ticketflow/public/auth/login");
            exit;
        }
    }
}
