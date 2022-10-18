<?php

require "structure.php";

$createUser = new Structure();

$createUser->Create($_POST["namecrud"],$_POST["surname"],$_POST["email"]);


?>