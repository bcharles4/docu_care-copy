<?php
session_start();

$server = 'localhost:3307';
$user = 'root';
$pass ='';
$db = 'docudata_doctors';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect($server, $user, $pass, $db);
} catch (Exception $ex) {
    echo 'Error: Could not connect to the database.';
}
$doctor_id = $_SESSION['User_ID'];

if (isset($_POST['medRecord'])) {
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['patient_ID']);
    $Patient_FName = mysqli_real_escape_string($connection, $_POST['patientFName']);
	$Patient_MName = mysqli_real_escape_string($connection, $_POST['patientMName']);
	$Patient_LName = mysqli_real_escape_string($connection, $_POST['patientLName']);
    $Age = mysqli_real_escape_string($connection, $_POST['age']);
    $Sex = mysqli_real_escape_string($connection, $_POST['sex']);
    $Med_SO_Date = mysqli_real_escape_string($connection, $_POST['med-date-SO']);
    $Hospital_Day = mysqli_real_escape_string($connection, $_POST['hospital_day1']);
    $Standing_Order = mysqli_real_escape_string($connection, $_POST['standing_order']);
    $Med_PRN_Date = mysqli_real_escape_string($connection, $_POST['med-date-PRN']);
    $PRN_Med = mysqli_real_escape_string($connection, $_POST['PRN-Med']);
    $Med_STAT_Date = mysqli_real_escape_string($connection, $_POST['med-date-STAT']);
    $STAT_Med = mysqli_real_escape_string($connection, $_POST['stat_order']);

     
    $insert = "INSERT INTO medication_record_so (Patient_ID, Ordered_by_Doctor, Medication_SO_Date, 
    Hospital_Day, Standing_Order, Status, Deletion_Date)
            VALUES ('$Patient_ID', '$doctor_id', ' $Med_SO_Date', '$Hospital_Day','$Standing_Order', 'o', NULL)";

    $insert_med_prn = "INSERT INTO medication_record_prn (Patient_ID, Ordered_by_Doctor, Medication_PRN_Date, 
    PRN_Medication, Status, Deletion_Date)
            VALUES ('$Patient_ID', '$doctor_id', ' $Med_PRN_Date', '$PRN_Med', 'o', NULL)";

    $insert_med_stat = "INSERT INTO medication_record_stat (Patient_ID, Ordered_by_Doctor, Medication_STAT_Date,
     STAT_Order, Status, Deletion_Date)
            VALUES ('$Patient_ID', '$doctor_id', '$Med_STAT_Date', '$STAT_Med', 'o', NULL)";

    //UPDATE TABLE
    $update = "UPDATE docudata.patient_info
    SET Patient_FName ='$Patient_FName', Patient_MName ='$Patient_MName', Patient_LName ='$Patient_LName', Age='$Age', Sex='$Sex'
    WHERE Patient_ID = $Patient_ID";
    try {
        
        $insert_result = mysqli_query($connection, $insert);
        if (!$insert_result) {
            throw new Exception('Insert Query Error: ' . mysqli_error($connection));
        }

        $med_prn_result = mysqli_query($connection, $insert_med_prn);
        if (!$med_prn_result) {
            throw new Exception('Insert Query Error: ' . mysqli_error($connection));
        }

        $med_stat_result = mysqli_query($connection, $insert_med_stat);
        if (!$med_stat_result) {
            throw new Exception('Insert Query Error: ' . mysqli_error($connection));
        }

        $update_result = mysqli_query($connection, $update);
        if (!$update_result) {
        throw new Exception('Update Query Error in patient_info: ' . mysqli_error($connection));
    }
        echo '<script>alert("Successfully Saved!");</script>';
        echo '<script>window.location.assign("medRecord.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
}     catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
    }
}
?>