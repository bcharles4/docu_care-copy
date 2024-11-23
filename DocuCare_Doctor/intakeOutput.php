<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];
    
    $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';

    //Fetch Patient ID in the url
    $TargetPatient_ID = $_GET['Patient_ID'];

    // Fetch data from patient info table
    $PatientInfoData = file_get_contents($BaseAPIUrl . 'patient_info');
    $PatientInfoArray = json_decode ($PatientInfoData, true);
    

    //Fetch data from patient emergency contacts table
    $EmergencyContactData = file_get_contents($BaseAPIUrl . 'patient_emergency_contact');
    $EmergencyContactArray = json_decode($EmergencyContactData, true);

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

    include('Queries.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Intake and Output | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css">
    <style>
        .form-row-container {
           width: 100%;
        }   
        .form-row {
           margin-bottom: 5px;
        }

        .remove-row-button {
          background: none;
          border: none;
          cursor: pointer;
          text-align: center;
          justify-content: center;
         }

        .remove-row-button i {
           font-size: 1.2rem;  
           margin-top: -10px;
        }

        .IntakeOutput table input[type="text"], 
        .IntakeOutput table input[type="date"] {
           width: 90%; 
           box-sizing: border-box;
           padding: 4px; 
           border: 1px solid #ccc;
           border-radius: 4px;
           font-size: 0.85rem;
           background-color: #fff;
           min-width: 60px; 
           text-align: center;
        }

        .form-container {
          overflow-x: auto; 
        }

       .table-wrapper {
          overflow-x: auto; 
          width: 100%;
        }
    </style>
  
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
       <?php if($Position == 'Doctor') { ?>
        <div class="form-container">
            <form class="IntakeOutput" method="POST" action="intakeOutputScript.php">
                <h1>24 Hours Intake And Output Record</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" name="Patient_ID" value="<?php echo htmlspecialchars($TargetPatient_ID); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_FName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_MName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_LName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="age">AGE:</label>
                            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars ($PatientInfo['Age']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex" disabled>
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($PatientInfo['Sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($PatientInfo['Sex'] == 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($PatientInfo['Sex'] == 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                      
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" value="<?php echo htmlspecialchars ($PatientInfo['Attending_Physician']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" value="<?php echo htmlspecialchars ($PatientInfo['Room_Num']); ?>" readonly>
                        </div>
                    </div> 
                </div>

                <?php
                $CombinedIntake = [];

                if (is_array($IntakeInfo)) {
                    foreach ($IntakeInfo as $Intake) {
                        // Create a unique key for grouping using Patient_ID and Intake_Date
                        $key = $Intake['Patient_ID'] . '-' . $Intake['Intake_Date'];
                
                        // If the key doesn't exist in the array, initialize it as an empty array
                        if (!isset($CombinedIntake[$key])) {
                            $CombinedIntake[$key] = [];
                        }
                
                        // Add the current intake to the appropriate group
                        $CombinedIntake[$key][] = $Intake;
                    }
                }
                
                $GroupedIntakes = array_values($CombinedIntake);

                $CombinedOutput = [];

                if (is_array($OutputInfo)) {
                    foreach ($OutputInfo as $Output) {
                        $key = $Output['Patient_ID'] . '-' . $Output['Output_Date'];
                
                        if (!isset($CombinedOutput[$key])) {
                            $CombinedOutput[$key] = [];
                        }
                
                        $CombinedOutput[$key][] = $Output;
                    }
                }
                
                $GroupedOutput = array_values($CombinedOutput);
                
                $GroupedByDate = []; // Initialize an empty array to hold the data grouped by date

                // Group intake records by date
                if (is_array($GroupedIntakes)) {
                    foreach ($GroupedIntakes as $IntakeGroup) {
                        $date = $IntakeGroup[0]['Intake_Date']; // Get the date from the first item in the group
                
                        // If the date doesn't exist in the array, initialize it
                        if (!isset($GroupedByDate[$date])) {
                            $GroupedByDate[$date] = [
                                'Intakes' => [],
                                'Outputs' => [],
                            ];
                        }
                
                        // Merge the entire intake group into the corresponding date
                        $GroupedByDate[$date]['Intakes'] = array_merge($GroupedByDate[$date]['Intakes'], $IntakeGroup);
                    }
                }
                
                // Group output records by date
                if (is_array($GroupedOutput)) {
                    foreach ($GroupedOutput as $OutputGroup) {
                        $date = $OutputGroup[0]['Output_Date']; // Get the date from the first item in the group
                
                        // If the date doesn't exist in the array, initialize it
                        if (!isset($GroupedByDate[$date])) {
                            $GroupedByDate[$date] = [
                                'Intakes' => [],
                                'Outputs' => [],
                            ];
                        }
                
                        // Merge the entire output group into the corresponding date
                        $GroupedByDate[$date]['Outputs'] = array_merge($GroupedByDate[$date]['Outputs'], $OutputGroup);
                    }
                }

                 // Query to count group total records      
                 $totalGroupedCount = count($GroupedByDate); 
                 $totalPages = ceil($totalGroupedCount / $recordsPerPage); 
                $GroupedByDate  = array_slice($GroupedByDate, $offset, $recordsPerPage);
    

                  $hasIntakeOutput = !empty($GroupedByDate);
                  if ($hasIntakeOutput) {
                      echo '<div class="form-row-container">';
                      echo '<div class="form-row auto-input">';
                      echo '<div class="table-wrapper">';
                      echo '<table>';
                      echo '<thead>';
                      echo '<tr>';
                      echo '<th rowspan="2">DATE</th>';
                      echo '<th rowspan="2">SHIFT</th>';
                      echo '<th colspan="4">INTAKE</th>';
                      echo '<th colspan="4">OUTPUT</th>';
                      echo '<th rowspan="2">REMARKS</th>';
                      echo '</tr>';
                      echo '<tr>';
                      echo '<th class="sub-header">ORAL</th>';
                      echo '<th class="sub-header">PARENTAL</th>';
                      echo '<th class="sub-header">OTHER</th>';
                      echo '<th class="sub-header">TOTAL</th>';
                      echo '<th class="sub-header">URINE</th>';
                      echo '<th class="sub-header">STOOL</th>';
                      echo '<th class="sub-header">DRAINAGE</th>';
                      echo '<th class="sub-header">TOTAL</th>';
                      echo '</tr>';
                      echo '</thead>';
                      echo '<tbody>';
                  
                      foreach ($GroupedByDate as $date => $data) {
                          echo '<tr>';
                          echo '<td rowspan="3"><input type="date" name="date-Intake" value="' . htmlspecialchars($date) . '" readonly></td>';

                        // Set variables for total
                        $totalOralIntake = 0;
                        $totalParentalIntake = 0;
                        $totalOtherIntake = 0;
                        $totalUrineOutput = 0;
                        $totalStoolOutput = 0;
                        $totalDrainageOutput = 0;

                          // Process each shift: AM, PM, Night
                          foreach (['AM', 'PM', 'Night'] as $shift) {
                              echo '<td style="font-weight: bold; color: #000;">' . $shift . '</td>';
                  
                              // Filter and sum intake measures for the current shift and date
                              $oralIntake = 0;
                              $parentalIntake = 0;
                              $otherIntake = 0;
                              $urineOutput = 0;
                              $stoolOutput = 0;
                              $drainageOutput = 0;
                              $remarks = '';
                  
                              // Iterate through intake data
                              foreach ($data['Intakes'] as $intake) {
                                  if ($intake['Intake_Time'] === $shift) {
                                      switch ($intake['Intake_Type']) {
                                          case 'Oral':
                                              $oralIntake += $intake['Intake_Measure'];
                                              break;
                                          case 'Parental':
                                              $parentalIntake += $intake['Intake_Measure'];
                                              break;
                                          case 'Other':
                                              $otherIntake += $intake['Intake_Measure'];
                                              break;
                                      }
                                      $remarks = $intake['Intake_Remarks'] ?? '';
                                  }
                              }
                  
                              // Iterate through output data
                              foreach ($data['Outputs'] as $output) {
                                  if ($output['Output_Time'] === $shift) {
                                      switch ($output['Output_Type']) {
                                          case 'Urine':
                                              $urineOutput += $output['Output_Measure'];
                                              break;
                                          case 'Stool':
                                              $stoolOutput += $output['Output_Measure'];
                                              break;
                                          case 'Drainage':
                                              $drainageOutput += $output['Output_Measure'];
                                              break;
                                      }
                                      $remarks = $output['Output_Remarks'] ?? $remarks;
                                  }
                              }

                                // Add the current shift values to the total variables
                                $totalOralIntake += $oralIntake;
                                $totalParentalIntake += $parentalIntake;
                                $totalOtherIntake += $otherIntake;
                                $totalUrineOutput += $urineOutput;
                                $totalStoolOutput += $stoolOutput;
                                $totalDrainageOutput += $drainageOutput;
                  
                              // Display inputs for intake
                              echo '<td><input type="text" name="oral-' . strtolower($shift) . '" value="' . htmlspecialchars($oralIntake) . '" readonly></td>';
                              echo '<td><input type="text" name="parental-' . strtolower($shift) . '" value="' . htmlspecialchars($parentalIntake) . '" readonly></td>';
                              echo '<td><input type="text" name="other-' . strtolower($shift) . '" value="' . htmlspecialchars($otherIntake) . '" readonly></td>';
                              echo '<td><input type="text" name="intake_total-' . strtolower($shift) . '" style="font-weight: bold;" value="' . htmlspecialchars($oralIntake + $parentalIntake + $otherIntake) . '" readonly></td>';
                  
                              // Display inputs for output
                              echo '<td><input type="text" name="urine-' . strtolower($shift) . '" value="' . htmlspecialchars($urineOutput) . '" readonly></td>';
                              echo '<td><input type="text" name="stool-' . strtolower($shift) . '" value="' . htmlspecialchars($stoolOutput) . '" readonly></td>';
                              echo '<td><input type="text" name="drainage-' . strtolower($shift) . '" value="' . htmlspecialchars($drainageOutput) . '" readonly></td>';
                              echo '<td><input type="text" name="output_total-' . strtolower($shift) . '" style="font-weight: bold;" value="' . htmlspecialchars($urineOutput + $stoolOutput + $drainageOutput) . '" readonly></td>';
                              echo '<td><input type="text" name="intakeOutputremarks-' . strtolower($shift) . '" value="' . htmlspecialchars($remarks) . '" readonly></td>';
                              echo '</tr>'; // Close the shift row
                          }
                    
                  
                          // Total row
                          echo '<tr style="font-weight: bold;">';
                          echo '<td colspan="2" style="color: #000;">TOTAL</td>';
                          echo '<td><input type="text" name="oral-total" style="font-weight: bold;" value="' . htmlspecialchars($totalOralIntake) . '" readonly></td>';
                          echo '<td><input type="text" name="parental-total" style="font-weight: bold;" value="' . htmlspecialchars($totalParentalIntake) . '" readonly></td>';
                          echo '<td><input type="text" name="other-total" style="font-weight: bold;" value="' . htmlspecialchars($totalOtherIntake) . '" readonly></td>';
                          echo '<td><input type="text" name="intake-total" style="font-weight: bold;" value="' . htmlspecialchars($totalOralIntake + $totalParentalIntake + $totalOtherIntake) . '" readonly></td>';
                          echo '<td><input type="text" name="urine-total" style="font-weight: bold;" value="' . htmlspecialchars($totalUrineOutput) . '" readonly></td>';
                          echo '<td><input type="text" name="stool-total" style="font-weight: bold;" value="' . htmlspecialchars($totalStoolOutput) . '" readonly></td>';
                          echo '<td><input type="text" name="drainage-total" style="font-weight: bold;" value="' . htmlspecialchars($totalDrainageOutput) . '" readonly></td>';
                          echo '<td><input type="text" name="output-total" style="font-weight: bold;" value="' . htmlspecialchars($totalUrineOutput + $totalStoolOutput + $totalDrainageOutput) . '" readonly></td>';
                          echo '<td><input type="text" name="intakeOutputremarks-total"></td>';
                          echo '</tr>';
                      }
                  
                      echo '</tbody>';
                      echo '</table>';
                      echo '</div>';
                      echo '</div> <!-- End of .form-row -->';
                        
                         // Pagination Controls
                         echo '<div class="pagination">';
                         if ($current_page > 1) {
                             echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=1"><<</a>';
                             echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . ($current_page - 1) . '"><</a>';
                         }                  
                         for ($i = 1; $i <= $totalPages; $i++) {
                             if ($i == $current_page) {
                                 echo '<strong>' . $i . '</strong>';
                             } else {
                                 echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . $i . '">' . $i . '</a>';
                             }
                         }                         
                         if ($current_page < $totalPages) {
                             echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . ($current_page + 1) . '">></a>';
                             echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . $totalPages . '">>></a>';
                         }                     
                         echo '</div>';         
                    }else{
                         //if there is nothing inside the table
                         echo '<div class="form-row-container">';
                         echo '<div class="form-row no-data-row">';                   
                           echo '<p class="no-data">No Data</p>';
                         echo '</div>';
                       echo '</div>';     
                    }           
                
                echo '</div> <!-- End of .form-row-container -->';                 
                ?>
        </form>
       </div>
       <?php } ?>
    </main>

    <script src="main.js"></script>
    
    
</body>
</html>