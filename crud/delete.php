<?php

require "structure.php";

$deleteUser = new Structure();

$deleteUser->Delete($_POST["UserID"]);

?>