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

    include('QueriesDoctor.php');
  

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Medication Record | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css">
    <style>
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
        <div class="form-container">
            <form class="medRecord" method = "POST" action = "medRecordScript.php">
                <h1>Medication Record</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patient_ID" name="patient_ID" placeholder="Enter patient number" value="<?php echo htmlspecialchars($PatientInfo['Patient_ID']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value="<?php echo htmlspecialchars($PatientInfo['Patient_FName']);?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value="<?php echo htmlspecialchars($PatientInfo['Patient_MName'])?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value="<?php echo htmlspecialchars($PatientInfo['Patient_LName']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="age">AGE:</label>
                            <input type="number" id="age" name="age" placeholder="Enter age" value="<?php echo htmlspecialchars($PatientInfo['Age']);?>">
                        </div>
                        <div class="form-group">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex">
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($PatientInfo['Sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($PatientInfo['Sex'] == 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($PatientInfo ['Sex'] == 'Other') echo 'selected' ?>>Other</option>
                            </select>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s" value="<?php echo htmlspecialchars($PatientInfo ['Attending_Physician']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number" value="<?php echo htmlspecialchars($PatientInfo['Room_Num']); ?>">
                        </div>
                    </div> 
                </div>

                <div class="form-row-container">
                    <div class="form-row">
                        <div class="guide">
                            <h3>Medication Record Table</h3>
                            <h4><span>USE THE FOLLOWING LEGENDS IF THE MEDICATION WAS NOT GIVEN DUE TO THE FF REASONS:</span></h4>
                            <p><span>Rx</span> - unavailable/prescribeed, <span>NPO</span> - if pt. is on NPO, <span>-IVF</span> - no IV Access, <span>REFUSED</span> - if refused, ensure patient signed waiver
                            <span>↑BP/↓BP/↑RR, etc.</span> - if medication is contraindicated for pt's vitals</p>
                        </div>      
                    </div>
                    <?php
                        $MedicationRecordSOData = file_get_contents($BaseAPIUrl . 'medication_record_so_response');
                        $MedicationRecordSOArray = json_decode($MedicationRecordSOData, true);

                        $MedRecordSOInfo = [];
                        if (is_array($MedicationRecordSOArray)) {
                            foreach ($MedicationRecordSOArray as $MedicationRecordSO) {
                                if ($MedicationRecordSO['Patient_ID'] == $TargetPatient_ID) {
                                    $MedRecordSOInfo[] = $MedicationRecordSO;
                                }
                            }
                        }
    
                        $CombinedData = [];
                        if (is_array($MedSO)) {
                            foreach ($MedSO as $SOOrder) {
                                $matched = false;
                                if (is_array($MedRecordSOInfo)) {
                                    foreach ($MedRecordSOInfo as $SOResponse) {
                                        if ($SOResponse['Medication_SO_ID'] == $SOOrder['Medication_SO_ID']) {
                                            // If a match is found, merge data and add to CombinedData
                                            $CombinedData[] = array_merge($SOResponse, $SOOrder);
                                            $matched = true;
                                        }
                                    }
                                }
                                if (!$matched) {
                                    // If no match is found, add the order with empty response fields
                                    $SOOrder['Medication_SO_Date'] = $SOOrder['Medication_SO_Date'] ?? '';
                                    $SOOrder['Hospital_Day'] = $SOOrder['Hospital_Day'] ?? '';
                                    $SOOrder['Standing_Order'] = $SOOrder['Standing_Order'] ?? '';
                                    $SOOrder['SO_10_6'] = '';
                                    $SOOrder['SO_6_2'] = '';
                                    $SOOrder['SO_2_10'] = '';
                                    $CombinedData[] = $SOOrder;
                                }
                            }
                        }

                        

                       // Query to count total records
                        $totalQuery = "SELECT COUNT(*) as total FROM  medication_record_so WHERE Patient_ID = '$TargetPatient_ID'";
                        $totalResult = $connection->query($totalQuery);
                        $totalRow = $totalResult->fetch_assoc();
                        $totalRecords = $totalRow['total'];
                        $totalPages = ceil($totalRecords / $recordsPerPage);

                        $hasSOOrder = !empty($MedSO);
                        if ($hasSOOrder) {      
                            echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="medRecord-SO-table">';
                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>Hospital Day</th>';
                                                echo '<th>I. Standing Orders</th>';
                                                echo '<th>10-6</th>';
                                                echo '<th>6-2</th>';
                                                echo '<th>2-10</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                        if ($current_page == 1) {
                                            echo '<tr>';
                                                echo '<td><input type="date" name="med-date-SO"/></td>';  
                                                echo '<td>';
                                                    echo '<select name="hospital_day1">';
                                                        echo '<option value="">Select Day</option>';
                                                        echo '<option value="Monday">Monday</option>';
                                                        echo '<option value="Tuesday">Tuesday</option>';
                                                        echo '<option value="Wednesday">Wednesday</option>';
                                                        echo '<option value="Thursday">Thursday</option>';
                                                        echo '<option value="Friday">Friday</option>';
                                                        echo '<option value="Saturday">Saturday</option>';
                                                        echo '<option value="Sunday">Sunday</option>';
                                                    echo '</select>';
                                                echo '</td>';       
                                                echo '<td><input type="text" name="standing_order"/></td>';
                                                echo '<td><input type="text" name="SO_10_6" readonly/></td>';
                                                echo '<td><input type="text" name="SO_6_2" readonly/></td>';
                                                echo '<td><input type="text" name="SO_2_10" readonly/></td>';
                                            echo '</tr>';
                                        }
                                        foreach ($CombinedData as $row) {
                                            echo '<tr>';
                                                echo '<input type="hidden" value = "'.htmlspecialchars($row['Medication_SO_ID']).'" readonly/>'; 
                                                echo '<td><input type="date" value = "'.htmlspecialchars($row['Medication_SO_Date']).'" readonly/></td>';  
                                                echo '<td><input type="text" value = "'.htmlspecialchars($row['Hospital_Day']).'" readonly/></td>';
                                                echo '<td><input type="text" value = "'.htmlspecialchars($row['Standing_Order']).'" readonly/></td>';
                                                echo '<td><input type="text" value ="'.htmlspecialchars($row['SO_10_6']).'" readonly/></td>';
                                                echo '<td><input type="text" value ="'.htmlspecialchars($row['SO_6_2']).'" readonly/></td>';
                                                echo '<td><input type="text" value ="'.htmlspecialchars($row['SO_2_10']).'"  readonly/></td>';
                                                echo '<td>
                                                        <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeleteSO&Patient_ID=' . urlencode($TargetPatient_ID) . '&Medication_SO_ID=' . urlencode($row['Medication_SO_ID']) . '" onclick="return confirm(\'Are you sure you want to delete this record?\');">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </a>
                                                      </td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';                           
                            echo '</div>';
                        }
                        else{
                            echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="medRecord-SO-table">';
                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>Hospital Day</th>';
                                                echo '<th>I. Standing Orders</th>';
                                                echo '<th>10-6</th>';
                                                echo '<th>6-2</th>';
                                                echo '<th>2-10</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><input type="date" name="med-date-SO"/></td>';  
                                                echo '<td>';
                                                    echo '<select name="hospital_day1">';
                                                        echo '<option value="">Select Day</option>';
                                                        echo '<option value="Monday">Monday</option>';
                                                        echo '<option value="Tuesday">Tuesday</option>';
                                                        echo '<option value="Wednesday">Wednesday</option>';
                                                        echo '<option value="Thursday">Thursday</option>';
                                                        echo '<option value="Friday">Friday</option>';
                                                        echo '<option value="Saturday">Saturday</option>';
                                                        echo '<option value="Sunday">Sunday</option>';
                                                    echo '</select>';
                                                echo '</td>';       
                                                echo '<td><input type="text" name="standing_order"/></td>';
                                                echo '<td><input type="text" name="SO_10_6" readonly/></td>';
                                                echo '<td><input type="text" name="SO_6_2" readonly/></td>';
                                                echo '<td><input type="text" name="SO_2_10" readonly/></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';                           
                            echo '</div>';
                        }
                    ?>
                </div>

                <div class="form-row-container">
                    <h3>PRN Medications</h3>
                    <?php
                        $MedicationRecordPRNData = file_get_contents($BaseAPIUrl . 'medication_record_prn_response');
                        $MedicationRecordPRNArray = json_decode($MedicationRecordPRNData, true);

                        $MedRecordPRNInfo = [];
                        if (is_array($MedicationRecordPRNArray)) {
                            foreach ($MedicationRecordPRNArray as $MedicationRecordPRN) {
                                if ($MedicationRecordPRN['Patient_ID'] == $TargetPatient_ID) {
                                    $MedRecordPRNInfo[] = $MedicationRecordPRN;
                                }
                            }
                        }
    
                        $CombinedData = [];
                        if (is_array($MedPRN)) {
                            foreach ($MedPRN as $PRNOrder) {
                                $matched = false;
                                if (is_array($MedRecordPRNInfo)) {
                                    foreach ($MedRecordPRNInfo as $PRNResponse) {
                                        if ($PRNResponse['Medication_PRN_ID'] == $PRNOrder['Medication_PRN_ID']) {
                                            // If a match is found, merge data and add to CombinedData
                                            $CombinedData[] = array_merge($PRNResponse, $PRNOrder);
                                            $matched = true;
                                        }
                                    }
                                }
                                if (!$matched) {
                                    // If no match is found, add the order with empty response fields
                                    $PRNOrder['Medication_PRN_Date'] = $PRNOrder['Medication_PRN_Date'] ?? '';
                                    $PRNOrder['PRN_Medication'] = $PRNOrder['PRN_Medication'] ?? '';
                                    $PRNOrder['PRN_10_6'] = '';
                                    $PRNOrder['PRN_6_2'] = '';
                                    $PRNOrder['PRN_2_10'] = '';
                                    $CombinedData[] = $PRNOrder;
                                }
                            }
                        }

                        // Query to count total records
                       $totalQuery = "SELECT COUNT(*) as total FROM medication_record_prn WHERE Patient_ID = '$TargetPatient_ID'";
                       $totalResult = $connection->query($totalQuery);
                       $totalRow = $totalResult->fetch_assoc();
                       $totalRecords = $totalRow['total'];
                       $totalPages = ceil($totalRecords / $recordsPerPage);
                        
                        $hasPRNOrder = !empty($MedPRN);
                        if ($hasPRNOrder) {    
                                echo '<div class="form-row">';
                                    echo '<div class="table-wrapper">';
                                        echo '<table id="medRecord-PRN-table">';
                                            echo '<thead>';
                                                echo '<tr>';
                                                    echo '<th>Date</th>';
                                                    echo '<th>II. PRN Medications</th>';
                                                    echo '<th>10-6</th>';
                                                    echo '<th>6-2</th>';
                                                    echo '<th>2-10</th>';
                                                echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            if ($current_page == 1) {
                                                echo '<tr>';
                                                    echo '<td><input type="date" name="med-date-PRN"/></td>';        
                                                    echo '<td><input type="text" name="PRN-Med"/></td>';
                                                    echo '<td><input type="text" name="PRN_10_6" readonly/></td>';
                                                    echo '<td><input type="text" name="PRN_6_2" readonly/></td>';
                                                    echo '<td><input type="text" name="PRN_2_10" readonly/></td>';
                                                echo '</tr>';
                                            }
                                            foreach ($CombinedData as $row) {
                                                echo '<tr>';
                                                    echo '<input type="hidden" value = "'.htmlspecialchars($row['Medication_PRN_ID']).'" readonly/>'; 
                                                    echo '<td><input type="date" value = "'.htmlspecialchars($row['Medication_PRN_Date']).'" readonly/></td>';        
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['PRN_Medication']).'"readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['PRN_10_6']).'" readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['PRN_6_2']).'" readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['PRN_2_10']).'" readonly/></td>';
                                                    echo '<td>
                                                            <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeletePRN&Patient_ID=' . urlencode($TargetPatient_ID) . '&Medication_PRN_ID=' . urlencode($row['Medication_PRN_ID']) .'" onclick="return confirm(\'Are you sure you want to delete this record?\');">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                         </td>';    
                                                echo '</tr>';
                                            }
                                            echo '</tbody>';
                                        echo '</table>';
                                    echo '</div>';                           
                                echo '</div>';
                        }
                        else{
                            echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="medRecord-PRN-table">';
                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>II. PRN Medications</th>';
                                                echo '<th>10-6</th>';
                                                echo '<th>6-2</th>';
                                                echo '<th>2-10</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><input type="date" name="med-date-PRN"/></td>';        
                                                echo '<td><input type="text" name="PRN-Med"/></td>';
                                                echo '<td><input type="text" name="PRN_10_6" readonly/></td>';
                                                echo '<td><input type="text" name="PRN_6_2" readonly/></td>';
                                                echo '<td><input type="text" name="PRN_2_10" readonly/></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';  
                            echo '</div>';
                        }
                    ?>                  
                </div>

                <div class="form-row-container">
                    <h3>STAT Order Medications</h3>
                    <?php
                       $MedicationRecordSTATData = file_get_contents($BaseAPIUrl . 'medication_record_stat_response');
                       $MedicationRecordSTATArray = json_decode($MedicationRecordSTATData, true);

                       $MedRecordSTATInfo = [];
                       if (is_array($MedicationRecordSTATArray)) {
                           foreach ($MedicationRecordSTATArray as $MedicationRecordSTAT) {
                               if ($MedicationRecordSTAT['Patient_ID'] == $TargetPatient_ID) {
                                   $MedRecordSTATInfo[] = $MedicationRecordSTAT;
                               }
                           }
                       }
   
                       $CombinedData = [];
                       if (is_array($MedSTAT)) {
                           foreach ($MedSTAT as $STATOrder) {
                               $matched = false;
                               if (is_array($MedRecordSTATInfo)) {
                                   foreach ($MedRecordSTATInfo as $STATResponse) {
                                       if ($STATResponse['Medication_STAT_ID'] == $STATOrder['Medication_STAT_ID']) {
                                           // If a match is found, merge data and add to CombinedData
                                           $CombinedData[] = array_merge($STATResponse, $STATOrder);
                                           $matched = true;
                                       }
                                   }
                               }
                               if (!$matched) {
                                   // If no match is found, add the order with empty response fields
                                   $STATOrder['Medication_STAT_Date'] = $STATOrder['Medication_STAT_Date'] ?? '';
                                   $STATOrder['STAT_Order'] = $STATOrder['STAT_Order'] ?? '';
                                   $STATOrder['STAT_10_6'] = '';
                                   $STATOrder['STAT_6_2'] = '';
                                   $STATOrder['STAT_2_10'] = '';
                                   $CombinedData[] = $STATOrder;
                               }
                           }
                       }

                       // Query to count total records
                      $totalQuery = "SELECT COUNT(*) as total FROM  medication_record_stat WHERE Patient_ID = '$TargetPatient_ID'";
                      $totalResult = $connection->query($totalQuery);
                      $totalRow = $totalResult->fetch_assoc();
                      $totalRecords = $totalRow['total'];
                      $totalPages = ceil($totalRecords / $recordsPerPage);
                       
                       $hasSTATOrder = !empty($MedSTAT);
                       if ($hasSTATOrder) {    
                                echo '<div class="form-row">';
                                    echo '<div class="table-wrapper">';
                                        echo '<table id="medRecord-STAT-table">';
                                            echo '<thead>';
                                                echo '<tr>';
                                                    echo '<th>Date</th>';
                                                    echo '<th>III. STAT Order Medications</th>';
                                                    echo '<th>10-6</th>';
                                                    echo '<th>6-2</th>';
                                                    echo '<th>2-10</th>';
                                                echo '</tr>';
                                            echo '</thead>';
                                            echo '<tbody>';
                                            if ($current_page == 1) {
                                                echo '<tr>'; 
                                                    echo '<td><input type="date" name="med-date-STAT"/></td>';        
                                                    echo '<td><input type="text" name="stat_order"/></td>';
                                                    echo '<td><input type="text" name="STAT_10_6" readonly/></td>';
                                                    echo '<td><input type="text" name="STAT_6_2" readonly/></td>';
                                                    echo '<td><input type="text" name="STAT_2_10" readonly/></td>';   
                                                echo '</tr>';
                                            }foreach($CombinedData as $row){
                                                echo '<tr>'; 
                                                    echo '<input type="hidden" value = "'.htmlspecialchars($row['Medication_STAT_ID']).'" readonly/>';
                                                    echo '<td><input type="date" value = "'.htmlspecialchars($row['Medication_STAT_Date']).'" readonly/></td>';        
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['STAT_Order']).'" readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['STAT_10_6']).'" readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['STAT_6_2']).'" readonly/></td>';
                                                    echo '<td><input type="text" value = "'.htmlspecialchars($row['STAT_2_10']).'" readonly/></td>';   
                                                    echo '<td>
                                                            <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeleteSTAT&Patient_ID=' . urlencode($TargetPatient_ID) . '&Medication_STAT_ID=' . urlencode($row['Medication_STAT_ID']) . '" onclick="return confirm(\'Are you sure you want to delete this record?\');">
                                                                <i class="fas fa-trash-alt"></i>
                                                            </a>
                                                         </td>'; 
                                                echo '</tr>';
                                            }      
                                            echo '</tbody>';
                                        echo '</table>';
                                    echo '</div>';                           
                                echo '</div>';

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
                        }
                        else{
                            echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="medRecord-STAT-table">';
                                        echo '<thead>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>III. STAT Order Medications</th>';
                                                echo '<th>10-6</th>';
                                                echo '<th>6-2</th>';
                                                echo '<th>2-10</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>'; 
                                                echo '<td><input type="date" name="med-date-STAT"/></td>';        
                                                echo '<td><input type="text" name="stat_order"/></td>';
                                                echo '<td><input type="text" name="STAT_10_6" readonly/></td>';
                                                echo '<td><input type="text" name="STAT_6_2" readonly/></td>';
                                                echo '<td><input type="text" name="STAT_2_10" readonly/></td>';   
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';  
                            echo '</div>';
                        }
                    ?>

                </div>
                <div class="form-actions">
                    <button type="button" class="edit">Edit</button>
                    <button type="submit" class="save" name = medRecord>Save</button>
                </div>
            </form>
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>