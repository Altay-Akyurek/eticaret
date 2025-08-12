<!DOCTYPE html>
<html>
<head>
    <title>Kayıt Ol | TrendYolClone</title>
</head>
<body>
    <h2>Kayıt Ol</h2>
    <?php if (!empty($errors)): ?>
        <ul>
            <?php foreach ($errors as $err): ?>
                <li style="color:red"><?= htmlspecialchars($err) ?></li>
            <?php endforeach; ?>
        </ul>
    <?php endif; ?>
    <?php
    session_start();
    if (empty($_SESSION['csrf_token'])) {
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    ?>

        <form action="/eticaret/public/register/store" method="POST" enctype="multipart/form-data">
            <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?>">

            <label>Kullanıcı Adı:</label>
            <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required><br>

            <label>E-posta:</label>
            <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>" required><br>

            <label>Şifre:</label>
            <input type="password" name="password" required><br>

            <label>Şifre Tekrar:</label>
            <input type="password" name="password_confirm" required><br>

            <label>Profil Resmi:</label>
            <input type="file" name="avatar" accept=".jpg,.jpeg,.png,.webp"><br>

            <button type="submit">Kayıt Ol</button>
        </form>
</body>
</html>
