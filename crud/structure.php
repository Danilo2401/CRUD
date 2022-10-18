<?php

require "database.php";

Class Structure extends Database{

    private $id;
    public $namecrud;
    public $surname;
    public $email;

    public function Create($namecrud,$surname,$email){

        $this->namecrud = htmlspecialchars(strip_tags($namecrud));
        $this->surname = htmlspecialchars(strip_tags($surname));
        $this->email = htmlspecialchars(strip_tags($email));

        $createQuery = "INSERT INTO tablecrud.crud(namecrud,surname,email) VALUES (:namecrud,:surname,:email)";

        $create = parent::SetConn()->prepare($createQuery);

        $create->bindParam(":namecrud",$this->namecrud);
        $create->bindParam(":surname",$this->surname);
        $create->bindParam(":email",$this->email);

        $json_outside = array();

        if (!isset($this->namecrud) || empty($this->namecrud)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif (!isset($this->surname) || empty($this->surname)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif (!isset($this->email) || empty($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif($create->execute()){
            $json_array = array(
                "status" => true,
                "message" => "You have successfully created a user!"
            );
        }

        array_push($json_outside,$json_array);
        return print_r(json_encode($json_outside));

    }

    public function Read(){

        $readQuery = "SELECT * FROM tablecrud.crud";

        $read = parent::SetConn()->prepare($readQuery);

        $read->execute();

        $json_outside = array();

        while($red = $read->fetch(PDO::FETCH_ASSOC)) {
            $json_array = array(
                "id" => $red["id"],
                "namecrud" => $red["namecrud"],
                "surname" => $red["surname"],
                "email" => $red["email"]
            );
            array_push($json_outside,$json_array);
        }

        return print_r(json_encode($json_outside));

    }

    public function Delete($id){

        $this->id = htmlspecialchars(strip_tags($id));

        $deleteQuery = "DELETE FROM tablecrud.crud WHERE id=:id";

        $delete = parent::SetConn()->prepare($deleteQuery);

        $delete->bindParam(":id",$this->id);

        $json_outside = array();

        if (!isset($this->id)) {
            $json_array = array(
                "status" => false,
                "message" => "You couldn't delete user!"
            );
        }elseif ($delete->execute()) {
            $json_array = array(
                "status" => true,
                "message" => "You have successfully deleted the user!"
            );
        }

        array_push($json_outside,$json_array);
        return print_r(json_encode($json_outside));

    }

    public function Update($id,$namecrud,$surname,$email){

        $this->id = htmlentities(strip_tags($id));
        $this->namecrud = htmlspecialchars(strip_tags($namecrud));
        $this->surname = htmlspecialchars(strip_tags($surname));
        $this->email = htmlspecialchars(strip_tags($email));

        $updateQuery = "UPDATE tablecrud.crud SET namecrud = :namecrud, surname = :surname, email = :email WHERE id = :id";

        $update = parent::SetConn()->prepare($updateQuery);

        $update->bindParam(":id",$this->id);
        $update->bindParam(":namecrud",$this->namecrud);
        $update->bindParam(":surname",$this->surname);
        $update->bindParam(":email",$this->email);

        $json_outside = array();

        if (!isset($this->namecrud)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif (!isset($this->surname)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif (!isset($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL)) {
            $json_array = array(
                "status" => false,
                "message" => "Something is wrong with your inputs!"
            );
        }elseif($update->execute()){
            $json_array = array(
                "status" => true,
                "message" => "You have successfully updated a user!"
            );
        }

        array_push($json_outside,$json_array);
        return print_r(json_encode($json_outside));

    }



}



?>