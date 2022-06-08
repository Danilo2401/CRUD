<?php


Class User {

    public $name;
    public $surname;
    public $email;
    public $dbconn;
    public $id;

    function __construct($dbconn)
    {
        $this->dbconn = $dbconn;
    }

    function CreateUser($name,$surname,$email){

        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;
        
        $createUser = "INSERT INTO tablecrud.crud(namecrud,surname,email) values (:namecrud,:surname,:email)";

        $create = $this->dbconn->prepare($createUser);

        $xmlFile = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

        if(strlen($this->name) <= 2 || empty($this->name) || !isset($this->name) || !ctype_upper($this->name[0])){
            $message = $xmlFile->addChild("message","You have made a mistake!Please check your inputs again.");
        }elseif(strlen($this->surname) <= 2 || empty($this->surname) || !isset($this->surname) || !ctype_upper($this->surname[0]))
        {
            $message = $xmlFile->addChild("message","You have made a mistake!Please check your inputs again.");
        }elseif(empty($this->email) || !isset($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL))
        {
            $message = $xmlFile->addChild("message","You have made a mistake!Please check your inputs again.");
        }else{

            $create->bindParam(":namecrud",$this->name);
            $create->bindParam(":surname",$this->surname);
            $create->bindParam(":email",$this->email);
    
            $create->execute();

            $message = $xmlFile->addChild("message","You have successfully created user.");

        }

        Header("Content-type:text/xml");
        echo $xmlFile->asXML();

    }

    function ShowUser(){

        $readQuery = "SELECT id,namecrud,surname,email FROM tablecrud.crud ORDER BY namecrud ASC";

        $read = $this->dbconn->prepare($readQuery);

        $read->execute();

        $ReadXML = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><users></users>");

        if($read->rowCount() > 0){

            while($red = $read->fetch(PDO::FETCH_ASSOC)){
                $user = $ReadXML->addChild("user");
                $user->addChild("id",$red["id"]);
                $user->addChild("namecrud",$red["namecrud"]);
                $user->addChild("surname",$red["surname"]);
                $user->addChild("email",$red["email"]);
            }

        }
        
        Header("Content-type:text/xml");
        echo $ReadXML->asXML();

    }


    function DeleteUser($id){

        $this->id = $id;

        $deleteQuery = "DELETE FROM tablecrud.crud WHERE id = :id ";

        $delete = $this->dbconn->prepare($deleteQuery);

        $delete->bindParam(":id",$this->id);

        $delete->execute();

        $DeleteXML = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><delete></delete>");

        if($delete->execute()){
            $deleteUser = $DeleteXML->addChild("deleteUser","You have successfully deleted user.");
        }  

    }

    function UpdateUser($id,$name,$surname,$email){

        $this->id = $id;
        $this->name = $name;
        $this->surname = $surname;
        $this->email = $email;

        $updateQuery = "UPDATE tablecrud.crud SET namecrud=:namecrud,surname=:surname,email=:email WHERE id=:id";

        $update = $this->dbconn->prepare($updateQuery);

        $updateXML = new SimpleXMLElement("<?xml version='1.0' encoding='utf-8'?><messages></messages>");

        if(strlen($this->name) <= 2 || empty($this->name) || !isset($this->name) || !ctype_upper($this->name[0])){
            $message = $updateXML->addChild("message","You have made a mistake!Please check your inputs again.");
        }elseif(strlen($this->surname) <= 2 || empty($this->surname) || !isset($this->surname) || !ctype_upper($this->surname[0]))
        {
            $message = $updateXML->addChild("message","You have made a mistake!Please check your inputs again.");
        }elseif(empty($this->email) || !isset($this->email) || !filter_var($this->email,FILTER_VALIDATE_EMAIL))
        {
            $message = $updateXML->addChild("message","You have made a mistake!Please check your inputs again.");
        }else{
            
            $update->bindParam(":id",$this->id);
            $update->bindParam(":namecrud",$this->name);
            $update->bindParam(":surname",$this->surname);
            $update->bindParam(":email",$this->email);

            $update->execute();

            $message = $updateXML->addChild("message","You have successfully updated user.");

        }

        Header("Content-type:text/xml");
        echo $updateXML->asXML();

    }


}


?>