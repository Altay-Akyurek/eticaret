<?php
// Hata gösterimi (sadece geliştirme ortamında)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Session zaten aktifse tekrar başlatma
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// $errors tanımlı değilse boş dizi yap
$errors = $errors ?? [];

// CSRF token yoksa üret
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
$csrf_token = $_SESSION['csrf_token'];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kayıt Ol</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(to right, #667eea, #764ba2);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: 0;
        }

        .register-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            width: 100%;
            max-width: 450px;
            text-align: center;
            animation: fadeIn 1s ease;
        }

        .register-container h2 {
            margin-bottom: 25px;
            color: #333;
            font-size: 28px;
        }

        .error-list {
            text-align: left;
            margin-bottom: 15px;
        }
        .error-list li {
            color: #e74c3c;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .register-container input[type="text"],
        .register-container input[type="email"],
        .register-container input[type="password"],
        .register-container input[type="file"] {
            width: 100%;
            padding: 12px 15px;
            margin: 8px 0 20px 0;
            border: 1px solid #ccc;
            border-radius: 8px;
            transition: all 0.3s ease;
        }
        .register-container input:focus {
            border-color: #667eea;
            box-shadow: 0 0 5px #667eea;
            outline: none;
        }

        .register-container button {
            background: #667eea;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 8px;
            cursor: pointer;
            font-size: 16px;
            width: 100%;
            transition: background 0.3s ease, transform 0.2s ease;
        }
        .register-container button:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        .register-container a {
            display: block;
            margin-top: 15px;
            color: #667eea;
            text-decoration: none;
            transition: color 0.3s ease;
        }
        .register-container a:hover {
            color: #764ba2;
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h2>Kayıt Ol</h2>

        <?php if (!empty($errors)): ?>
            <ul class="error-list">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

        <form action="/php/php_calısmaları/eticaret-main/register/store" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token) ?>">

            <input type="text" name="username" placeholder="Kullanıcı Adı" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required>
            <input type="email" name="email" placeholder="E-Posta" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required>
            <input type="password" name="password" placeholder="Şifre" required>
            <input type="password" name="password_confirm" placeholder="Şifre Tekrar" required>
            

            <button type="submit">Kayıt Ol</button>
        </form>

        <a href="/php/php_calısmaları/eticaret-main/auth/login/">Zaten hesabınız var mı? Giriş Yap!</a>
    </div>
</body>
</html>
