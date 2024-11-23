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

if (isset($_POST['STD'])) {
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['patient_ID']);
    $Patient_FName = mysqli_real_escape_string($connection, $_POST['patientFName']);
    $Patient_MName = mysqli_real_escape_string($connection, $_POST['patientMName']);
    $Patient_LName = mysqli_real_escape_string($connection, $_POST['patientLName']);
    $Age = mysqli_real_escape_string($connection, $_POST['age']);
    $Sex = mysqli_real_escape_string($connection, $_POST['sex']);
    $STD_Order_Date = mysqli_real_escape_string($connection, $_POST['date_ordered-stdOrder']);
    $Med_Order = mysqli_real_escape_string($connection, $_POST['medication-stdOrder']);

     
    $insert = "INSERT INTO standing_order (Patient_ID, Ordered_by_Doctor, Date_Ordered, `Order`)
            VALUES ('$Patient_ID', '$doctor_id', '$STD_Order_Date', '$Med_Order')";

    //UPDATE TABLE
    $update = "UPDATE docudata.patient_info
    SET Patient_FName ='$Patient_FName', Patient_MName ='$Patient_MName', Patient_LName ='$Patient_LName', Age='$Age', Sex='$Sex'
    WHERE Patient_ID = $Patient_ID";       
    try {
  
        $insert_result = mysqli_query($connection, $insert);
        if (!$insert_result) {
            throw new Exception('Insert Query Error: ' . mysqli_error($connection));
        }

        $update_result = mysqli_query($connection, $update);
        if (!$update_result) {
        throw new Exception('Update Query Error in patient_info: ' . mysqli_error($connection));
        }
        echo '<script>alert("Successfully Saved!");</script>';
        echo '<script>window.location.assign("standingOrder.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
}     catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
}
?>