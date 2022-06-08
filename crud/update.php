<?php

require "user.php";
require "database.php";

$db = new Database();

$dbUpdate = $db->SetConnection();

$updateUser = new User($dbUpdate);

$updateUser->UpdateUser($_POST["id"],$_POST["name"],$_POST["surname"],$_POST["email"]);


?>