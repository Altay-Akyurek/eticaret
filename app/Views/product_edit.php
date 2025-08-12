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