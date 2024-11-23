<?php

    $server = 'localhost:3307';
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
    if(isset($TargetPatient_ID)){
        $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';


        // Fetch data from patient info table
        $PatientInfoData = file_get_contents($BaseAPIUrl . 'patient_info');
        $PatientInfoArray = json_decode ($PatientInfoData, true);

        $PatientInfo = [];
        if(is_array($PatientInfoArray)){
            foreach($PatientInfoArray as $Patient){
                if ($Patient['Patient_ID'] == $TargetPatient_ID){
                $PatientInfo = $Patient;
                break;
                }
            }
        }

        // Fetch data from kardex table
        $KardexData = file_get_contents($BaseAPIUrl . 'kardex_tbl');
        $KardexArray = json_decode ($KardexData, true);

        $KardexInfo = [
            'Precautions' => 'No Data.',
            'Hospital_Num' => 'No Data.',
            'Weight' => 'No Data.',
        ];
        
        if(is_array($KardexArray)){
            foreach($KardexArray as $Kardex){
                if ($Kardex['Patient_ID'] == $TargetPatient_ID){
                $KardexInfo = $Kardex;
                break;
                }
            }
        }

        //Fetch data from patient emergency contacts table
        $EmergencyContactData = file_get_contents($BaseAPIUrl . 'patient_emergency_contact');
        $EmergencyContactArray = json_decode($EmergencyContactData, true);

        $EmergencyContactInfo = [];
        if (is_array ($EmergencyContactArray)){
            foreach($EmergencyContactArray as $EmergencyContact){
                if ($EmergencyContact['Patient_ID'] == $TargetPatient_ID){
                    $EmergencyContactInfo[] = $EmergencyContact;
            }
                }
        }

        //Fetch data from kardex endorsements table
        $KardexEndorsementsData = file_get_contents($BaseAPIUrl . 'kardex_endorsements');
        $KardexEndorsementsArray = json_decode($KardexEndorsementsData, true);

        $KardexEndorsementsInfo = [];
        if (is_array ($KardexEndorsementsArray)){
            foreach($KardexEndorsementsArray as $KardexEndorsements){
                if ($KardexEndorsements['Patient_ID'] == $TargetPatient_ID){
                    $KardexEndorsementsInfo[] = $KardexEndorsements;
            }
                }
        }

        //Fetch data from kardex iv table
        $KardexIVData = file_get_contents($BaseAPIUrl . 'kardex_iv');
        $KardexIVArray = json_decode($KardexIVData, true);

        $KardexIVInfo = [];
        if (is_array ($KardexIVArray)){
            foreach($KardexIVArray as $KardexIV){
                if ($KardexIV['Patient_ID'] == $TargetPatient_ID){
                    $KardexIVInfo[] = $KardexIV;
            }
                }
        }

        //Fetch data from kardex side drips table
        $KardexSDData = file_get_contents($BaseAPIUrl . 'kardex_drips_transfusion');
        $KardexSDArray = json_decode($KardexSDData, true);

        $KardexSDInfo = [];
        if (is_array ($KardexSDArray)){
            foreach($KardexSDArray as $KardexSD){
                if ($KardexSD['Patient_ID'] == $TargetPatient_ID){
                    $KardexSDInfo[] = $KardexSD;
            }
                }
        }

        //Fetch data from kardex notes table
        $KardexNotesData = file_get_contents($BaseAPIUrl . 'kardex_notes');
        $KardexNotesArray = json_decode($KardexNotesData, true);

        $KardexNotesInfo = [];
        if (is_array ($KardexNotesArray)){
            foreach($KardexNotesArray as $KardexNotes){
                if ($KardexNotes['Patient_ID'] == $TargetPatient_ID){
                    $KardexNotesInfo[] = $KardexNotes;
            }
                }
        }

        //Fetch data from kardex diagnostics table
        $KardexDiagnosticsData = file_get_contents($BaseAPIUrl . 'kardex_diagnostics');
        $KardexDiagnosticsArray = json_decode($KardexDiagnosticsData, true);

        $KardexDiagnosticsInfo = [];
        if (is_array ($KardexDiagnosticsArray)){
            foreach($KardexDiagnosticsArray as $KardexDiagnostics){
                if ($KardexDiagnostics['Patient_ID'] == $TargetPatient_ID){
                    $KardexDiagnosticsInfo[] = $KardexDiagnostics;
            }
                }
        }

        //Fetch data from kardex vitals table
        $KardexVitalsData = file_get_contents($BaseAPIUrl . 'kardex_vitals');
        $KardexVitalsArray = json_decode($KardexVitalsData, true);

        $KardexVitalsInfo = [];
        if (is_array ($KardexVitalsArray)){
            foreach($KardexVitalsArray as $KardexVitals){
                if ($KardexVitals['Patient_ID'] == $TargetPatient_ID){
                    $KardexVitalsInfo[] = $KardexVitals;
            }
                }
        }

        //Fetch data from kardex io table
        $KardexIOData = file_get_contents($BaseAPIUrl . 'kardex_io');
        $KardexIOArray = json_decode($KardexIOData, true);

        $KardexIOInfo = [];
        if (is_array ($KardexIOArray)){
            foreach($KardexIOArray as $KardexIO){
                if ($KardexIO['Patient_ID'] == $TargetPatient_ID){
                    $KardexIOInfo[] = $KardexIO;
            }
                }
        }

        //Fetch data from kardex diet table
        $KardexDietData = file_get_contents($BaseAPIUrl . 'kardex_diet');
        $KardexDietArray = json_decode($KardexDietData, true);

        $KardexDietInfo = [];
        if (is_array ($KardexDietArray)){
            foreach($KardexDietArray as $KardexDiet){
                if ($KardexDiet['Patient_ID'] == $TargetPatient_ID){
                    $KardexDietInfo[] = $KardexDiet;
            }
                }
        }

        //Fetch data from kardex last meal table
        $KardexMealData = file_get_contents($BaseAPIUrl . 'kardex_diet_last_meal');
        $KardexMealArray = json_decode($KardexMealData, true);

        $KardexMealInfo = [];
        if (is_array ($KardexMealArray)){
            foreach($KardexMealArray as $KardexMeal){
                if ($KardexMeal['Patient_ID'] == $TargetPatient_ID){
                    $KardexMealInfo[] = $KardexMeal;
            }
                }
        }

        //Fetch data from kardex medications table
        $KardexMedicationsData = file_get_contents($BaseAPIUrl . 'kardex_medications');
        $KardexMedicationsArray = json_decode($KardexMedicationsData, true);

        $KardexMedicationsInfo = [];
        if (is_array ($KardexMedicationsArray)){
            foreach($KardexMedicationsArray as $KardexMedications){
                if ($KardexMedications['Patient_ID'] == $TargetPatient_ID){
                    $KardexMedicationsInfo[] = $KardexMedications;
            }
                }
        }

    } 
?>
