<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Ürün Düzenle</title>
<style>
:root {
  --bg:#181818;
  --card:#232323;
  --primary:#00acc1;
  --text:#eaeaea;
  --hover:#2e2e2e;
  --border:#333;
  --danger:#ff5252;
  --input-bg:linear-gradient(145deg,#1a1a1a,#202020);
}

* { box-sizing: border-box; }

body {
  font-family: 'Segoe UI', sans-serif;
  background: var(--bg);
  color: var(--text);
  margin: 0;
  padding: 40px;
}

h2 {
  color: var(--primary);
  margin-bottom: 20px;
  border-bottom: 1px solid var(--border);
  padding-bottom: 5px;
  text-align: center;
  font-size: 26px;
  letter-spacing: 0.5px;
}

form {
  max-width: 600px;
  margin: auto;
  background: var(--card);
  padding: 30px;
  border-radius: 12px;
  box-shadow: 0 8px 24px rgba(0,0,0,0.5);
  transition: box-shadow 0.3s ease;
}

form:hover {
  box-shadow: 0 12px 32px rgba(0,0,0,0.6);
}

label {
  display: block;
  margin-top: 20px;
  margin-bottom: 8px;
  font-weight: 600;
  color: var(--text);
}

input[type="text"],
input[type="number"],
input[type="file"],
textarea {
  width: 100%;
  padding: 12px;
  border-radius: 8px;
  border: 1px solid var(--border);
  background: var(--input-bg);
  color: var(--text);
  font-size: 15px;
  transition: border-color 0.3s, box-shadow 0.3s;
}

input:focus,
textarea:focus {
  outline: none;
  border-color: var(--primary);
  box-shadow: 0 0 10px rgba(0,188,212,0.4);
}

button {
  margin-top: 30px;
  width: 100%;
  padding: 14px;
  background-color: var(--primary);
  border: none;
  color: #fff;
  font-size: 16px;
  font-weight: bold;
  border-radius: 8px;
  cursor: pointer;
  transition: background-color 0.3s, transform 0.2s;
}

button:hover {
  background-color: #0097a7;
  transform: scale(1.02);
}

img {
  margin-top: 12px;
  border-radius: 8px;
  border: 1px solid var(--border);
  max-width: 160px;
  max-height: 160px;
  display: block;
}

p.note {
  color: #aaa;
  font-size: 14px;
  font-style: italic;
}

/* Responsive başlangıcı */
@media(max-width: 640px){
  body { padding: 20px; }
  form { padding: 20px; }
}
</style>
</head>
<body>

<h2>Ürün Düzenle</h2>
<?php $imgPath = !empty($product['img']) ? "assets/upload/" . $product['img'] : null; ?>
<form id="editProductForm" enctype="multipart/form-data">
  <label>Ürün Adı:</label>
  <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required>

  <label>Fiyat:</label>
  <input type="text" name="price" value="<?= htmlspecialchars($product['price']) ?>" required>

  <label>Açıklama:</label>
  <textarea name="description"><?= htmlspecialchars($product['description']) ?></textarea>

  <label>Stok:</label>
  <input type="number" name="stock" value="<?= htmlspecialchars($product['stock']) ?>">

  <label>Mevcut Resim:</label>
  
<img src="/php/php_calısmaları/eticaret-main/public/assets/upload/<?= htmlspecialchars($product['img']) ?>" alt="<?= htmlspecialchars($product['name']) ?>">

  <label>Yeni Resim Yükle:</label>
  <input type="file" name="img" accept="image/*">

  <button type="submit">💾 Güncelle</button>
</form>

<script>
const form = document.getElementById('editProductForm');
form.addEventListener('submit', function(e){
  e.preventDefault();
  const formData = new FormData(this);

  fetch('/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateProduct/edit/<?= $product['id'] ?>', {
    method:'POST',
    body: formData,
    headers: { 'X-Requested-With':'XMLHttpRequest' }
  })
  .then(res => res.json())
  .then(data => {
    if(data.success){
      alert('✅ Ürün başarıyla güncellendi');
      location.href='/php/php_calısmaları/eticaret-main/public/admin/dashboard';
    } else {
      alert('❌ Güncelleme başarısız: ' + (data.msg || ''));
    }
  }).catch(err => console.error(err));
});
</script>

</body>
</html>
