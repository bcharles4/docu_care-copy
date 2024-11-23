<?php
session_start();

$server = 'localhost';
$user = 'root';
$pass ='';
$db = 'docudatasql';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    $connection = mysqli_connect($server, $user, $pass, $db);
} catch (Exception $ex) {
    echo 'Error: Could not connect to the database.';
}

if (isset($_POST['Kardex'])) {
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['Patient_ID']);
    $Precautions = mysqli_real_escape_string($connection, $_POST['precautions']);
    $Admission_Date = mysqli_real_escape_string($connection, $_POST['dateTimeAdmitted']);
    $Hospital_Num = mysqli_real_escape_string($connection, $_POST['hospitalNo']);
    $Patient_Name = mysqli_real_escape_string($connection, $_POST['patientName']);
    $Age = mysqli_real_escape_string($connection, $_POST['age']);
    $Sex = mysqli_real_escape_string($connection, $_POST['sex']);
    $Weight = mysqli_real_escape_string($connection, $_POST['weight']);
    $Room_Num = mysqli_real_escape_string($connection, $_POST['roomNo']);
    $Address = mysqli_real_escape_string($connection, $_POST['address']);
    $Attending_Physician = mysqli_real_escape_string($connection, $_POST['attendingPhysician']);
    $Admitting_Diagnosis = mysqli_real_escape_string($connection, $_POST['admittingDiagnosis']);
    $Endorsement_Date = mysqli_real_escape_string($connection, $_POST['endorsedate']);
    $Special_Endorsement = mysqli_real_escape_string($connection, $_POST['specialEndorsement']);
    $Endorsement_Remarks = mysqli_real_escape_string($connection, $_POST['remarks']);
    $IVFluid_Date = mysqli_real_escape_string($connection, $_POST['ivfdate']);
    $IVFluid = mysqli_real_escape_string($connection, $_POST['ivf']);
    $SideDrip_Date = mysqli_real_escape_string($connection, $_POST['sideDripsDate']);
    $SideDrip = mysqli_real_escape_string($connection, $_POST['sideDrips']);
    $Contraptions = mysqli_real_escape_string($connection, $_POST['contraptions']);
    $Monitoring = mysqli_real_escape_string($connection, $_POST['monitoring']);
    $Diagnostic_Date = mysqli_real_escape_string($connection, $_POST['date']);
    $Diagnostics = mysqli_real_escape_string($connection, $_POST['diagnostic']);
    $Last_Meal = mysqli_real_escape_string($connection, $_POST['lastmeal']);
    $Medication_Name = mysqli_real_escape_string($connection, $_POST['generic-name']);
    $Medication_Remarks = mysqli_real_escape_string($connection, $_POST['medremarks']);
    $Other_Endorsement = mysqli_real_escape_string($connection, $_POST['specialendorse']);

    // Handling checkboxes - Vital Signs
    $Vital_Signs = isset($_POST['vitals']) ? implode(', ', $_POST['vitals']) : '';
    $Vital_Other = isset($_POST['vitalothersinput']) ? mysqli_real_escape_string($connection, $_POST['vitalothersinput']) : '';
    if (!empty($Vital_Other)) {
        $Vital_Signs .= ", $Vital_Other";
    }

    // Handling checkboxes - Monitor I & O
    $Monitor_IO = isset($_POST['monitor']) ? implode(', ', $_POST['monitor']) : '';
    $Monitor_Other = isset($_POST['monitorothersinput']) ? mysqli_real_escape_string($connection, $_POST['monitorothersinput']) : '';
    if (!empty($Monitor_Other)) {
        $Monitor_IO .= ", $Monitor_Other";
    }

    // Handling checkboxes - Diet / Nutrition
    $Diet_Nutrition = isset($_POST['diet']) ? implode(', ', $_POST['diet']) : '';
    $Diet_Other = isset($_POST['Dietothersinput']) ? mysqli_real_escape_string($connection, $_POST['Dietothersinput']) : '';
    if (!empty($Diet_Other)) {
        $Diet_Nutrition .= ", $Diet_Other";
    }
    //KARDEX TABLE
    $insert = "INSERT INTO kardex_tbl (Patient_ID, Precautions, Admission_Date, Hospital_Num, Weight, Admitting_Diagnosis, Contraptions, 
    Monitoring, Vital_Signs, Monitor_IO, Diet_Nutrition, Last_Meal, Other_Endorsement)
    VALUES ('$Patient_ID', '$Precautions', '$Admission_Date', '$Hospital_Num', '$Weight', '$Admitting_Diagnosis', '$Contraptions', 
    '$Monitoring', '$Vital_Signs', '$Monitor_IO', '$Diet_Nutrition', '$Last_Meal', '$Other_Endorsement')";

    //DIAGNOSTICS TABLE
    $Diagnostics_Checks = isset($_POST['options']) ? implode(', ', $_POST['options']) : '';
    $insert_diagnostics= "INSERT INTO kardex_diagnostics (Patient_ID, Diagnostic_Date,  Diagnostics, Diagnostics_Checks)
    VALUES ('$Patient_ID', '$Diagnostic_Date', '$Diagnostics', '$Diagnostics_Checks')";

    //ENDORSEMENTS TABLE
    $endorsement = "INSERT INTO kardex_endorsements(Patient_ID, Endorsement_Date, Special_Endorsement, Endorsement_Remarks)
    VALUES('$Patient_ID', '$Endorsement_Date', '$Special_Endorsement', '$Endorsement_Remarks')";

    //MEDICATIONS TABLE
    $Medication_query = "INSERT INTO kardex_medications (Patient_ID, Medication_Name, Medication_Remarks)
    VALUES ('$Patient_ID', '$Medication_Name', '$Medication_Remarks')";

    //IVF FLUIDS
    $IV_query = "INSERT INTO kardex_iv (Patient_ID, IVFluid_Date, IVFluid)
    VALUES ('$Patient_ID', '$IVFluid_Date', '$IVFluid')";
    
    //SIDE DRIP
    $Drips_query = "INSERT INTO kardex_drips_transfusion (Patient_ID, Drips_Transfusion_Date, Drips_Transfusion)
    VALUES ('$Patient_ID', '$SideDrip_Date', ' $SideDrip')";

    $update = "UPDATE patient_info
    SET Patient_Name ='$Patient_Name', Age='$Age', Sex='$Sex', Room_Num='$Room_Num', Address='$Address', 
    Attending_Physician ='$Attending_Physician'
    WHERE Patient_ID = $Patient_ID";

