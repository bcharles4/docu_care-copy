
<?php
include('mycon.php');

// Set the base API url
$BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';

// Count total patients
$PatientData = file_get_contents($BaseAPIUrl . 'patient_info');
$PatientArray = json_decode($PatientData, true);
$TotalPatients = is_array($PatientArray) ? count($PatientArray) : 0;

// Count total patients admitted today
$AdmissionData = file_get_contents($BaseAPIUrl . 'patient_info');
$AdmissionsArray = json_decode($AdmissionData, true);

$TotalAdmissionsToday = 0;
if (is_array($AdmissionsArray)){
    foreach ($AdmissionsArray as $AdmissionsToday){
        if(isset($AdmissionsToday['Admission_Date'])){
            $AdmissionDate = substr($AdmissionsToday['Admission_Date'], 0, 10);
            if($AdmissionDate === date('Y-m-d')){
                $TotalAdmissionsToday++;
            }
        }
    }
}

// Count occupied rooms
$OccupiedRoomData = file_get_contents($BaseAPIUrl . 'rooms');
$OccupiedRoomArray = json_decode($OccupiedRoomData, true);

// Occupied rooms counter
$TotalOccupiedRooms = 0;
if (is_array($OccupiedRoomArray)) {
    // Loop through each room array
    foreach ($OccupiedRoomArray as $OccupiedRooms) {
        if (isset($OccupiedRooms['Room_Status']) && $OccupiedRooms['Room_Status'] === 'Occupied') {
            $TotalOccupiedRooms++;
        }
    }
}

// Count vacant rooms
$AvailableRoomData = file_get_contents($BaseAPIUrl . 'rooms');
$AvailableRoomArray = json_decode($AvailableRoomData, true);

// Occupied rooms counter
$TotalAvailableRooms = 0;
if (is_array($AvailableRoomArray)) {
    // Loop through each room array
    foreach ($AvailableRoomArray as $AvailableRooms) {
        if (isset($AvailableRooms['Room_Status']) && $AvailableRooms['Room_Status'] === 'Available') {
            $TotalAvailableRooms++;
        }
    }
}

// For the data analytics
// Fetch data from patient info table for the patient counter
$PatientCounterInfo = [];
if (is_array($PatientArray)) {
    foreach ($PatientArray as $Patient) {
            $PatientCounterInfo[] = $Patient;
        }
    }

// fetch data from patient info table for the diagnosis
$PatientDataInfo = [];
if (is_array($PatientArray)) {
    foreach ($PatientArray as $Patient) {
            if($Patient['Patient_Type'] == 'Inpatient'){
                $PatientDataInfo[] = $Patient;
            }
        }
    }

$totals = [
    'CurrentInfancy' => 0,
    'PreviousInfancy' => 0,
    'CurrentChildhood' => 0,
    'PreviousChildhood' => 0,
    'CurrentAdolescence' => 0,
    'PreviousAdolescence' => 0,
    'CurrentYearPatients' => 0,
    'PreviousYearPatients' => 0,
    'CurrentMonthPatients' => 0,
    'PreviousMonthPatients' => 0,
];

$currentYear = date("Y");
$currentMonth = date("n");

if (is_array($PatientCounterInfo)) {
    foreach ($PatientCounterInfo as $Patient) {
        $age = $Patient['Age'];
        $admissionDate = strtotime($Patient['Admission_Date']);
        $admissionYear = date("Y", $admissionDate);
        $admissionMonth = date("n", $admissionDate);

        // Check age groups and admission year
        if ($admissionYear == $currentYear) {
            if ($age <= 5) {
                $totals['CurrentInfancy']++;
            } elseif ($age >= 6 && $age <= 12) {
                $totals['CurrentChildhood']++;
            } elseif ($age >= 13 && $age <= 19) {
                $totals['CurrentAdolescence']++;
            }
            $totals['CurrentYearPatients']++;
            if ($admissionMonth == $currentMonth) {
                $totals['CurrentMonthPatients']++;
            }
            elseif($admissionMonth == $currentMonth - 1){
                $totals['PreviousMonthPatients']++;
            }
        } elseif ($admissionYear == $currentYear - 1) {
            if ($age <= 5) {
                $totals['PreviousInfancy']++;
            } elseif ($age >= 6 && $age <= 12) {
                $totals['PreviousChildhood']++;
            } elseif ($age >= 13 && $age <= 19) {
                $totals['PreviousAdolescence']++;
            }
            $totals['PreviousYearPatients']++;
        }
    }
}

// Access total counts
$TotalCurrentInfancy = $totals['CurrentInfancy'];
$TotalPreviousInfancy = $totals['PreviousInfancy'];
$TotalCurrentChildhood = $totals['CurrentChildhood'];
$TotalPreviousChildhood = $totals['PreviousChildhood'];
$TotalCurrentAdolescence = $totals['CurrentAdolescence'];
$TotalPreviousAdolescence = $totals['PreviousAdolescence'];
$TotalCurrentYearPatients = $totals['CurrentYearPatients'];
$TotalPreviousYearPatients = $totals['PreviousYearPatients'];
$TotalCurrentMonthPatients = $totals['CurrentMonthPatients'];
$TotalPreviousMonthPatients = $totals['PreviousMonthPatients'];


// previous and current year top 3 diagnoses & common diagnoses in barangay and city
$currentYearDiagnoses = [];
$previousYearDiagnoses = [];
$diagnosisCountCurrentYear = [];
$diagnosisCountPreviousYear = [];

if (is_array($PatientDataInfo)) {
    foreach ($PatientDataInfo as $Patient) {
        $admissionYear = date("Y", strtotime($Patient['Admission_Date']));
        $diagnosis = $Patient['Admitting_Diagnosis'];

        if ($admissionYear == $currentYear) {
            if (!isset($diagnosisCountCurrentYear[$diagnosis])) {
                $diagnosisCountCurrentYear[$diagnosis] = 0;
            }
            $diagnosisCountCurrentYear[$diagnosis]++;
        } elseif ($admissionYear == $currentYear - 1) {
            if (!isset($diagnosisCountPreviousYear[$diagnosis])) {
                $diagnosisCountPreviousYear[$diagnosis] = 0;
            }
            $diagnosisCountPreviousYear[$diagnosis]++;
        }
    }
}

$barangayDiagnoses = [];
$cityDiagnoses = [];

if (is_array($PatientDataInfo)) {
    foreach ($PatientDataInfo as $Patient) {
        $barangay = $Patient['Barangay'];
        $city = $Patient['City'];
        $diagnosis = $Patient['Admitting_Diagnosis'];

        // Group by Barangay
        if (!isset($barangayDiagnoses[$barangay])) {
            $barangayDiagnoses[$barangay] = [];
        }
        if (!isset($barangayDiagnoses[$barangay][$diagnosis])) {
            $barangayDiagnoses[$barangay][$diagnosis] = 0;
        }
        $barangayDiagnoses[$barangay][$diagnosis]++;

        // Group by City
        if (!isset($cityDiagnoses[$city])) {
            $cityDiagnoses[$city] = [];
        }
        if (!isset($cityDiagnoses[$city][$diagnosis])) {
            $cityDiagnoses[$city][$diagnosis] = 0;
        }
        $cityDiagnoses[$city][$diagnosis]++;
    }
}

?>