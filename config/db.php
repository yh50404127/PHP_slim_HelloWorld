<?php


//資料庫連接
class DB {
    private $host = 'localhost';
    private $user = 'root';
    private $pass = '';
    private $dbname = 'myschool2';

    public function connect(){
        $conn_str = "mysql:host=$this->host;dbname=$this->dbname";
        $conn = new PDO($conn_str, $this->user, $this->pass);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return $conn;
     }
    
}