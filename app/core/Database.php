<?php
namespace App\Core;

use PDO;
use PDOException;
/* use ifadesi, PHP’de başka bir isim alanından 
(namespace) veya global alandan sınıf,
 fonksiyon ya da sabitleri kolayca 
 kullanmak için yazılır. */

class Database {
    private static $instance = null;
    private $pdo;

    private function __construct() {
        $host= $_ENV['DB_HOST'];
        $db= $_ENV['DB_NAME'];
        $user= $_ENV['DB_USER'];
        $pass= $_ENV['DB_PASS'];

        try {
            $this->pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }catch(PDOException $e){
            die("Veritabanı Bağlantı Hatası:". $e->getMessage());

        }
    }
    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new self();
        }
        return self::$instance->pdo;
    }
}
?>