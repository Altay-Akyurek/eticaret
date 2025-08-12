<?php
namespace App\Controllers;

use App\models\UserModel;
use App\core\View;
use App\core\Auth;
use App\Help\Validation;

class AuthController
{
    public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $errors = [];
            if (!Validation::isEmail($email)) $errors[] = 'Geçerli bir e-posta giriniz.';
            if (!Validation::minLength($password, 6)) $errors[] = 'Şifre en az 6 karakter olmalı.';

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->getByEmail($email);
                if ($user && password_verify($password, $user['password'])) {
                    Auth::login($user['id']);
                    header('Location: /home/index');
                    exit;
                } else {
                    $errors[] = 'Kullanıcı adı veya şifre yanlış.';
                }
            }
            View::render('login', ['errors' => $errors]);
        } else {
            View::render('login');
        }
    }

    public function logout()
    {
        Auth::logout();
        header('Location: /auth/login');
        exit;
    }
}