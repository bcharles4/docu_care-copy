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

if(isset($_POST['Vitals']))
{
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['Patient_ID']);
	$Vitals_DateTime = mysqli_real_escape_string($connection, $_POST['date-vitalSign']);
	$Blood_Pressure = mysqli_real_escape_string($connection, $_POST['bp-vitalSign']);
    $Respiratory_Rate = mysqli_real_escape_string($connection, $_POST['rr-vitalSign']);
	$Pulse_Rate = mysqli_real_escape_string($connection, $_POST['pr-vitalSign']);
    $Temperature = mysqli_real_escape_string($connection, $_POST['temp-vitalSign']);
    $Oxygen_Lvl = mysqli_real_escape_string($connection, $_POST['spo2-vitalSign']);
	$Weight = mysqli_real_escape_string($connection, $_POST['wt-vitalSign']);
    $Pain_Scale	 = mysqli_real_escape_string($connection, $_POST['pain-vitalSign']);
    $Intervention = mysqli_real_escape_string($connection, $_POST['interventions-vitalSign']);

	//insert data to table
	$insert = "INSERT INTO vitals_tbl (Patient_ID, Vitals_DateTime, Blood_Pressure, Respiratory_Rate, Pulse_Rate, Temperature, 
                           Oxygen_Lvl, Weight, Pain_Scale, Intervention)

				VALUES('$Patient_ID', '$Vitals_DateTime', '$Blood_Pressure', '$Respiratory_Rate', '$Pulse_Rate', '$Temperature', 
                       '$Oxygen_Lvl', '$Weight', '$Pain_Scale', '$Intervention')";

    try {
        // Execute the first query
        $insert_result = mysqli_query($connection, $insert);
        if (!$insert_result) {
            throw new Exception('Insert Query Error: ' . mysqli_error($connection));
        }

        // Check if rows were affected
        if (mysqli_affected_rows($connection) > 0) {
            print '<script>alert("Successfully Saved!");</script>';
            Print '<script>window.location.assign("ChartingList.php");</script>';
        } else {
            echo 'Data not inserted!';
        }
    } catch (Exception $ex) {
        echo 'Error: ' . $ex->getMessage();
    }
}
?>
