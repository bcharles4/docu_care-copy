<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];

    $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';

    // Fetch data from patient info table
     $PatientInfoData = file_get_contents($BaseAPIUrl . 'patient_info');
     $PatientInfoArray = json_decode ($PatientInfoData, true);

     //Fetch data from patient emergency contacts table
     $EmergencyContactData = file_get_contents($BaseAPIUrl . 'patient_emergency_contact');
     $EmergencyContactArray = json_decode($EmergencyContactData, true);

     //Fetch data from kardex notes
     $KardexNotesData = file_get_contents($BaseAPIUrl . 'kardex_notes');
     $KardexNotesArray = json_decode($KardexNotesData, true);
     
     //Fetch data from tpr intial vitals
     $TPRInitialVitalsData = file_get_contents($BaseAPIUrl . 'tpr_initial_vitals');
     $TPRInitialVitalsArray = json_decode($TPRInitialVitalsData, true);
     
     //Fetch Patient ID in the url
     $TargetPatient_ID = $_GET['Patient_ID'];

     $PatientInfo = [];
     if(is_array($PatientInfoArray)){
      foreach($PatientInfoArray as $Patient){
        if ($Patient['Patient_ID'] == $TargetPatient_ID){
          $PatientInfo = $Patient;
          break;
        }
      }
     }

     $EmergencyContactInfo = [];
     if (is_array ($EmergencyContactArray)){
      foreach($EmergencyContactArray as $EmergencyContact){
        if ($EmergencyContact['Patient_ID'] == $TargetPatient_ID){
          $EmergencyContactInfo = $EmergencyContact;
        }
      }
     }

     $KardexNotesInfo = [];
     if (is_array ($KardexNotesArray)){
      foreach($KardexNotesArray as $KardexNotes){
        if ($KardexNotes['Patient_ID'] == $TargetPatient_ID){
          $KardexNotesInfo = $KardexNotes;
        }
      }
     }

     $TPRInitialVitalsInfo = [];
     if (is_array ($TPRInitialVitalsArray)){
      foreach($TPRInitialVitalsArray as $TPRInitialVitals){
        if ($TPRInitialVitals['Patient_ID'] == $TargetPatient_ID){
          $TPRInitialVitalsInfo = $TPRInitialVitals;
        }
      }
     }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Outpatient Information | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css">
  
