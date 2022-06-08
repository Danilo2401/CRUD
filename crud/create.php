<?php

require "database.php";
require "user.php";

$database = new Database();

$db = $database->SetConnection();

$new_user = new User($db);

$new_user->CreateUser($_POST["name"],$_POST["surname"],$_POST["email"]);


?>