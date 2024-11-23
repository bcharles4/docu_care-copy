<?php

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
        //KARDEX TABLE QUERIES
        //Precautions query
        $Precaution_query = "SELECT Patient_ID, Date, Precautions, Entered_By_Nurse 
        FROM kardex_tbl 
        WHERE Patient_ID = '$Patient_ID' 
        ORDER BY Date DESC 
        LIMIT 1";
        $resultPrecaution = $connection->query($Precaution_query);

        //Hospital Number query
        $HospitalNum_query = "SELECT Patient_ID, Date, Hospital_Num, Entered_By_Nurse 
        FROM kardex_tbl 
        WHERE Patient_ID = '$Patient_ID' 
        ORDER BY Date DESC 
        LIMIT 1";
        $resultHospitalNum = $connection->query($HospitalNum_query);
        
        //Weight query
        $Weight_query = "SELECT Patient_ID, Date, Weight, Entered_By_Nurse 
        FROM kardex_tbl 
        WHERE Patient_ID = '$Patient_ID' 
        ORDER BY Date DESC 
        LIMIT 1";
        $resultWeight = $connection->query($Weight_query);
        
        //Endorsement query
        $endorsement_query = "SELECT * FROM kardex_endorsements 
                              WHERE Patient_ID = '$Patient_ID' 
                              ORDER BY Endorsement_Date ASC 
                              LIMIT 7";
        $resultEndorsement = $connection->query($endorsement_query);

        //IV query
        $IV_query = "SELECT * FROM kardex_iv 
                     WHERE Patient_ID = '$Patient_ID' 
                     ORDER BY IVFluid_Date ASC 
                     LIMIT 7";
        $resultIV = $connection->query($IV_query);

        //SideDrips query
        $Drips_query = "SELECT * FROM kardex_drips_transfusion 
                        WHERE Patient_ID = '$Patient_ID' 
                        ORDER BY Drips_Transfusion_Date ASC 
                        LIMIT 7";
        $resultTransfusion = $connection->query($Drips_query);   

        //Diagnostics query
        $Diagnostic_query = "SELECT * FROM kardex_diagnostics 
                             WHERE Patient_ID = '$Patient_ID' 
                             ORDER BY Diagnostic_Date ASC 
                             LIMIT 7";
        $resultDiagnostics = $connection->query($Diagnostic_query);

        //Vitals query
        $Vitals_query = "SELECT * FROM kardex_vitals 
                         WHERE Patient_ID = '$Patient_ID' 
                         ORDER BY Vitals_Date DESC 
                         LIMIT 1";
        $resultVitals = $connection->query($Vitals_query);   

        //IO query
        $IO_query = "SELECT * FROM kardex_io 
                     WHERE Patient_ID = '$Patient_ID' 
                     ORDER BY IO_Date DESC 
                     LIMIT 1";
        $resultIO = $connection->query($IO_query);   
    
        //Diet query
        $Diet_query = "SELECT kardex_diet.*, kardex_diet_last_meal.Last_Meal FROM kardex_diet 
                       JOIN kardex_diet_last_meal  
                       ON kardex_diet.Patient_ID = kardex_diet_last_meal.Patient_ID
                       WHERE kardex_diet.Patient_ID = '$Patient_ID'
                       ORDER BY Diet_Date DESC, Meal_Date DESC 
                       LIMIT 1";
        $resultDiet = $connection->query($Diet_query);   

        //Medication query
        $Medication_query = "SELECT * FROM kardex_medications 
                             WHERE Patient_ID = '$Patient_ID'";
        $resultMedications = $connection->query($Medication_query);

        //Contraptions query
        $Contraptions_query = "SELECT Patient_ID, Date, Contraptions, Entered_By_Nurse 
                               FROM kardex_notes 
                               WHERE Patient_ID = '$Patient_ID'
                               ORDER BY Date DESC 
                               LIMIT 1";
        $resultContraptions = $connection->query($Contraptions_query);

        //Monitoring query
        $Monitoring_query = "SELECT Patient_ID, Date, Monitoring, Entered_By_Nurse 
                             FROM kardex_notes 
                             WHERE Patient_ID = '$Patient_ID'
                             ORDER BY Date DESC 
                             LIMIT 1";
        $resultMonitoring = $connection->query($Monitoring_query);

        //Contraptions query
        $OtherEndorsement_query = "SELECT Patient_ID, Date, Other_Endorsement, Entered_By_Nurse 
                                   FROM kardex_notes 
                                   WHERE Patient_ID = '$Patient_ID' 
                                   ORDER BY Date DESC 
                                   LIMIT 1";
        $resultOtherEndorsement = $connection->query($OtherEndorsement_query);
        //KARDEX TABLE QUERIES END

        //PATIENT VITALS TABLE QUERIES
        $PatientVitals_query = "SELECT *
                                FROM patient_vital_signs
                                WHERE Patient_ID = '$Patient_ID' 
                                ORDER BY Vitals_DateTime ASC 
                                LIMIT 7";
        $resultPatientVitals = $connection->query($PatientVitals_query);

        //iv record query
        $IVRecord_query = "SELECT *
                                FROM ivfr_IV
                                WHERE Patient_ID = '$Patient_ID' 
                                ORDER BY IV_Date ASC 
                                LIMIT 7";
        $resultIVRecord = $connection->query($IVRecord_query);

        //side drips query
        $SideDrips_query = "SELECT *
                                FROM ivfr_side_drips
                                WHERE Patient_ID = '$Patient_ID' 
                                ORDER BY SD_Date ASC 
                                LIMIT 7";
        $resultSideDripRecord = $connection->query($SideDrips_query);

        //ivfr fast drip
        $FastDrip_query = "SELECT *
                                FROM ivfr_fast_drip
                                WHERE Patient_ID = '$Patient_ID' 
                                ORDER BY SFD_Date ASC 
                                LIMIT 7";
        $resultFastDripRecord = $connection->query($FastDrip_query);

        //intake output query
       /**$AM_IO_query = "SELECT DISTINCT 
                               -- intake am
                               patient_intake_am.Patient_ID, 
                               patient_intake_am.Date,
                               patient_intake_am.AM_Oral_Intake,
                               patient_intake_am.AM_Parental_Intake,
                               patient_intake_am.AM_Other_Intake,
                               patient_intake_am.Total_AM_Intake,

                               -- intake pm
                               patient_intake_pm.PM_Oral_Intake,
                               patient_intake_pm.PM_Parental_Intake,
                               patient_intake_pm.PM_Other_Intake,
                               patient_intake_pm.Total_PM_Intake,

                               -- intake night
                               patient_intake_night.Night_Oral_Intake,
                               patient_intake_night.Night_Parental_Intake,
                               patient_intake_night.Night_Other_Intake,
                               patient_intake_night.Total_Night_Intake,

                               -- intake total
                               patient_intake_total.Total_Oral_Intake,
                               patient_intake_total.Total_Parental_Intake,
                               patient_intake_total.Total_Other_Intake,
                               patient_intake_total.Total_Intake,

                               -- output am
                               patient_output_am.AM_Urine_Output,
                               patient_output_am.AM_Stool_Output,
                               patient_output_am.AM_Drainage_Output,
                               patient_output_am.Total_AM_Output,

                               -- output pm
                               patient_output_pm.PM_Urine_Output,
                               patient_output_pm.PM_Stool_Output,
                               patient_output_pm.PM_Drainage_Output,
                               patient_output_pm.PM_Total_Output,

                               -- output night
                               patient_output_night.Night_Urine_Output,
                               patient_output_night.Night_Stool_Output,
                               patient_output_night.Night_Drainage_Output,
                               patient_output_night.Night_Total_Output,

                               -- output total
                               patient_output_total.total_Urine_Output,
                               patient_output_total.total_Stool_Output,
                               patient_output_total.total_Drainage_Output,
                               patient_output_total.Total_Output,

                               -- intake output am remarks
                               patient_intake_output_am_remarks.AM_Remarks,

                               -- intake output pm remarks
                               patient_intake_output_pm_remarks.PM_Remarks,

                               -- intake output night remarks
                               patient_intake_output_night_remarks.Night_Remarks,

                               -- intake output total remarks
                               patient_intake_output_total_remarks.Total_Remarks

                       FROM patient_intake_am 

                       -- join pm intake
                       JOIN patient_intake_pm  
                       ON patient_intake_am.Patient_ID = patient_intake_pm.Patient_ID

                       -- join night intake
                       JOIN patient_intake_night  
                       ON patient_intake_am.Patient_ID = patient_intake_night.Patient_ID

                       -- join total intake
                       JOIN patient_intake_total  
                       ON patient_intake_am.Patient_ID = patient_intake_total.Patient_ID

                       -- join am output
                       JOIN patient_output_am  
                       ON patient_intake_am.Patient_ID = patient_output_am.Patient_ID

                       -- join pm output
                       JOIN patient_output_pm  
                       ON patient_intake_am.Patient_ID = patient_output_pm.Patient_ID

                       -- join night output
                       JOIN patient_output_night 
                       ON patient_intake_am.Patient_ID = patient_output_night.Patient_ID

                       -- join total output
                       JOIN patient_output_total  
                       ON patient_intake_am.Patient_ID = patient_output_total.Patient_ID

                       -- join am remarks
                       JOIN patient_intake_output_am_remarks
                       ON patient_intake_am.Patient_ID = patient_intake_output_am_remarks.Patient_ID

                       -- join pm remarks
                       JOIN patient_intake_output_pm_remarks
                       ON patient_intake_am.Patient_ID = patient_intake_output_pm_remarks.Patient_ID

                       -- join night remarks
                       JOIN patient_intake_output_night_remarks
                       ON patient_intake_am.Patient_ID = patient_intake_output_night_remarks.Patient_ID

                       -- join total remarks
                       JOIN patient_intake_output_total_remarks
                       ON patient_intake_am.Patient_ID = patient_intake_output_total_remarks.Patient_ID

                       WHERE patient_intake_am.Patient_ID = '$Patient_ID'
                       ORDER BY patient_intake_am.Date asc
                       LIMIT 7";
        $resultAMIO = $connection->query($AM_IO_query);**/   
?>
