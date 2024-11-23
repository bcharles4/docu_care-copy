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

if(isset($_POST['InOut']))
{
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['Patient_ID']);
	$IO_Date = mysqli_real_escape_string($connection, $_POST['date-Intake']);
    $AM_Oral_Intake = mysqli_real_escape_string($connection, $_POST['oral-am']);
    $AM_Parental_Intake = mysqli_real_escape_string($connection, $_POST['parental-am']);
    $AM_Other_Intake = mysqli_real_escape_string($connection, $_POST['other-am']);
    $AM_Total_Intake = mysqli_real_escape_string($connection, $_POST['intake_total-am']);
    $AM_Urine_Output = mysqli_real_escape_string($connection, $_POST['urine-am']);
    $AM_Stool_Output = mysqli_real_escape_string($connection, $_POST['stool-am']);
    $AM_Drainage_Output = mysqli_real_escape_string($connection, $_POST['drainage-am']);
    $AM_Total_Output = mysqli_real_escape_string($connection, $_POST['output_total-am']);
    $AM_Remarks = mysqli_real_escape_string($connection, $_POST['intakeOutputremarks-am']);
    $PM_Oral_Intake = mysqli_real_escape_string($connection, $_POST['oral-pm']);
    $PM_Parental_Intake = mysqli_real_escape_string($connection, $_POST['parental-pm']);
    $PM_Other_Intake = mysqli_real_escape_string($connection, $_POST['other-pm']);
    $PM_Total_Intake = mysqli_real_escape_string($connection, $_POST['intake_total-pm']);
    $PM_Urine_Output = mysqli_real_escape_string($connection, $_POST['urine-pm']);
    $PM_Stool_Output = mysqli_real_escape_string($connection, $_POST['stool-pm']);
    $PM_Drainage_Output = mysqli_real_escape_string($connection, $_POST['drainage-pm']);
    $PM_Total_Output = mysqli_real_escape_string($connection, $_POST['output_total-pm']);
    $PM_Remarks = mysqli_real_escape_string($connection, $_POST['intakeOutputremarks-pm']);
    $NT_Oral_Intake = mysqli_real_escape_string($connection, $_POST['oral-nt']);
    $NT_Parental_Intake = mysqli_real_escape_string($connection, $_POST['parental-nt']);
    $NT_Other_Intake = mysqli_real_escape_string($connection, $_POST['other-nt']);
    $NT_Total_Intake = mysqli_real_escape_string($connection, $_POST['intake_total-nt']);
    $NT_Urine_Output = mysqli_real_escape_string($connection, $_POST['urine-nt']);
    $NT_Stool_Output = mysqli_real_escape_string($connection, $_POST['stool-nt']);
    $NT_Drainage_Output = mysqli_real_escape_string($connection, $_POST['drainage-nt']);
    $NT_Total_Output = mysqli_real_escape_string($connection, $_POST['output_total-nt']);
    $NT_Remarks = mysqli_real_escape_string($connection, $_POST['intakeOutputremarks-nt']);
    $Total_Oral = mysqli_real_escape_string($connection, $_POST['oral-total']);
    $Total_Parental = mysqli_real_escape_string($connection, $_POST['parental-total']);
    $Total_Other = mysqli_real_escape_string($connection, $_POST['other-total']);
    $Total_Intake = mysqli_real_escape_string($connection, $_POST['intake-total']);
    $Total_Urine = mysqli_real_escape_string($connection, $_POST['urine-total']);
    $Total_Stool = mysqli_real_escape_string($connection, $_POST['stool-total']);
    $Total_Drainage = mysqli_real_escape_string($connection, $_POST['drainage-total']);
    $Total_Output = mysqli_real_escape_string($connection, $_POST['output-total']);
    $Total_Remarks = mysqli_real_escape_string($connection, $_POST['intakeOutputremarks-total']);

	//insert data to table
	$insert = "INSERT INTO intake_output_tbl ( Patient_ID, IO_Date, AM_Oral_Intake, AM_Parental_Intake, AM_Other_Intake, AM_Total_Intake, 
                                               AM_Urine_Output, AM_Stool_Output, AM_Drainage_Output, AM_Total_Output, AM_Remarks, 
                                               PM_Oral_Intake, PM_Parental_Intake, PM_Other_Intake, PM_Total_Intake, PM_Urine_Output, 
                                               PM_Stool_Output, PM_Drainage_Output, PM_Total_Output, PM_Remarks, NT_Oral_Intake, 
                                               NT_Parental_Intake, NT_Other_Intake, NT_Total_Intake, NT_Urine_Output, NT_Stool_Output, 
                                               NT_Drainage_Output, NT_Total_Output, NT_Remarks, Total_Oral, Total_Parental, Total_Other, 
                                               Total_Intake, Total_Urine, Total_Stool, Total_Drainage, Total_Output, Total_Remarks)

				VALUES('$Patient_ID', '$IO_Date', '$AM_Oral_Intake', '$AM_Parental_Intake', '$AM_Other_Intake', '$AM_Total_Intake', 
                       '$AM_Urine_Output', '$AM_Stool_Output', '$AM_Drainage_Output', '$AM_Total_Output', '$AM_Remarks', '$PM_Oral_Intake', 
                       '$PM_Parental_Intake', '$PM_Other_Intake', '$PM_Total_Intake', '$PM_Urine_Output', '$PM_Stool_Output', 
                       '$PM_Drainage_Output', '$PM_Total_Output', '$PM_Remarks', '$NT_Oral_Intake', '$NT_Parental_Intake', '$NT_Other_Intake',
                       '$NT_Total_Intake', '$NT_Urine_Output', '$NT_Stool_Output', '$NT_Drainage_Output', '$NT_Total_Output', '$NT_Remarks', 
                       '$Total_Oral', '$Total_Parental', '$Total_Other', '$Total_Intake', '$Total_Urine', '$Total_Stool', '$Total_Drainage', 
                       '$Total_Output', '$Total_Remarks')";

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
