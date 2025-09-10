<?php
namespace App\Controllers;

use App\Models\UserModel;
use App\Core\View;
use App\Core\Auth;
use App\Help\Validation;

class AuthController
{
/*     public function login()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            header('Content-Type: application/json');

            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $errors = [];

            if (!Validation::isEmail($email)) {
                $errors[] = 'Geçerli bir e-posta giriniz.';
            }
            if (!Validation::minLength($password, 6)) {
                $errors[] = 'Şifre en az 6 karakter olmalı.';
            }

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->getByEmail($email);

                // DEBUG: Giriş denemesini logla
                file_put_contents('debug.txt', json_encode([
                    'girilen_email' => $email,
                    'veritabanı_kullanıcı' => $user,
                    'şifre' => $password,
                    'eşleşme' => $user ? password_verify($password, $user['password']) : 'kullanıcı yok'
                ]));

                if ($user) {
                    if (password_verify($password, $user['password'])) {
                        Auth::login($user['id']);
                        echo json_encode([
                            'success' => true,
                            'redirect' => '/php/php_calısmaları/eticaret-main/home'
                        ]);
                        return;
                    } else {
                        $errors[] = 'Kullanıcı adı veya şifre yanlış.';
                    }
                } else {
                    $errors[] = 'Bu e-posta adresiyle kayıtlı kullanıcı bulunamadı.';
                }
            }

            echo json_encode([
                'success' => false,
                'errors' => $errors
            ]);
            return;
        }

        View::render('login');
    }
 */
public function login()
    {
        if (session_status() === PHP_SESSION_NONE) 
            {
                session_start();
            }

        // Zaten login ise yönlendir
        if (!empty($_SESSION['user_logged'])) {
            $response = ["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/home"];
            if ($this->isAjax()) {
                echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/home"]);
                exit;
            }
        echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/public/home"]);
            exit;
        }

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';

            if (!$email) $errors[] = "Email girin.";
            if (!$password) $errors[] = "Şifre girin.";

            if (empty($errors)) {
                $userModel = new UserModel();
                $user = $userModel->getByEmail($email);

                if ($user && password_verify($password, $user['password'])) {
                    $_SESSION['user_logged'] = $user['id'];

                    if ($this->isAjax()) {
                    echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/home"]);
                        exit;
                    }

                header("Location: /php/php_calısmaları/eticaret-main/home");
                    exit;
                } else {
                    $errors[] = "Kullanıcı emaili veya şifre yanlış.";
                }
            }

            if ($this->isAjax()) {
                echo json_encode(["success" => false, "errors" => $errors]);
                exit;
            }
        }

        View::render('/login', ['errors' => $errors]);
    }

    public function logout()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        unset($_SESSION['user_logged']);
        header('Location: /php/php_calısmaları/eticaret-main/auth/login');
        exit;
    }

    private function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}