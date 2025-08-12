<?php
namespace App\Models;

use App\Core\Database;

class UserModel
{
    public function getByEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC); // DÖNDÜR!
    }

    public function getById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function getAll()
    {
        $db = Database::getInstance();
        $stmt = $db->query("SELECT * FROM users");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function add($username, $email, $password, $avatar = null)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO users (username, email, password, avatar) VALUES (?, ?, ?, ?)");
        return $stmt->execute([
            $username,
            $email,
            password_hash($password, PASSWORD_DEFAULT),
            $avatar
        ]);
    }
}