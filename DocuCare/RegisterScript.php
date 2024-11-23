<?php
session_start();

$server = 'localhost';
$user = 'root';
$pass ='';
$db = 'docudata';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
	$connection = mysqli_connect($server, $user, $pass, $db);
}catch (Exception $ex)
{
	echo'Error';
}

if(isset($_POST['register']))
{
	$User_FName = mysqli_real_escape_string($connection, $_POST['User_FName']);
	$User_MName = mysqli_real_escape_string($connection, $_POST['User_MName']);
	$User_LName = mysqli_real_escape_string($connection, $_POST['User_LName']);
	$Contact_Num = mysqli_real_escape_string($connection, $_POST['ContactNo']);
	$Department = mysqli_real_escape_string($connection, $_POST['Department']);
	$Position = mysqli_real_escape_string($connection, $_POST['Position']);
	$Email = mysqli_real_escape_string($connection, $_POST['Email']);
	$Password = mysqli_real_escape_string($connection, $_POST['Password']);

	//insert data to table
	$insert = "INSERT INTO user_tbl (User_FName, User_MName, User_LName, Contact_Num, Department, Position, Email, Password)
				VALUES('$User_FName', '$User_MName','$User_LName', '$Contact_Num', '$Department', '$Position', '$Email', '$Password')";

	try{
		$insert_result = mysqli_query($connection, $insert);

		if($insert)
		{
			if(mysqli_affected_rows($connection) > 0)
			{
				print '<script>alert("Sucessfully Registered!");</script>';
				Print '<script>window.location.assign("Dashboard.php");</script>';
			}else{
				echo'Data not inserted!';
			}
		}
	}
	catch (Exception $ex)
	{
		echo 'Error Insert'.$ex -> getMessage();
	}
}
?>
