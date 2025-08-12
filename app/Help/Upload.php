<?php
namespace app\Help;

class Upload
{
    public static function uploadImage($file,$destDir,$maxSize=2097152,$allowedTypes=['image/jpeg','image/png','image/webp'])
    {
        if(!isset($file['tmp_name'])||!is_uploaded_file($file['tmp_name']))
            {
                return ['success'=>false,'error'=>'Dosya Yüklenmedi.'];

            }
        if($file['size'] > $maxSize)
            {
                return ['success'=>false,'error'=> 'Dosya Boyuru Çok büyük.'];
            }
        if(!in_array($file['type'],$allowedTypes))
        {
            return ['success'=>false,'error'=> 'Dosya Türü Geçersiz'];
        }
        $ext=pathinfo($file['name'],PATHINFO_EXTENSION);
        $randomName=uniqid('img_',true).'.'.$ext;
        $uploadPath=rtrim($destDir,'/').'/'.$randomName;

        if(move_uploaded_file($file['tmp_name'],$uploadPath))
            {
                return[
                    'success'=> true,
                    'path'=>$uploadPath,
                    'filename'=>$randomName,
                    'original'=>$file['name']
                ];
            }else{
                return ['success'=>false,'error'=> 'Dosya Kaydedilmediği'];
            }

    }
}
?>