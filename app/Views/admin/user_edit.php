<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kullanıcı Düzenle</title>
    <style>
        body { font-family: Arial, sans-serif; background:#f7f9fc; padding:30px; }
        h2 { text-align:center; color:#333; margin-bottom:20px; }
        form { max-width:400px; margin:auto; padding:25px; background:#fff; border-radius:12px; box-shadow:0 4px 15px rgba(0,0,0,0.1); }
        label { display:block; margin-top:15px; margin-bottom:5px; font-weight:bold; }
        input[type="text"], input[type="email"] { width:100%; padding:10px; border-radius:8px; border:1px solid #ccc; box-sizing:border-box; }
        input:focus { outline:none; border-color:#4a90e2; box-shadow:0 0 5px rgba(74,144,226,0.5); }
        button { margin-top:20px; width:100%; padding:12px; background:#4a90e2; border:none; color:white; font-size:16px; font-weight:bold; border-radius:8px; cursor:pointer; }
        button:hover { background:#357abd; }
    </style>
</head>
<body>
    <h2>Kullanıcı Düzenle</h2>
    <form id="editUserForm">
        <label>Kullanıcı Adı:</label>
        <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>

        <label>Email:</label>
        <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>

        <button type="submit">Güncelle</button>
    </form>

    <script>
        const form = document.getElementById('editUserForm');
        form.addEventListener('submit', function(e){
            e.preventDefault();
            const formData = new FormData(this);

            fetch('/php/php_calısmaları/eticaret-main/public/admin/editOrUpdateUser/edit/<?= $user['id'] ?>', {
                method:'POST',
                body: formData,
                headers: { 'X-Requested-With':'XMLHttpRequest' }
            })
            .then(res=>res.json())
            .then(data=>{
                if(data.success){
                    alert('Kullanıcı güncellendi');
                    location.href='/php/php_calısmaları/eticaret-main/public/admin/dashboard';
                } else {
                    alert('Güncelleme başarısız: ' + (data.msg || ''));
                }
            }).catch(err=>console.error(err));
        });
    </script>
</body>
</html>
