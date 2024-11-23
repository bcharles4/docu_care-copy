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
    <title>Doctor's Order | DocuCare</title>
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
           font-size: 1.4rem;  
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
                   <a href="patientList.php"><span class="material-symbols-outlined">stethoscope</span>Doctor's Order</a>
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
            <form class="doctorsOrder" method="POST" action="doctorsOrderScript.php" class="doctorsOrder">
                <h1>Doctor's Order</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patient_ID" name="patient_ID" placeholder="Enter patient number" value="<?php echo htmlspecialchars($PatientInfo['Patient_ID']); ?>" readonly>
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
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s" value="<?php echo htmlspecialchars($PatientInfo ['Attending_Physician']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number" value="<?php echo htmlspecialchars($PatientInfo['Room_Num']); ?>" readonly>
                        </div>
                    </div> 
                </div>
                
                <?php
                  // Query to count total records
                  $totalQuery = "SELECT COUNT(*) as total 
                  FROM doctors_order 
                  WHERE Patient_ID = '$TargetPatient_ID'";
                  $totalResult = $connection->query($totalQuery);
                  $totalRow = $totalResult->fetch_assoc();
                  $totalRecords = $totalRow['total'];
                  $totalPages = ceil($totalRecords / $recordsPerPage);

                  // Flag used to check if labels have been displayed
                  $labelsDisplayed = false;
                    
                  $hasDocOrder = $resultDocOrder ->num_rows > 0;
                  if ($hasDocOrder) {
                    echo '<div class="form-row-container">';
                      while ($row = $resultDocOrder->fetch_assoc()) {
                        $selectedCheck = $row['Current_Status'];
                        echo '<div class="form-row">';
                          // Only display labels if they haven't been displayed yet
                          if (!$labelsDisplayed) {
                                echo '<div class="table-wrapper">';
                                  echo '<table id="doctors-order-table">';
                                    echo '<thead>';
                                      echo '<tr>';
                                          echo '<th>DATE TIME</th>';
                                          echo '<th>PROGRESS NOTES <br>& CLINICAL OBSERVATION</th>';
                                          echo '<th>DOCTOR\'S ORDER</th>';
                                          echo '<th colspan="5" class="data-action-response">';
                                              echo '<div class="action-labels">';
                                                  echo '<div>C - Carried Out</div>';
                                                  echo '<div>A - Administered / Started</div>';
                                                  echo '<div>R - Requested</div>';
                                                  echo '<div>E - Endorsed</div>';
                                                  echo '<div>D - Discontinued</div>';
                                              echo '</div>';
                                          echo '</th>';
                                      echo '</tr>';                  
                                    echo '</thead>';
                                    echo '<tbody>';

                                      // Add the new row only for the first page
                                      if ($current_page == 1) {
                                        echo '<tr>';
                                        echo '<td><input type="datetime-local" name="date-time-doctorsOrder" placeholder="Date Time"></td>';
                                        echo '<td><textarea name="progress-observation"></textarea></td>';
                                        echo '<td><textarea name="data-doctorsOrder"></textarea></td>';
                                        echo '<td><input type="checkbox" id="checkboxC" name="CARED[]" value="C" class="large-checkbox">C</td>';
                                        echo '<td><input type="checkbox" id="checkboxA" name="CARED[]" value="A" class="large-checkbox">A</td>';
                                        echo '<td><input type="checkbox" id="checkboxR" name="CARED[]" value="R" class="large-checkbox">R</td>';
                                        echo '<td><input type="checkbox" id="checkboxE" name="CARED[]" value="E" class="large-checkbox">E</td>';
                                        echo '<td><input type="checkbox" id="checkboxD" name="CARED[]" value="D" class="large-checkbox">D</td>';
                                        echo '</tr>';
                                      }

                                      echo '<tr>';
                                        echo '<input type="hidden" value="' . htmlspecialchars($row['Doctor_Order_ID']) . '"/>';
                                        echo '<td><input type="datetime-local" placeholder="Date Time" value="'.htmlspecialchars ($row['Doctor_Order_Date']).'" readonly></td>';
                                        echo '<td><textarea readonly>' .htmlspecialchars ($row['Observation_Progress']). '</textarea></td>';
                                        echo '<td><textarea readonly>' .htmlspecialchars ($row['Doctor_Order']). '</textarea></td>';
                                        echo '<td><input type="checkbox" id="checkboxC" value="C" ' . ($selectedCheck == 'C' ? 'checked' : '') . ' disabled class="large-checkbox">C</td>';
                                        echo '<td><input type="checkbox" id="checkboxA" value="A" ' . ($selectedCheck == 'A' ? 'checked' : '') . ' disabled class="large-checkbox">A</td>';
                                        echo '<td><input type="checkbox" id="checkboxR" value="R" ' . ($selectedCheck == 'R' ? 'checked' : '') . ' disabled class="large-checkbox">R</td>';
                                        echo '<td><input type="checkbox" id="checkboxE" value="E" ' . ($selectedCheck == 'E' ? 'checked' : '') . ' disabled class="large-checkbox">E</td>';
                                        echo '<td><input type="checkbox" id="checkboxD" value="D" ' . ($selectedCheck == 'D' ? 'checked' : '') . ' disabled class="large-checkbox">D</td>';
                                        echo '<td>
                                                  <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeleteOrder&Doctor_Order_ID=' . urlencode($row['Doctor_Order_ID']) . '&Patient_ID='. htmlspecialchars($row['Patient_ID']) . '" onclick="return confirm(\'Are you sure you want to delete this record? This cannot be restored.\');">
                                                      <i class="fas fa-trash-alt"></i>
                                                  </a>
                                              </td>';  
                                      echo '</tr>';

                            $labelsDisplayed = true; // Sets flag value to true
                          }
                          else{
                            echo '<tr>';
                              echo '<input type="hidden" value="' . htmlspecialchars($row['Doctor_Order_ID']) . '"/>';
                              echo '<td><input type="datetime-local" placeholder="Date Time" value="'.htmlspecialchars ($row['Doctor_Order_Date']).'" readonly></td>';
                              echo '<td><textarea readonly>' .htmlspecialchars ($row['Observation_Progress']). '</textarea></td>';
                              echo '<td><textarea readonly>' .htmlspecialchars ($row['Doctor_Order']). '</textarea></td>';
                              echo '<td><input type="checkbox" id="checkboxC" value="C" ' . ($selectedCheck == 'C' ? 'checked' : '') . ' disabled class="large-checkbox">C</td>';
                              echo '<td><input type="checkbox" id="checkboxA" value="A" ' . ($selectedCheck == 'A' ? 'checked' : '') . ' disabled class="large-checkbox">A</td>';
                              echo '<td><input type="checkbox" id="checkboxR" value="R" ' . ($selectedCheck == 'R' ? 'checked' : '') . ' disabled class="large-checkbox">R</td>';
                              echo '<td><input type="checkbox" id="checkboxE" value="E" ' . ($selectedCheck == 'E' ? 'checked' : '') . ' disabled class="large-checkbox">E</td>';
                              echo '<td><input type="checkbox" id="checkboxD" value="D" ' . ($selectedCheck == 'D' ? 'checked' : '') . ' disabled class="large-checkbox">D</td>';
                              echo '<td>
                                        <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeleteOrder&Doctor_Order_ID=' . urlencode($row['Doctor_Order_ID']) . '" onclick="return confirm(\'Are you sure you want to delete this record? This cannot be restored.\');">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </td>';  
                            echo '</tr>';
                          }
                        }
                
                        echo '</tbody>';
                        echo '</table>';
                      echo '</div>';
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
                    echo '<div class="form-row-container">';
                        echo '<div class="form-row">';
                            echo '<div class="table-wrapper">';
                                echo '<table id="doctors-order-table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>DATE TIME</th>';
                                            echo '<th>PROGRESS NOTES <br>& CLINICAL OBSERVATION</th>';
                                            echo '<th>DOCTOR\'S ORDER</th>';
                                            echo '<th colspan="5" class="data-action-response">';
                                                echo '<div class="action-labels">';
                                                    echo '<div>C - Carried Out</div>';
                                                    echo '<div>A - Administered / Started</div>';
                                                    echo '<div>R - Requested</div>';
                                                    echo '<div>E - Endorsed</div>';
                                                    echo '<div>D - Discontinued</div>';
                                                echo '</div>';
                                            echo '</th>';
                                        echo '</tr>';                  
                                    echo '</thead>';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td><input type="datetime-local" name="date-time-doctorsOrder" placeholder="Date Time"></td>';
                                            echo '<td><textarea name="progress-observation"></textarea></td>';
                                            echo '<td><textarea name="data-doctorsOrder"></textarea></td>';
                                            echo '<td><input type="checkbox" id="checkboxC" name="CARED[]" value="C" class="large-checkbox">C</td>';
                                            echo '<td><input type="checkbox" id="checkboxA" name="CARED[]" value="A" class="large-checkbox">A</td>';
                                            echo '<td><input type="checkbox" id="checkboxR" name="CARED[]" value="R" class="large-checkbox">R</td>';
                                            echo '<td><input type="checkbox" id="checkboxE" name="CARED[]" value="E" class="large-checkbox">E</td>';
                                            echo '<td><input type="checkbox" id="checkboxD" name="CARED[]" value="D" class="large-checkbox">D</td>';
                                        echo '</tr>';
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                  }
                  
                ?>
                <div class="form-actions">
                    <button type="button" class="edit">Edit</button>
                    <button type="submit" class="save" name = "doctors" >Save</button>
                </div>
            </form>
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>