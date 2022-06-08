<?php

require "database.php";
require "user.php";


$db = new Database();

$dbRead = $db->SetConnection();

$userRead = new User($dbRead);

$userRead->ShowUser();



?>