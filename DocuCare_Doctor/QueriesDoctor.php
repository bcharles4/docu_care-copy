<?php
    $server = 'localhost:3307';
    $user = 'root';
    $pass ='';
    $db = 'docudata_doctors';

    mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

    try{
        $connection = mysqli_connect($server, $user, $pass, $db);
    }catch (Exception $ex)
    {
        echo'errors';
    }

if(isset($TargetPatient_ID)){
        // Pagination settings
        $recordsPerPage = $recordsPerPage ?? 7; // Default to 7
        $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        $offset = ($current_page - 1) * $recordsPerPage;

    //Doctors Order Query
        $DocOrder_query = "SELECT *
        FROM doctors_order 
        WHERE Patient_ID = '$TargetPatient_ID' AND doctors_order.Status <> 'x'
        ORDER BY Doctor_Order_Date DESC
        LIMIT $offset, $recordsPerPage";
        $resultDocOrder = $connection->query($DocOrder_query);

    //Med Records Query
        $MedSO_query = "SELECT *
        FROM medication_record_so
        WHERE Patient_ID = '$TargetPatient_ID' AND medication_record_so.Status <> 'x'
        ORDER BY Medication_SO_Date DESC
        LIMIT $offset, $recordsPerPage";
        $resultMedSO = $connection->query($MedSO_query);

        $MedSO = []; // Initialize the array
        if ($resultMedSO) {
            while ($row = $resultMedSO->fetch_assoc()) {
                $MedSO[] = $row; // Store each row in the MedSO array
            }
        }

        $MedPRN_query = "SELECT *
        FROM medication_record_prn
        WHERE Patient_ID = '$TargetPatient_ID' AND medication_record_prn.Status <> 'x'
        ORDER BY Medication_PRN_Date DESC
        LIMIT $offset, $recordsPerPage";
        $resultMedPRN = $connection->query($MedPRN_query);

        $MedPRN = []; // Initialize the array
        if ($resultMedPRN) {
            while ($row = $resultMedPRN->fetch_assoc()) {
                $MedPRN[] = $row; // Store each row in the MedPRN_query array
            }
        }

        $MedSTAT_query = "SELECT *
        FROM medication_record_stat
        WHERE Patient_ID = '$TargetPatient_ID' AND medication_record_stat.Status <> 'x'
        ORDER BY Medication_STAT_Date DESC
        LIMIT $offset, $recordsPerPage";
        $resultMedSTAT = $connection->query($MedSTAT_query);

        $MedSTAT = []; // Initialize the array
        if ($resultMedSTAT) {
            while ($row = $resultMedSTAT->fetch_assoc()) {
                $MedSTAT[] = $row; // Store each row in the MedSTAT_query array
            }
        }
    
        $MedSTAT_query = "SELECT *
        FROM medication_record_stat
        WHERE Patient_ID = '$TargetPatient_ID' AND medication_record_stat.Status <> 'x'
        ORDER BY Medication_STAT_Date DESC
        LIMIT $offset, $recordsPerPage";
        $resultMedSTAT = $connection->query($MedSTAT_query);
    
    //Standing Order Query
        $StandOrder_query = "SELECT *
        FROM standing_order
        WHERE Patient_ID = '$TargetPatient_ID'
        ORDER BY Date_Ordered DESC
        LIMIT $offset, $recordsPerPage";
        $resultStandOrder = $connection->query($StandOrder_query);

        $StandingOrder = []; // Initialize the array
        if ($resultStandOrder) {
            while ($row = $resultStandOrder->fetch_assoc()) {
                $StandingOrder[] = $row; // Store each row in the StandingOrderTotal array
            }
        }
}
?>