</head>
<body>
    <div class="nav__toggle" id="nav-toggle">
        <i class="uil uil-bars"></i>
    </div>
    <aside class="sidebar" id="sidebar">
        <nav class="nav">
            <div class="sidebar-header">
                <img src="img/logo.png" alt="logo" />
                <h2>DocuCare</h2>
            </div>

            <!-- Doctor Sidebar-->
            <?php if($Position == 'Doctor') { ?>
              <ul class="sidebar-links">
                <h4>
                  <span>Main Menu</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="dashboard.php" class="active"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                </li>
                <li>
                   <a href="patientList.php"><span class="material-symbols-outlined">patient_list</span>Patient List</a>
                </li>
                <li>
                   <a href="doctorsOrderList.php"><span class="material-symbols-outlined">stethoscope</span>Doctor's Order</a>
                </li>
                <li>
                    <a href="dataAnalytic.php"><span class="material-symbols-outlined">bar_chart</span>Data Analytics</a>
                </li>
                
                <h4>
                  <span>Account</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="Profile.php"><span class="material-symbols-outlined">account_circle</span>Profile</a>
                </li>
                <li>
                  <a href="index.php"><span class="material-symbols-outlined">logout</span>Logout</a>
                </li>
              </ul>
              <?php } ?>

              <div class="user-account">
                <div class="user-profile">
                  <img src="img/profile.png" alt="Profile Image" />
                  <div class="user-detail">
                    <h3><?php echo $_SESSION['User_FName'] . ' ' . $_SESSION['User_LName']; ?></h3>
                    <span><?php echo $_SESSION['Position']; ?></span>
                  </div>
                </div>
              </div>

            <div class="nav__close" id="nav-close">
                <i class="uil uil-times"></i>
            </div>
        </nav> 
    </aside>

    <main class="main">
    <div class="form-container">
        <form action="" class="patientDetails">
           <h1>Outpatient Information</h1>
           <div class="form-row-container">         
             <div class="form-row">
                <div class="form-group">
                <h2>Patient Details</h2>
                  <div class="info">
                    <p><strong>Patient ID:</strong> <span id="Patient_ID"><?php echo !empty($PatientInfo['Patient_ID']) ? $PatientInfo['Patient_ID'] : 'No Data.'; ?></span></p>
                    <p><strong>Name:</strong> <span id="Name"><?php echo !empty($PatientInfo['Patient_FName']) ? $PatientInfo['Patient_FName'] . ' ' . (!empty($PatientInfo['Patient_MName']) ? $PatientInfo['Patient_MName'] . ' ' : '') . $PatientInfo['Patient_LName'] : 'No Data.'; ?></span></p>
                    <p><strong>Gender:</strong> <span id="Gender"><?php echo !empty($PatientInfo['Sex']) ? $PatientInfo['Sex'] : 'No Data.'; ?></span></p>
                    <p><strong>Date of Birth:</strong> <span id="DoB"><?php echo !empty($PatientInfo['DoB']) ? $PatientInfo['DoB'] : 'No Data.'; ?></span></p>
                    <p><strong>Birthplace:</strong> <span id="Birthplace"><?php echo !empty($PatientInfo['Birthplace']) ? $PatientInfo['Birthplace'] : 'No Data.'; ?></span></p> 
                    <p><strong>Address:</strong> <span id="Address"><?php echo !empty($PatientInfo['Street']) ? $PatientInfo['Street'] . ' ' . $PatientInfo['House_Num'] . ' ' . $PatientInfo['Subdivision'] . ' ' . $PatientInfo['Barangay'] . ' ' . $PatientInfo['City'] . ' ' . $PatientInfo['Province'] : 'No Data.'; ?></span></p>
                    <p><strong>Emergency Contact:</strong> <span id="Emergency-Contact"><?php echo !empty($EmergencyContactInfo['Emergency_Contact_Name']) ? $EmergencyContactInfo['Emergency_Contact_Name'] : 'No Data.'; ?></span></p>
                    <p><strong>Contact No.:</strong> <span id="Contact-Num"><?php echo !empty($EmergencyContactInfo['Emergency_Contact']) ? $EmergencyContactInfo['Emergency_Contact'] : 'No Data.'; ?></span></p>
                  </div>
                </div>

                <div class="form-group">  
                <h2 >Medical Details</h2>
                  <div class="info">
                    <p><strong>Admitting Diagnosis:</strong> <span id="admittingDiagnosis"><?php echo !empty($KardexNotesInfo['Admitting_Diagnosis']) ? ($KardexNotesInfo['Admitting_Diagnosis']) : 'No Data.' ?></span></p>
                    <p><strong>Contraptions:</strong> <span id="contraptions"><?php echo !empty($KardexNotesInfo['Contraptions']) ? ($KardexNotesInfo['Contraptions']) : 'No Data.' ?></span></p>
                    <p><strong>Monitoring:</strong> <span id="monitoring"><?php echo !empty($KardexNotesInfo['Monitoring']) ? ($KardexNotesInfo['Monitoring']) : 'No Data.' ?></span></p>
                    <?php

                      $MedicationData = file_get_contents($BaseAPIUrl . 'kardex_medications');
                      $MedicationArray = json_decode($MedicationData, true);

                      $MedicationList = [];
                      if(is_array($MedicationArray)){
                        foreach ($MedicationArray as $Medications){
                          if ($Medications['Patient_ID'] == $TargetPatient_ID){
                            $MedicationList[] = htmlspecialchars($Medications['Medication_Name']);
                          } 
                        }
                      }

                      if (!empty($MedicationList)){
                        echo '<p><strong>Medications:</strong></p>';
                        echo '<ul>';
                        foreach($MedicationList as $Meds){
                          echo '<li>'. $Meds .'</li>';
                        }
                        echo '</ul>';
                      } 
                      else {
                         echo '<p>No medications found for this patient.</p>';
                      }
                    ?>
                    <p><strong>Special Endorsement:</strong> <span id="specialendorse"><?php echo !empty($KardexNotesInfo['Other_Endorsement']) ? ($KardexNotesInfo['Other_Endorsement']) : 'No Data.' ?></span></p>      
                  </div>  
                </div>

                <div class="form-group">
                  <h2>Vital Signs</h2>
                  <div class="info">   
                    <p><strong>Blood Pressure (mmHG):</strong> <span id="bloodPressure"><?php echo !empty($TPRInitialVitalsInfo['Blood_Pressure']) ? $TPRInitialVitalsInfo['Blood_Pressure'] : 'No Data.'; ?></span></p>
                    <p><strong>Temperature (°C):</strong> <span id="temperature"><?php echo !empty($TPRInitialVitalsInfo['Temperature']) ? $TPRInitialVitalsInfo['Temperature'] : 'No Data.'; ?></span></p>
                    <p><strong>Respiratory Rate (breaths/min):</strong> <span id="respiratoryRate"><?php echo !empty($TPRInitialVitalsInfo['Respiratory_Rate']) ? $TPRInitialVitalsInfo['Respiratory_Rate'] : 'No Data.'; ?></span></p>
                    <p><strong>Pulse Rate (beats/min):</strong> <span id="pulseRate"><?php echo !empty($TPRInitialVitalsInfo['Pulse_Rate']) ? $TPRInitialVitalsInfo['Pulse_Rate'] : 'No Data.'; ?></span></p>
                    <p><strong>Weight (kg):</strong> <span id="weight"><?php echo !empty($TPRInitialVitalsInfo['Weight']) ? $TPRInitialVitalsInfo['Weight'] : 'No Data.'; ?></span></p>
                    <p><strong>FHT (beats/min):</strong> <span id="fht"><?php echo !empty($TPRInitialVitalsInfo['FHT']) ? $TPRInitialVitalsInfo['FHT'] : 'N/A'; ?></span></p>
                  </div>
                </div>
             </div>

           </div>
        </form>
      </div>

           <div class="info-btn">
                <ul>
                    <li><a href="nurseNotes.php?Patient_ID=<?php echo $TargetPatient_ID; ?>">Nurse Notes</a></li>
                    <li><a href="labResults.php?Patient_ID=<?php echo $TargetPatient_ID; ?>">Laboratory Results</a></li> 
                    <li><a href="imagingScans.php?Patient_ID=<?php echo $TargetPatient_ID; ?>">Imaging and Scans</a></li> 
                </ul>
            </div>
 
    </main>


    <script src="main.js"></script>
</body>
</html>