<?php

class Database{

    private $host = "localhost";
    private $dbname = "tablecrud";
    private $user = "root";
    private $password = "";
    private $conn;

    public function SetConn(){

        $this->conn = null;

        try {
            $this->conn = new PDO("mysql:host=$this->host;dbname=$this->dbname",$this->user,$this->password);
        }catch (PDOException $e) {
            echo $e->getMessage();
            die();
        }

        return $this->conn;

    }

}




?>