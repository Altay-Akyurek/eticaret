<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Başarılı</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

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

        .success-container {
            background: rgba(255, 255, 255, 0.95);
            padding: 40px 50px;
            border-radius: 15px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.2);
            text-align: center;
            max-width: 450px;
            width: 100%;
            animation: fadeIn 1s ease;
        }

        .success-container h2 {
            color: #27ae60;
            margin-bottom: 20px;
            font-size: 28px;
        }

        .success-container p {
            color: #333;
            font-size: 16px;
            margin-bottom: 15px;
        }

        .success-container img {
            margin-top: 10px;
            border-radius: 10px;
            max-width: 200px;
            border: 2px solid #667eea;
        }

        .success-container a {
            display: inline-block;
            margin-top: 20px;
            background: #667eea;
            color: white;
            text-decoration: none;
            padding: 12px 20px;
            border-radius: 8px;
            transition: background 0.3s ease, transform 0.2s ease;
        }

        .success-container a:hover {
            background: #764ba2;
            transform: scale(1.05);
        }

        @keyframes fadeIn {
            from {opacity: 0; transform: translateY(-20px);}
            to {opacity: 1; transform: translateY(0);}
        }
    </style>
</head>
<body>
    <div class="success-container">
        <h2>Kayıt Başarılı!</h2>
        <p>Hoş geldin, <?= htmlspecialchars($username ?? '') ?>!</p>
        <p>E-posta: <?= htmlspecialchars($email ?? '') ?></p>

        <?php if (!empty($avatar)): ?>
            <p>Profil Fotoğrafın:</p>
            <img src="/php/php_calısmaları/eticaret-main/assets/upload/<?= htmlspecialchars($avatar) ?>" 
                 alt="Avatar">
        <?php endif; ?>

        <br>
        <a href="/php/php_calısmaları/eticaret-main/auth/login/">Giriş Yap</a>
    </div>
</body>
</html>
