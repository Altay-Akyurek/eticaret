<?php
// Hata gösterimi (geliştirme ortamında)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $errors değişkeni tanımlı değilse boş dizi yap
$errors = $errors ?? [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Giriş</title>
    <style>
        /* Genel body stili */
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #121212;
            color: #fff;
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        /* Form kutusu */
        .login-container {
            background: #1f1f1f;
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.7);
            width: 100%;
            max-width: 400px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        /* Başlık */
        .login-container h2 {
            margin-bottom: 25px;
            color: #fff;
            font-size: 28px;
        }

        /* Hata mesajları */
        .error-list {
            text-align: left;
            margin-bottom: 15px;
        }
        .error-list li {
            color: #e74c3c;
            margin-bottom: 5px;
            font-weight: bold;
        }

        /* Input alanları */
        .login-container input[type="text"],
        .login-container input[type="password"] {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 20px 0;
            border: 1px solid #333;
            border-radius: 8px;
            background: #2b2b2b;
            color: #fff;
            transition: all 0.3s ease;
        }
        .login-container input:focus {
            border-color: #4caf50;
            box-shadow: 0 0 5px #4caf50;
            outline: none;
        }

        /* Buton */
        .login-container button {
            background: #4caf50;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .login-container button:hover {
            background: #43a047;
            transform: scale(1.05);
        }

        /* Animasyon */
        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }

        /* Link */
        .login-container a {
            display: block;
            margin-top: 15px;
            color: #4caf50;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .login-container a:hover {
            color: #43a047;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Admin Giriş</h2>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

<!-- $.AJAX YERİNE BUNU KULLANDIK -->
        <form id="loginForm" method="POST" action="/php/php_calısmaları/eticaret-main/admin/login">
        <input type="text" name="username" placeholder="Kullanıcı Adı" required>
        <input type="password" name="password" placeholder="Şifre" required>
        <button type="submit">Giriş Yap</button>
    </form>

    <div id="response"></div>

    <script>
    document.getElementById("loginForm").addEventListener("submit", function(e) {
    e.preventDefault(); // sayfanın yenilenmesini engelle

    let form = this;
    let formData = new FormData(form);

    fetch(form.action, {
        method: "POST",
        body: formData,
        headers: { 'X-Requested-With': 'XMLHttpRequest' } // AJAX olduğunu belirt
    })
    .then(response => response.json())
    .then(res => {
        if(res.success && res.redirect){
            window.location.href = res.redirect; // başarılıysa yönlendir 
        } else if(res.errors){
            document.getElementById("response").innerHTML = res.errors.join("<br>");
        }
    })
    .catch(error => console.error("Hata:", error));
});

    </script>
</body>
</html>
