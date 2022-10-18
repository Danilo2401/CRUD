<?php

require "structure.php";

$updateUser = new Structure();

$updateUser->Update($_POST["UserID"],$_POST["namecrud"],$_POST["surname"],$_POST["email"]);


?>