<?php
$server = 'localhost:3307';
$user = 'root';
$pass ='';
$db = 'docudata_doctors';

$connection = mysqli_connect($server, $user, $pass)
or die ('Could not connect to the server ...\n'.mysqli_error());

mysqli_select_db($connection, $db)
or die ('Could not connect to the server ...\n'.mysqli_error());
?>

