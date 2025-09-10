<?php
namespace App\Models;

use App\Core\Database;

class UserModel
{
    public function getByEmail($email)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM users WHERE LOWER(email) = LOWER(?)");
        $stmt->execute([$email]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
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

    public function deleteUser($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM users WHERE id = ?");
        return $stmt->execute([$id]);
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

    public function update($id, $username, $email, $password = null, $avatar = null)
    {
        $db = Database::getInstance();

        if ($password) {
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, password = ?, avatar = ? WHERE id = ?");
            return $stmt->execute([
                $username,
                $email,
                password_hash($password, PASSWORD_DEFAULT),
                $avatar,
                $id
            ]);
        } else {
            $stmt = $db->prepare("UPDATE users SET username = ?, email = ?, avatar = ? WHERE id = ?");
            return $stmt->execute([
                $username,
                $email,
                $avatar,
                $id
            ]);
        }
    }
}
