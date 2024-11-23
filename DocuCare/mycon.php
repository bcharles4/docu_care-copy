<?php
$server = 'localhost';
$user = 'root';
$pass ='';
$db = 'docudata';

$connection = mysqli_connect($server, $user, $pass)
or die ('Could not connect to the server ...\n'.mysqli_error());

mysqli_select_db($connection, $db)
or die ('Could not connect to the server ...\n'.mysqli_error());
?>

