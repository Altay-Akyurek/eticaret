<?php
namespace App\Models;

use app\core\Database;

class ProductModel
{
    public function getAll()
    {
        $db=Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    public function getById($id)
    {
        $db=Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }
}
?>