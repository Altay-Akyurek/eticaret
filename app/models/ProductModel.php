<?php
namespace App\Models;

use App\Core\Database;

class ProductModel
{
    public function getAll()
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products");
        $stmt->execute();
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }

    public function getById($id)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("SELECT * FROM products WHERE id=?");
        $stmt->execute([$id]);
        return $stmt->fetch(\PDO::FETCH_ASSOC);
    }

    public function deleteProduct(int $id): bool
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("DELETE FROM products WHERE id=:id");
        $stmt->bindParam(':id', $id, \PDO::PARAM_INT);
        return $stmt->execute();
    }

    // Tüm alanları güncelle
    public function update($id, $data)
    {
        $sql = "UPDATE products 
                SET name = :name, 
                    price = :price, 
                    description = :description, 
                    stock = :stock,
                    img = :img
                WHERE id = :id";

        $db = Database::getInstance();
        $stmt = $db->prepare($sql);

        return $stmt->execute([
            ':name'        => $data['name'],
            ':price'       => $data['price'],
            ':description' => $data['description'],
            ':stock'       => $data['stock'],
            ':img'         => $data['img'],
            ':id'          => $id
        ]);
    }

    // Sadece img alanını güncelle
    public function updateImg($id, $img)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("UPDATE products SET img = :img WHERE id = :id");
        return $stmt->execute([
            ':img' => $img,
            ':id'  => $id
        ]);
    }

    public function create(array $data)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("INSERT INTO products (name, price, description, stock, img) VALUES (?, ?, ?, ?, ?)");

        if ($stmt->execute([
            $data['name'],
            $data['price'],
            $data['description'],
            $data['stock'],
            $data['img']
        ])) {
            return $db->lastInsertId(); // başarılıysa id
        }

        return false; // başarısızsa false
    }

    // Stok Azaltma Fonksiyonu
    public function reduceStock($id, $amount = 1)
    {
        $db = Database::getInstance();

        $stmt = $db->prepare("SELECT stock FROM products WHERE id = ?");
        $stmt->execute([$id]);
        $urun = $stmt->fetch(\PDO::FETCH_ASSOC);

        if (!$urun) {
            return ['success' => false, 'message' => 'Ürün bulunamadı.'];
        }

        if ($urun['stock'] < $amount) {
            return ['success' => false, 'message' => 'Yeterli stok yok.'];
        }

        $stmt = $db->prepare("UPDATE products SET stock = stock - :amount WHERE id = :id");
        $stmt->execute([
            ':amount' => $amount,
            ':id'     => $id
        ]);

        return ['success' => true, 'message' => 'Stok başarıyla güncellendi.'];
    }


    // Kullanıcının sepetini çekme
    public function getCartByUser($userId)
    {
        $db = Database::getInstance();
        $stmt = $db->prepare("
            SELECT 
                c.id AS sepet_id,
                p.name AS urun_adi,
                p.price,
                c.adet,
                (p.price * c.adet) AS amount,
                u.username AS kullanici_adi
            FROM cart c
            JOIN products p ON c.urun_id = p.id
            JOIN users u ON c.kullanici_id = u.id
            WHERE c.kullanici_id = :kullanici_id
        ");
        $stmt->execute(['kullanici_id' => $userId]);
        return $stmt->fetchAll(\PDO::FETCH_ASSOC);
    }
    
    
}
?>