try {
    // Insert into kardex_tbl
    $insert_result = mysqli_query($connection, $insert);
    if (!$insert_result) {
        throw new Exception('Insert Query Error in kardex_tbl: ' . mysqli_error($connection));
    }

    // Insert into kardex_diagnostics
    $diag_result = mysqli_query($connection, $insert_diagnostics);
    if (!$diag_result) {
        throw new Exception('Insert Query Error in kardex_diagnostics: ' . mysqli_error($connection));
    }

    // Insert into kardex_endorsements
    $endorse_result = mysqli_query($connection, $endorsement);
    if (!$endorse_result) {
        throw new Exception('Insert Query Error in kardex_endorsements: ' . mysqli_error($connection));
    }

    // Insert into kardex_medications
    $resultMedications = mysqli_query($connection, $Medication_query);
    if (!$resultMedications) {
        throw new Exception('Insert Medication Query Error: ' . mysqli_error($connection));
    }

    // Insert into kardex_iv
    $IV_result = mysqli_query($connection, $IV_query);
    if (!$IV_result) {
        throw new Exception('Insert Query Error in kardex_iv: ' . mysqli_error($connection));
    }

    // Insert into kardex_drips_transfusion
    $resultTransfusion = mysqli_query($connection, $Drips_query);
    if (!$resultTransfusion) {
        throw new Exception('Insert Query Error in kardex_drips_transfusion: ' . mysqli_error($connection));
    }

    // Update patient_info
    $update_result = mysqli_query($connection, $update);
    if (!$update_result) {
        throw new Exception('Update Query Error in patient_info: ' . mysqli_error($connection));
    }

    // Success Message
    echo '<script>alert("Successfully Saved!");</script>';
    echo '<script>window.location.assign("ChartingList.php");</script>';
} catch (Exception $ex) {
    echo 'Error: ' . $ex->getMessage();
}
}
?>