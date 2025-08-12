<?php
// Hata gösterimi (sadece geliştirme ortamında)
error_reporting(E_ALL);
ini_set('display_errors', 1);

// $error değişkeni tanımlı değilse boş dizi yap
$error = $error ?? [];
?>
<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Giriş Yap</title>
</head>
<body>
    <h2>Giriş Yap</h2>

    <?php if (!empty($error)): ?>
        <ul>
            <?php foreach ($error as $err): ?>
                <li style="color:red"><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>

    <form method="POST">
        <label for="email">E-Posta:</label>
        <input type="email" id="email" name="email" required><br>

        <label for="password">Şifre:</label>
        <input type="password" id="password" name="password" required><br>

        <button type="submit">Giriş Yap</button>
    </form>

    <a href="../Views/register.php">Hesabınız Yok mu? Kayıt ol!</a>
</body>
</html>
