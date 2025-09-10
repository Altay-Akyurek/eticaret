<?php
namespace App\Models;

use App\Core\Database;

class AdminModel
{
    protected $db;

    public function __construct()
    {
        // Database singleton kullan
        $this->db = Database::getInstance();
    }

    /**
     * Giriş işlemi için admini kontrol eder
     * @param string $username
     * @param string $password
     * @return array|false
     */
    public function login($username, $password)
    {
        $admin = $this->getByUsername($username);

        if ($admin && password_verify($password, $admin['password'])) {
            return $admin;
        }

        return false;
    }

    /**
     * Admini kullanıcı adına göre getirir
     * @param string $username
     * @return array|false
     */
    public function getByUsername($username)
    {
        $stmt = $this->db->prepare("SELECT * FROM admins WHERE username = :username");
        $stmt->execute(['username' => $username]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * Tüm adminleri listele
     */
    public function getAll()
    {
        $stmt = $this->db->query("SELECT * FROM admins");
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * Admin ekle
     */
    public function add($username, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO admins (username, password) VALUES (?, ?)");
        return $stmt->execute([
            $username,
            password_hash($password, PASSWORD_DEFAULT)
        ]);
    }

    /**
     * Admin sil
     */
    public function delete($id)
    {
        $stmt = $this->db->prepare("DELETE FROM admins WHERE id = ?");
        return $stmt->execute([$id]);
    }

    /**
     * Admin güncelle
     */
    public function update($id, $username, $password = null)
    {
        if ($password) {
            $stmt = $this->db->prepare("UPDATE admins SET username = ?, password = ? WHERE id = ?");
            return $stmt->execute([
                $username,
                password_hash($password, PASSWORD_DEFAULT),
                $id
            ]);
        } else {
            $stmt = $this->db->prepare("UPDATE admins SET username = ? WHERE id = ?");
            return $stmt->execute([$username, $id]);
        }
    }
}
