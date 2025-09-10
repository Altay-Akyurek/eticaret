<?php
namespace App\Controllers;

use App\Core\View;
use App\Models\ProductModel;
use App\Models\UserModel;
use App\Models\AdminModel;

class AdminController
{
    private function checkAuth()//oturum acıkmı yokse değilmi bir sessiyon yapıyoruz 
    {
        if (session_status() === PHP_SESSION_NONE) session_start();
        if (empty($_SESSION['admin_logged'])) {
            header('Location: /php/php_calısmaları/eticaret-main/admin/login');
            exit;
        }
    }

    private function isAjax()//ajax başlatmak için yönleledirici codelar 
    {
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    // Dosya upload fonksiyonu
    private function handleImageUpload($oldImg = null)
    {
        if (!empty($_FILES['img']['tmp_name'])) {
            $uploadDir = __DIR__ . '/../../public/assets/upload/';
            $filename = uniqid() . '_' . basename($_FILES['img']['name']);
            $targetPath = $uploadDir . $filename;

            // Uzantı kontrolü
            $allowed = ['jpg','jpeg','png','gif','webp'];//uzantı kotrolü  yapıyor bunun dışında yüklenen uzantılar kabul edilmcek
            $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
            if (!in_array($ext, $allowed)) {
                return ['error' => "Sadece resim dosyası yükleyebilirsiniz!"];
            }

            if (move_uploaded_file($_FILES['img']['tmp_name'], $targetPath)) {
                // Eski resim silinsin mi? İstersen açabilirsin:
                // if ($oldImg && file_exists($uploadDir . $oldImg)) unlink($uploadDir . $oldImg);
                return ['filename' => $filename];
            } else {
                return ['error' => "Resim yüklenemedi!"];
            }
        }
        // Yeni resim yoksa eskisini koru
        return ['filename' => $oldImg];//oldImg ile eski resmi bir değişkenin içine aldık eger resim yokse bu değişkeni kullanıcak
    }

    public function dashboard()
    {
        $this->checkAuth();//giriş kotrolu yapıldı
        $productModel = new ProductModel();//ProductModel'i prductmodel ile bir değişkenin içine tammaladık
        $userModel    = new UserModel();//UserModel'i usermodel ile bir değişkenin içine tammaladık

        $products = $productModel->getAll();//productModel'de products yani verileri cekmek için olşturduğumuz farklı veri
        $users    = $userModel->getAll();

        View::render("admin/dashboard", [
            "products" => $products,
            "users"    => $users
        ]);
    }

    public function deleteUser($action, $id)//kulllancı silme Bölümü 
    {
        $this->checkAuth();//admin giş yapılmışmı kotrol yapılıyor
        if ($action === 'delete' && is_numeric($id)) {//eger delete type girilirse modelde delete ile yeniden adlandırılmış olan deleteUser fonksiyonu kulanılır
            $userModel = new UserModel();//UserModel Çağrılır ve userModel olarak bir değişkene yonlendirilir
            if ($userModel->deleteUser((int)$id)) {//userModel deki deleteUser fonksiyonuna getirilir
                if($this->isAjax()){ echo json_encode(["success"=>true]); exit; }//ajax ile delete fonksiyonu çalıştırılır 
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=user_deleted");//var olunan Locations ta silindiğine dair bir mesaj verilir 
            } else {
                if($this->isAjax()){ echo json_encode(["success"=>false,"errors"=>["Kullanıcı silinemedi"]]); exit; }//eğer silme işeminde hata verirse Locations bir uyarı mesajı göndermesini istiyoruz ve kullanıcının silinemediğini soylüyoruz 
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=error");
            }
        } else {
            if($this->isAjax()){ echo json_encode(["success"=>false,"errors"=>["Geçersiz istek"]]); exit; }//web sayfamız da birden cok seçenek koyarak silme işlemi yapıcamız zaman uyarı vermesi için yönledirdildi
            header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=invalid_request");//
        }
        exit();
    }
//ürün silme yönlendirme code kısmı!
    public function deleteProduct($action, $id)//delete fonkisyonu olşuşturudum
    {
        $this->checkAuth();//kullanıcı girşi  yapılmışmı kotrol ettik
        if ($action === 'delete' && is_numeric($id)) {//ProductModelten delete type çağırdık
            $model = new ProductModel();//ProductModel bir model olarka değişkene atadık
            if ($model->deleteProduct((int)$id)) {//model in içinde deleteProduct fon. çağırdık
                if($this->isAjax()){ echo json_encode(["success"=>true]); exit; }
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=product_deleted");//silindiğine dair mesaj oluşturuldu 
            } else {
                if($this->isAjax()){ echo json_encode(["success"=>false,"errors"=>["Ürün silinemedi"]]); exit; }
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=error");
            }
        } else {
            if($this->isAjax()){ echo json_encode(["success"=>false,"errors"=>["Geçersiz istek"]]); exit; }
            header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=invalid_request");
        }
        exit();
    }

    // Ürün güncelleme ve dosya yükleme
    public function editOrUpdateProduct($action, $id)
    {
        $this->checkAuth();//kullanıcı kontrol 

        if ($action === 'edit' && is_numeric($id)) {//edit type cekildi
            $productModel = new ProductModel();//ProductModel cağrıldı
            $id = (int)$id;

            if ($_SERVER['REQUEST_METHOD'] === 'POST') {//edit kısmında çalışıcak ve POST olarak alınacak yerler server da hafızada biriktirdi
                $name        = trim($_POST['name'] ?? '');
                $price       = trim($_POST['price'] ?? '');
                $description = trim($_POST['description'] ?? '');
                $stock       = trim($_POST['stock'] ?? '');

                $errors = [];//zorunlu alan kuruldu
                if ($name === '' || $price === '') {
                    $errors[] = "İsim ve fiyat alanı boş olamaz";
                }
                // Mevcut ürün
                $oldProduct = $productModel->getById($id);//id ile istenilen product getirildi 
                $oldImg = $oldProduct ? $oldProduct['img'] : null;//eski resnş varmı yokmu kotrol edilde

                // Resim yükleme/güncelleme
                $uploadResult = $this->handleImageUpload($oldImg);//oldProduct daki oldImg ile yüklendi ve yüklenicek resimi aldık
                if (isset($uploadResult['error'])) { $errors[] = $uploadResult['error']; }//set edilmediyse error verilecek
                $img = $uploadResult['filename'];//img değişkenini dosyalardan seçilecek +

                if (!empty($errors)) {
                    if ($this->isAjax()) {
                        echo json_encode(["success" => false, "errors" => $errors]);
                        exit;
                    }
                    header("Location: /php/php_calısmaları/eticaret-main/public/admin/editOrUpdateProduct/edit/$id?msg=missing_fields");
                    exit;
                }
                $updated = $productModel->update($id, [
                    'name'        => $name,
                    'price'       => $price,
                    'description' => $description,
                    'stock'       => $stock,
                    'img'         => $img
                ]);
               if ($this->isAjax()) {
                header('Content-Type: application/json; charset=utf-8');
                $updatedProduct = $productModel->getById($id);
                echo json_encode([
                    "success" => (bool)$updated,
                    "data"    => $updatedProduct
                ]);
                exit;
                }
                if ($updated) {
                    header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=product_updated");
                } else {
                    header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard/edit/$id?msg=update_failed");
                }
                exit();
            }

            // GET: form gösterimi
            $product = $productModel->getById($id);
            if (!$product) {
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=product_not_found");
                exit;
            }
            View::render("admin/product_edit", ["product" => $product]);
        } else {
            header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=invalid_request");
            exit;
        }
    }

public function editOrUpdateUser($action, $id)
{
    $this->checkAuth();
    if ($action === 'edit' && is_numeric($id)) {
        $userModel = new UserModel();
        $id = (int)$id;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST["username"] ?? '');
            $email    = trim($_POST['email'] ?? '');

            $errors = [];
            if ($username === '' || $email === '') {
                $errors[] = "Kullanıcı adı ve email boş olamaz";
            }

            if (!empty($errors)) {
                if ($this->isAjax()) {
                    echo json_encode(["success" => false, "errors" => $errors]);
                    exit;
                }
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/editOrUpdateUser/edit/$id?msg=missing_fields");
                exit;
            }

            $updated = $userModel->update($id, $username, $email, null, null);

            // ✨ AJAX için data ekledim:}] burayı unutmaaaaaa Hewr fun. controllerde ajax olmalı :...
            if ($this->isAjax()) {
                echo json_encode([
                    "success" => $updated,
                    "data" => [
                        "username" => $username,
                        "email" => $email
                    ]
                ]);
                exit;
            }

            if ($updated) {
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=user_updated");
            } else {
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/editOrUpdateUser/edit/$id?msg=update_failed");
            }
            exit();
        }

        $user = $userModel->getById($id);
        if (!$user) {
            header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=user_not_found");
            exit;
        }

        View::render("admin/user_edit", ["user" => $user]);
    } else {
        header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=invalid_request");
        exit;
    }
}

    // Ürün ekleme + dosya yükleme
    public function addProduct()
    {
        $this->checkAuth();
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $name = trim($_POST['name'] ?? '');
            $price = trim($_POST['price'] ?? '');
            $description = trim($_POST['description'] ?? '');
            $stock = trim($_POST['stock'] ?? '');

            $errors = [];
            if ($name === '' || $price === '') {
                $errors[] = "İsim ve fiyat boş olamaz";
            }

            // Resim yükleme işlemi
            $uploadResult = $this->handleImageUpload();
            if (isset($uploadResult['error'])) { $errors[] = $uploadResult['error']; }
            $img = $uploadResult['filename'];

            if (!empty($errors)) {
                if ($this->isAjax()) {
                    echo json_encode(["success" => false, "errors" => $errors]);
                    exit;
                }
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/addProduct?msg=missing_fields");
                exit;
            }

            $productModel = new ProductModel();
            $created = $productModel->create([
                'name' => $name,
                'price' => $price,
                'description' => $description,
                'stock' => $stock,
                'img' => $img
            ]);

            if ($this->isAjax()) {
                echo json_encode(["success" => $created]);
                exit;
            }

            if ($created) {
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/dashboard?msg=product_added");
            } else {
                header("Location: /php/php_calısmaları/eticaret-main/public/admin/addProduct?msg=add_failed");
            }
            exit();
        }

        View::render("admin/product_add");
    }
}