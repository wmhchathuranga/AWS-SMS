<?php

session_start();

$tell = $_POST["tell"];

$digit = random_int(100000, 999999);

$_SESSION["tell"]=$tell;

echo 'ok'.$digit;

?>