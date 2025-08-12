<?php
namespace App\Controllers;

use app\core\View;
use app\Help\Validation;
use app\Help\Upload;

class UserController
{
    public function register()
    {
        if($_SERVER['REQUEST_METHOD'] == "POST")
        {
            $username=$_POST["username"]??'';
            $email=$_POST['email']??'';
            $avatar=$_FILES['avatar']?? null;
            
            $errors = [];
            if(!Validation::minLength($username,3))
                {
                    $errors[] = 'Kullıcı adı en az 3 karakter olmalı';
                }
            if(!Validation::isEmail($email))
                {
                    $errors[] = 'Geçerli bir e-posta girdiniz';
                }
            $avatarResult=null;
            if($avatar && $avatar['error']==0)
                {
                    $avatarResult=Upload::uploadImage($avatar,__DIR__.'/../../public/assets/uploads');
                    if(!$avatarResult['success'])
                        {
                            $errors[] = $avatarResult['error'];
                        }
                }
                if(empty($errors))
                    {
                        View::render('register_success',[
                            'username'=> $username,
                            'email'=> $email,
                            'avatar'=> $avatarResult['filename'] ?? null
                        ]);

                    }else{
                        View::render('register',[
                            'errors'=>$errors
                        ]);
                    }
        }else{
            View::render('register');
        }
    }
}
?>