<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\ProductModel;

class CartController
{
public function bulkOrder()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $products = [];

        // 1. JSON gövdesini oku
        $input = file_get_contents("php://input");
        if (!empty($input)) {
            $data = json_decode($input, true);
            if (json_last_error() === JSON_ERROR_NONE) {
                $products = $data['products'] ?? [];
            }
        }

        // 2. Eğer JSON boşsa POST parametresinden dene
        if (empty($products) && isset($_POST['products'])) {
            $products = $_POST['products'];
        }

        // Kontrol
        if (empty($products)) {
            echo json_encode([
                'status' => false,
                'message' => 'Ürün listesi boş.'
            ]);
            return;
        }

        $model = new ProductModel();
        $errors = [];

        foreach ($products as $urun) {
            $id = $urun['id'];
            $adet = $urun['adet'];
            $name = $urun['name'];
            $price = $urun['price'];
            $total = $price * $adet * 1.20;

            // Stok azalt
            $result = $model->reduceStock($id, $adet);
            if (!$result['success']) {
                $errors[] = "Stok yetersiz: {$name}";
                continue;
            }

            // Sepetten çıkar
            unset($_SESSION['cart'][$id]);

        }

        $_SESSION['cart_count'] = array_sum($_SESSION['cart'] ?? []);

        if (!empty($errors)) {
            echo json_encode([
                'status' => false,
                'message' => implode("<br>", $errors)
            ]);
        } else {
            echo json_encode([
                'status' => true,
                'message' => 'Sipariş başarıyla verildi.'
            ]);
        }
    }
}



    //+ ve - bölümünde Güncelleme
    public function update()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $id = $_POST['id'] ?? null;
        $adet = $_POST['adet'] ?? null;

        if ($id !== null && $adet !== null) {
            $adet = max(1, (int)$adet); // minimum 1 adet
            $_SESSION['cart'][$id] = $adet;
            $_SESSION['cart_count'] = array_sum($_SESSION['cart']);

            echo json_encode([
                'status' => true,
                'message' => 'Sepet güncellendi',
                'cart_count' => $_SESSION['cart_count']
            ]);
        } else {
            echo json_encode([
                'status' => false,
                'message' => 'Eksik veri'
            ]);
        }
        exit;
    }
}

    public function index()
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        $cart = $_SESSION['cart'] ?? [];
        $productModel = new ProductModel();
        $cartProducts = [];

        foreach ($cart as $id => $adet) {
            $urun = $productModel->getById($id);
            if ($urun) {
                $urun['adet'] = $adet;
                $cartProducts[] = $urun;
            }
        }

        View::render('cart', [
            'cart' => $cartProducts,
            'cart_count' => array_sum($cart)
        ]);
    }

    public function add($id)
    {
        if (session_status() === PHP_SESSION_NONE) session_start();

        if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];

        $_SESSION['cart'][$id] = ($_SESSION['cart'][$id] ?? 0) + 1;
        $_SESSION['cart_count'] = array_sum($_SESSION['cart']);

        if ($this->isAjax()) {
            header('Content-Type: application/json');
            echo json_encode(['success' => true, 'cart_count' => $_SESSION['cart_count']]);
            exit;
        }

        header('Location: /php/php_calısmaları/eticaret-main/cart');
        exit;
    }

 public function remove()
{
    if (session_status() === PHP_SESSION_NONE) session_start();

    $id = $_POST['id'] ?? null;

    if ($id && isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
        $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Ürün bulunamadı']);
    }
    exit;
}

    public function order()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (session_status() === PHP_SESSION_NONE) session_start();

            $id = $_POST['id'] ?? 0;
            $adet = $_SESSION['cart'][$id] ?? 1;

            $model = new ProductModel();
            $result = $model->reduceStock($id, $adet);

            if ($result['success']) {
                unset($_SESSION['cart'][$id]);
                $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
                echo json_encode(['status' => true, 'message' => 'Sipariş başarıyla verildi.']);
            } else {
                echo json_encode(['status' => false, 'message' => $result['message'] ?? 'Stok yetersiz.']);
            }
            exit;
        }
    }

    private function isAjax()
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) &&
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }
}
