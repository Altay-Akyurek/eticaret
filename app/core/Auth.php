<?php
namespace App\Core;

class Auth
{
    public static function check()
    {
        return isset($_SESSION['user_id']);
    }

    public static function user()
    {
        return $_SESSION['user_id'] ?? null;
    }

    public static function login($userId)
    {
        $_SESSION['user_id'] = $userId;
    }

    public static function logout()
    {
        session_destroy();
    }
}