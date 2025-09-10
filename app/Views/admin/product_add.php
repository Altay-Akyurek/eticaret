<!DOCTYPE html>
<html lang="tr">
<head>
<meta charset="UTF-8">
<title>Yeni Ürün Ekle</title>
<style>
:root {
  --bg:#181818;
  --card:#232323;
  --primary:#00acc1;
  --text:#eaeaea;
  --hover:#2e2e2e;
  --border:#333;
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
</style>
</head>
<body>

<h2>Yeni Ürün Ekle</h2>
<form id="addProductForm" enctype="multipart/form-data">
  <label>Ürün Adı:</label>
  <input type="text" name="name" required>

  <label>Fiyat:</label>
  <input type="text" name="price" required>

  <label>Açıklama:</label>
  <textarea name="description"></textarea>

  <label>Stok:</label>
  <input type="number" name="stock">

  <label>Resim:</label>
  <input type="file" name="img" accept="image/*">

  <button type="submit">➕ Ekle</button>
</form>

<script>
document.getElementById('addProductForm').addEventListener('submit', function(e){
  e.preventDefault();
  let formData = new FormData(this);

  fetch('/php/php_calısmaları/eticaret-main/public/admin/addProduct', {
    method:'POST',
    body:formData,
    headers:{'X-Requested-With':'XMLHttpRequest'}
  })
  .then(res=>res.json())
  .then(data=>{
    if(data.success){
      alert('✅ Ürün başarıyla eklendi');
      location.href='/php/php_calısmaları/eticaret-main/public/admin/dashboard';
    } else {
      alert('❌ Ekleme başarısız');
    }
  }).catch(err=>console.error(err));
});
</script>

</body>
</html>
