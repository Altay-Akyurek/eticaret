<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\AdminModel;
use App\Core\Database;

class AdminAuthController
{
  public function login()
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!empty($_SESSION['admin_logged'])) {//admin giriş yapılırsa yani veri boş değilse giriş yapılsın demek 
        if ($this->isAjax()) {
            echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/admin/dashboard"]);
            exit;
        }
        echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/public/admin/dashboard"]);

        exit;
    }

    $errors = [];

    if ($_SERVER['REQUEST_METHOD'] === 'POST') { //gönderilen veri username ve password girişi isticek 
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';

        if (!$username) $errors[] = "Kullanıcı adı girin.";//kullanıcı isimini Girmemiş se $errors ile kullanıcıya Uyarı hatası göndericek
        if (!$password) $errors[] = "Şifre girin.";//kullanıcı şifresini Girmemiş se $errors ile kullanıcıya Uyarı hatası göndericek

        if (empty($errors)) {
            $adminModel = new AdminModel();//Model kısmında DB yi kontrol edip boyle bir admin varmı diye kontrol ediyoruz 
            $admin = $adminModel->getByUsername($username);

            if ($admin && ($password === $admin['password'] || password_verify($password, $admin['password']))) {
                $_SESSION['admin_logged'] = true;

                if ($this->isAjax()) {
                    echo json_encode(["success" => true, "redirect" => "/php/php_calısmaları/eticaret-main/admin/dashboard"]);
                    exit;
                }

                header("Location: /php/php_calısmaları/eticaret-main/admin/dashboard");
                exit;
            } else {
                $errors[] = "Kullanıcı adı veya şifre yanlış.";
            }
        }

        if ($this->isAjax()) {//ajax ile bir doğru değilse uyarı gönderisiyozur
            echo json_encode(["success" => false, "errors" => $errors]);
            exit;
        }
    }

    View::render('/admin/login', ['errors' => $errors]);
}



    public function logout()
    {
        session_start();
        unset($_SESSION['admin_logged']);
        header('Location: /php/php_calısmaları/eticaret-main/admin/login');
        exit;
    }
    private function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
