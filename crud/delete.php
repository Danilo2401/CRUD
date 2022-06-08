<?php

require "database.php";
require "user.php";

$db = new Database();

$dbDelete = $db->SetConnection();

$delete_user = new User($dbDelete);

$delete_user->DeleteUser($_POST["id"]);


?>