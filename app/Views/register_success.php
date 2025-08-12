<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <title>Kayıt Başarılı!</title>
</head>
<body>
    <h2>Kayıt Başarılı!</h2>
    <p>Hoşgeldin <?= htmlspecialchars($username) ?>!</p>
    <p>E-posta: <?= htmlspecialchars($email) ?></p>
    <?php if (!empty($avatar)): ?>
        <img src="/assets/upload/<?= htmlspecialchars($avatar) ?>" alt="Profil Foto" width="120">
    <?php endif; ?>
    <br>
    <a href="/login">Giriş Yap</a>
</body>
</html>
