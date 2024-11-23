
<?php

$server = 'localhost:3307';
$user = 'root';
$pass = '';
$db = 'docudata';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect($server, $user, $pass, $db);
} catch (Exception $ex) {
    echo 'Error';
}

if (isset($TargetPatient_ID)) {
    $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';


    // Pagination settings
    $recordsPerPage = $recordsPerPage ?? 7; // Default to 7
    $current_page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $offset = ($current_page - 1) * $recordsPerPage;

    // Fetch data from patient info table
    $PatientInfoData = file_get_contents($BaseAPIUrl . 'patient_info');
    $PatientInfoArray = json_decode($PatientInfoData, true);

    $PatientInfo = [];
    if (is_array($PatientInfoArray)) {
        foreach ($PatientInfoArray as $Patient) {
            if ($Patient['Patient_ID'] == $TargetPatient_ID) {
                $PatientInfo = $Patient;
                break;
            }
        }
    }

    // Fetch data from tpr initial vitals table
    $TPRInitialVitalsData = file_get_contents($BaseAPIUrl . 'tpr_initial_vitals');
    $TPRInitialVitalsArray = json_decode($TPRInitialVitalsData, true);

    $TPRInitialVitalsInfo = [];
    if (is_array($TPRInitialVitalsArray)) {
        foreach ($TPRInitialVitalsArray as $TPRInitialVitals) {
            if ($TPRInitialVitals['Patient_ID'] == $TargetPatient_ID) {
                $TPRInitialVitalsInfo[] = $TPRInitialVitals;
            }
        }
    }

    $TPRInitialVitalsInfo = array_slice($TPRInitialVitalsInfo, $offset, $recordsPerPage);

    // Fetch data from tpr vital signs monitoring table
    $VitalsData = file_get_contents($BaseAPIUrl . 'patient_vital_signs');
    $VitalsArray = json_decode($VitalsData, true);

    $VitalsInfo = [];
    if (is_array($VitalsArray)) {
        foreach ($VitalsArray as $Vitals) {
            if ($Vitals['Patient_ID'] == $TargetPatient_ID) {
                $VitalsInfo[] = $Vitals;
            }
        }
    }
    // Apply pagination to VitalsInfo
    $VitalsInfo = array_slice($VitalsInfo, $offset, $recordsPerPage);

    // Fetch data from IV table
    $IVData = file_get_contents($BaseAPIUrl . 'ivfr_iv');
    $IVArray = json_decode($IVData, true);

    $IVInfo = [];
    if (is_array($IVArray)) {
        foreach ($IVArray as $IV) {
            if ($IV['Patient_ID'] == $TargetPatient_ID) {
                $IVInfo[] = $IV;
            }
        }
    }
    // Apply pagination to IVInfo
    $IVInfo = array_slice($IVInfo, $offset, $recordsPerPage);

    // Fetch data from side drips table
    $SDData = file_get_contents($BaseAPIUrl . 'ivfr_side_drips');
    $SDArray = json_decode($SDData, true);

    $SDInfo = [];
    if (is_array($SDArray)) {
        foreach ($SDArray as $SD) {
            if ($SD['Patient_ID'] == $TargetPatient_ID) {
                $SDInfo[] = $SD;
            }
        }
    }
    // Apply pagination to SDInfo
    $SDInfo = array_slice($SDInfo, $offset, $recordsPerPage);

    // Fetch data from fast drips table
    $FDData = file_get_contents($BaseAPIUrl . 'ivfr_fast_drip');
    $FDArray = json_decode($FDData, true);

    $FDInfo = [];
    if (is_array($FDArray)) {
        foreach ($FDArray as $FD) {
            if ($FD['Patient_ID'] == $TargetPatient_ID) {
                $FDInfo[] = $FD;
            }
        }
    }
    // Apply pagination to FDInfo
    $FDInfo = array_slice($FDInfo, $offset, $recordsPerPage);

    // Fetch data from lab results table
    $LabData = file_get_contents($BaseAPIUrl . 'patient_lab_results');
    $LabArray = json_decode($LabData, true);

    $LabInfo = [];
    if (is_array($LabArray)) {
        foreach ($LabArray as $Lab) {
            if ($Lab['Patient_ID'] == $TargetPatient_ID) {
                $LabInfo[] = $Lab;
            }
        }
    }
    // Apply pagination to LabInfo
    $LabInfo = array_slice($LabInfo, $offset, $recordsPerPage);

    // Fetch data from scan results table
    $ScanData = file_get_contents($BaseAPIUrl . 'patient_scan_results');
    $ScanArray = json_decode($ScanData, true);

    $ScanInfo = [];
    if (is_array($ScanArray)) {
        foreach ($ScanArray as $Scan) {
            if ($Scan['Patient_ID'] == $TargetPatient_ID) { // Fix: changed from $Lab to $Scan
                $ScanInfo[] = $Scan;
            }
        }
    }
    // Apply pagination to ScanInfo
    $ScanInfo = array_slice($ScanInfo, $offset, $recordsPerPage);


     // Fetch data from nurse notes table
     $NurseNotesData = file_get_contents($BaseAPIUrl . 'nurse_notes');
     $NurseNotesArray = json_decode($NurseNotesData, true);
 
     $NurseNotesInfo = [];
     if (is_array($NurseNotesArray)) {
         foreach ($NurseNotesArray as $NurseNotes) {
             if ($NurseNotes['Patient_ID'] == $TargetPatient_ID) {
                 $NurseNotesInfo[] = $NurseNotes;
             }
         }
     }
     // Apply pagination to NurseNotesInfo
     $NurseNotesInfo = array_slice($NurseNotesInfo, $offset, $recordsPerPage);

    // Fetch data from patient intake table
    $IntakeData = file_get_contents($BaseAPIUrl . 'patient_intake');
    $IntakeArray = json_decode($IntakeData, true);

    $IntakeInfo = [];
    if (is_array($IntakeArray)) {
        foreach ($IntakeArray as $Intake) {
            if ($Intake['Patient_ID'] == $TargetPatient_ID) {
                $IntakeInfo[] = $Intake;
            }
        }
    }    

    // Fetch data from patient output table
    $OutputData = file_get_contents($BaseAPIUrl . 'patient_output');
    $OutputArray = json_decode($OutputData, true);

    $OutputInfo = [];
    if (is_array($OutputArray)) {
        foreach ($OutputArray as $Output) {
            if ($Output['Patient_ID'] == $TargetPatient_ID) {
                $OutputInfo[] = $Output;
            }
        }
    }

}
if (isset($_GET['act']) && $_GET['act'] == 'Discharge') {
    $Patient_ID = $_GET['Patient_ID'];

    // Fetch patient details before deletion
    $fetchQuery = "SELECT * FROM patient_info WHERE Patient_ID = ?";
    $stmtFetch = mysqli_prepare($connection, $fetchQuery);
    mysqli_stmt_bind_param($stmtFetch, 's', $Patient_ID);
    mysqli_stmt_execute($stmtFetch);
    $result = mysqli_stmt_get_result($stmtFetch);
    $patientData = mysqli_fetch_assoc($result);

    if ($patientData) {
        // Step 1: Remove the patient data from the database
        $deleteQuery = "DELETE FROM patient_info WHERE Patient_ID = ?";
        $stmtDelete = mysqli_prepare($connection, $deleteQuery);
        mysqli_stmt_bind_param($stmtDelete, 's', $Patient_ID);

        if (mysqli_stmt_execute($stmtDelete)) {
            // Prepare data for the notification
            $notificationData = [
                'patientID' => $patientData['Patient_ID'],
                'firstName' => $patientData['Patient_FName'],
                'lastName' => $patientData['Patient_LName'],
                'gender' => $patientData['Sex'],
                'contact' => $patientData['Emergency_Contact'],   
                  
            ];

            $apiUrl = 'https://patient-discharge-notification-c1545bff9ae9.herokuapp.com/api/patients/send-notification'; // Replace with your actual API URL
            $ch = curl_init($apiUrl);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($notificationData));
            curl_setopt($ch, CURLOPT_HTTPHEADER, [
                'Content-Type: application/json'
            ]);

            $response = curl_exec($ch);
            $httpStatus = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            curl_close($ch);

            // Step 3: Check API response
            if ($httpStatus == 201) {
                echo '<script>alert("Patient is ready for Discharge and Notification Sent");</script>';
            } else {
                echo '<script>alert("Patient is ready for Discharge but Notification Failed");</script>';
            }

            // Redirect to the desired page after processing
            echo '<script>window.location.assign("doctorsOrderList.php");</script>';
        } else {
            echo '<script>alert("Failed to discharge the patient.");</script>';
            echo '<script>window.location.assign("doctorsOrderList.php");</script>';
        }
    } else {
        echo '<script>alert("Patient not found.");</script>';
        echo '<script>window.location.assign("doctorsOrderList.php");</script>';
    }
    exit;
}

?>