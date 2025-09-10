<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Core\View;

class RegisterController
{
    public function store()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $username = trim($_POST['username'] ?? '');
        $email    = trim($_POST['email'] ?? '');
        $password = $_POST['password'] ?? '';
        $avatar   = null;
        $errors   = [];
        $csrfToken = $_POST['csrf_token'] ?? '';

          // CSRF kontrolü
        if (empty($csrfToken) || $csrfToken !== ($_SESSION['csrf_token'] ?? '')) {
            $errors[] = "Geçersiz oturum. Lütfen formu yeniden doldurun.";
        }
        // E-posta doğrulama
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors[] = "Geçersiz e-posta adresi.";
        }

        // Şifre uzunluğu kontrolü
        if (strlen($password) < 6) {
            $errors[] = "Şifre en az 6 karakter olmalı.";
        }

        // Kullanıcı adı boş mu?
        if (empty($username)) {
            $errors[] = "Kullanıcı adı boş bırakılamaz.";
        }

        // E-posta zaten kayıtlı mı?
        $userModel = new UserModel();
        if ($userModel->getByEmail($email)) {
            $errors[] = "Bu e-posta zaten kayıtlı.";
        }

        // Hatalar varsa formu tekrar göster
        if (!empty($errors)) {
            View::render('register', ['errors' => $errors]);
            return;
        }

        // Avatar yükleme
        if (!empty($_FILES['avatar']['name']) && $_FILES['avatar']['error'] === UPLOAD_ERR_OK) {
            $safeName = uniqid() . '_' . preg_replace('/[^a-zA-Z0-9.\-_]/', '', $_FILES['avatar']['name']);
            $uploadDir = __DIR__ . '/../../public/assets/upload/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }

            move_uploaded_file($_FILES['avatar']['tmp_name'], $uploadDir . $safeName);
            $avatar = $safeName;
        }

        // Veritabanına ekle
        $userModel->add($username, $email, $password, $avatar);

        // Başarılı kayıt sayfasına yönlendir
        View::render('register_success', [
            'username' => $username,
            'email'    => $email,
            'avatar'   => $avatar
        ]);
    } else {
        View::render('register');
    }
}

}
