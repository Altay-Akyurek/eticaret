<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <title>Ürün Ekle</title>
</head>
<body>
    <h2>Ürün Ekle</h2>
    <form method="POST" action="#" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Ürün adı" required />
        <input type="number" step="0.01" name="price" placeholder="Fiyat" required />
        <button type="submit">Kaydet</button>
    </form>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ürün Ekleme</title>
</head>
<body>
    <h2>Ürün Ekle</h2>
    <form method="POST">
        <label>Ürün Adı:</label>
        <input type="text" name="name" required><br>
        <label>Fiyat:</label>
        <input type="number" name="price" step="0.01" required><br>
        <button type="submit">Kaydet</button>
    </form>
    <a href="../public/index.php">Geri Dön</a>
    
</body>
</html>