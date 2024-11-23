<?php
session_start();

$server = 'localhost';
$user = 'root';
$pass ='';
$db = 'docudatasql';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
	$connection = mysqli_connect($server, $user, $pass, $db);
}catch (Exception $ex)
{
	echo'Error';
}

if(isset($_POST['IVRecord']))
{
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['Patient_ID']);
	$IV_Date = mysqli_real_escape_string($connection, $_POST['date-ivf']);
    $IV_Bottle_Num = mysqli_real_escape_string($connection, $_POST['bottle-no-ivf']);
    $IV_Solution = mysqli_real_escape_string($connection, $_POST['iv-solution-ivf']);
    $IV_Volume = mysqli_real_escape_string($connection, $_POST['volume-ivf']);
    $IV_Incorporation = mysqli_real_escape_string($connection, $_POST['incorporation-ivf']);
    $IV_Regulation = mysqli_real_escape_string($connection, $_POST['regulation-ivf']);
    $IV_Start = mysqli_real_escape_string($connection, $_POST['time-started-ivf']);
    $IV_Time_Consumed = mysqli_real_escape_string($connection, $_POST['date-time-consumed-ivf']);
    $IV_Remark = mysqli_real_escape_string($connection, $_POST['remark-ivf']);
    $SD_Date = mysqli_real_escape_string($connection, $_POST['date-sideDrips']);
    $SD_Bottle_Num = mysqli_real_escape_string($connection, $_POST['bottle-no-sideDrips']);
    $SD_Solution = mysqli_real_escape_string($connection, $_POST['iv-solution-sideDrips']);
    $SD_Volume = mysqli_real_escape_string($connection, $_POST['volume-sideDrips']);
    $SD_Incorporation = mysqli_real_escape_string($connection, $_POST['incorporation-sideDrips']);
    $SD_Regulation = mysqli_real_escape_string($connection, $_POST['regulation-sideDrips']);
    $SD_Start = mysqli_real_escape_string($connection, $_POST['time-started-sideDrips']);
    $SD_Time_Consumed = mysqli_real_escape_string($connection, $_POST['date-time-consumed-sideDrips']);
    $SD_Remark = mysqli_real_escape_string($connection, $_POST['remark-sideDrips']);
    $FD_Date = mysqli_real_escape_string($connection, $_POST['date-fastDrip']);
    $FD_IVF = mysqli_real_escape_string($connection, $_POST['ivf-fastDrip']);
    $FD_Volume = mysqli_real_escape_string($connection, $_POST['volume-fastDrip']);
    $FD_Incorporation = mysqli_real_escape_string($connection, $_POST['incorporation-fastDrip']);
    $FD_Time = mysqli_real_escape_string($connection, $_POST['time-fastDrip']);
    $FD_Remark = mysqli_real_escape_string($connection, $_POST['remark-fastDrip']);


	
}
?>
