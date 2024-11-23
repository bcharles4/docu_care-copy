<?php
session_start();

$server = 'localhost:3307';
$user = 'root';
$pass = '';
$db = 'docudata_doctors';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect($server, $user, $pass, $db);
    
    $doctor_id = $_SESSION['User_ID'];

    if (isset($_POST['doctors'])) {
        $Patient_ID = mysqli_real_escape_string($connection, $_POST['patient_ID']);
        $Patient_FName = mysqli_real_escape_string($connection, $_POST['patientFName']);
        $Patient_MName = mysqli_real_escape_string($connection, $_POST['patientMName']);
        $Patient_LName = mysqli_real_escape_string($connection, $_POST['patientLName']);
        $Age = mysqli_real_escape_string($connection, $_POST['age']);
        $Sex = mysqli_real_escape_string($connection, $_POST['sex']);
        $Doctor_Order_Date = mysqli_real_escape_string($connection, $_POST['date-time-doctorsOrder']);
        $Progress = mysqli_real_escape_string($connection, $_POST['progress-observation']);
        $Doctor_Order = mysqli_real_escape_string($connection, $_POST['data-doctorsOrder']);
        $Current_Status = isset($_POST['CARED']) ? implode(', ', $_POST['CARED']) : '';  

        if (!empty($Current_Status)) {
            $check_query = "SELECT * FROM doctors_order WHERE Patient_ID = '$Patient_ID' AND Current_Status = '$Current_Status'";
            $result_check = $connection->query($check_query);

            if ($result_check->num_rows == 0) {
                $insert_current_status = "INSERT INTO doctors_order (Ordered_by_Doctor, Patient_ID, Doctor_Order_Date, 
                Observation_Progress, Doctor_Order, Current_Status, Status, Deletion_Date)
                VALUES ('$doctor_id', '$Patient_ID', '$Doctor_Order_Date', '$Progress', '$Doctor_Order', '$Current_Status', 'o', NULL)";
                $connection->query($insert_current_status);
            } else {
                echo "Data already exists, skipping insertion.";
            }
        }

        // UPDATE TABLE
        $update = "UPDATE docudata.patient_info
        SET Patient_FName ='$Patient_FName', Patient_MName ='$Patient_MName', Patient_LName ='$Patient_LName', Age='$Age', Sex='$Sex'
        WHERE Patient_ID = $Patient_ID";
        
        $update_result = mysqli_query($connection, $update);
        
        if (!$update_result) {
            throw new Exception('Update Query Error in patient_info: ' . mysqli_error($connection));
        }
        
        echo '<script>alert("Successfully Saved!");</script>';
        echo '<script>window.location.assign("doctorsOrder.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
    }
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
?>
