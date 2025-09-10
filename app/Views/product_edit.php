<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ürün Düzenle</title>
</head>
<body>
    <h2>Ürün Düzenle</h2>
    <form method="POST" action="#">
        <input type="text" name="name" value="<?= htmlspecialchars(($product['name'] ?? '') ) ?>" />
        <input type="number" step="0.01" name="price" value="<?= htmlspecialchars(($product['price'] ?? '') ) ?>" />
        <button type="submit">Güncelle</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Düzenleme</title>
</head>
<body>
    <h2>Ürün Düzenleme</h2>
    <form method="POST">
        <label>Fiyat:</label>
        <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($product['price'])?>" required><br>
        <button type="submit">Güncelle</button>
    </form>
    <a href="../public/index.php"></a>
    
</body>
</html>