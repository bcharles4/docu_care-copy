<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];

    // Check if patientID is set in the URL
    if (isset($_GET['Patient_ID'])) {
        $Patient_ID = mysqli_real_escape_string($connection, $_GET['Patient_ID']);
        
        // Query to fetch patient information
        $query = "SELECT * FROM patient_info WHERE Patient_ID = '$Patient_ID'";
        $result = $connection->query($query);
        
        if ($result && $result->num_rows > 0) {
            $patient = $result->fetch_assoc();
        } else {
            echo 'Patient not found.';
            exit;
        }
    
        } else {
        echo 'No patient ID provided.';
        exit;
        }

        include('Queries.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Vital Signs | DocuCare</title>
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

            <!-- Nurse 1 Sidebar-->
            <?php if($Position == 'Nurse 1') { ?>
              <ul class="sidebar-links">
                <h4>
                  <span>Main Menu</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="Dashboard.php" class="active"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                </li>
                <li>
                    <a href="addPatient.php"><span class="material-symbols-outlined">patient_list</span>Patient Information</a>
                </li>
                <li>
                  <a href="ChartingList.php"><span class="material-symbols-outlined">assignment</span>Charting</a>
                </li>
                <li>
                  <a href="ProgressNotesList.php"><span class="material-symbols-outlined">description</span>Progress Notes</a>
                </li>
                <li>
                    <a href="CarePlansList.php"><span class="material-symbols-outlined">assignment_turned_in</span>Care Plans</a>
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

              <!-- Nurse 2 Sidebar-->
              <?php if($Position == 'Nurse 2') { ?>
              <ul class="sidebar-links">
                <h4>
                  <span>Main Menu</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="Dashboard.php" class="active"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                </li>
                <li>
                    <a href="NurseSchedList.php"><span class="material-symbols-outlined">calendar_month</span>Nurse Scheduling</a>
                </li>
                <li>
                    <a href="RoomManageList.php"><span class="material-symbols-outlined">room_preferences</span>Room Management</a>
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

              <!-- Admin Sidebar-->
              <?php if($Position == 'Admin') { ?>
              <ul class="sidebar-links">
                <h4>
                  <span>Main Menu</span>
                  <div class="menu-separator"></div>
                </h4>
                <li>
                  <a href="Dashboard.php" class="active"><span class="material-symbols-outlined">dashboard</span>Dashboard</a>
                </li>
                <li>
                    <a href="userList.php"><span class="material-symbols-outlined">groups</span>User List</a>
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
            <form class="vitalSigns" action="vitalsignScript.php" method="POST">
                <h1>Vital Signs Monitor</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group short">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value = "<?php echo htmlspecialchars ($patient['Patient_FName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value = "<?php echo htmlspecialchars ($patient['Patient_MName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value = "<?php echo htmlspecialchars ($patient['Patient_LName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="age">AGE:</label>
                            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars ($patient['Age']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex">
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($patient['Sex'] == 'Male') echo 'selected'; ?> readonly>Male</option>
                                <option value="Female" <?php if ($patient['Sex'] == 'Female') echo 'selected'; ?> readonly>Female</option>
                                <option value="Other" <?php if ($patient['Sex'] == 'Other') echo 'selected'; ?> readonly>Other</option>
                            </select>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" value="<?php echo htmlspecialchars ($patient['Room_Num']); ?>" readonly>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" value="<?php echo htmlspecialchars ($patient['Attending_Physician']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" name="Patient_ID" value="<?php echo htmlspecialchars($Patient_ID); ?>" readonly>
                        </div>
                    </div> 
                </div>

                <?php
                  // Flag used to check if labels have been displayed
                  $labelsDisplayed = false;
                
                  $hasPatientVitals = $resultPatientVitals ->num_rows > 0;
                  if ($hasPatientVitals) {
                     // Vital Signs form row when there is data
                            echo '<div class="form-row-container">';
                                while ($row = $resultPatientVitals->fetch_assoc()) {
                                  echo '<div class="form-row auto-input">';
                                        // Only display labels if they haven't been displayed yet
                                        if (!$labelsDisplayed) {
                                            echo '<div class="table-wrapper">';
                                              echo '<table>';
                                                  echo '<thead>';
                                                      echo '<tr>';
                                                          echo '<th colspan="10">VITAL SIGNS</th>';
                                                      echo '</tr>';
                                                      echo '<tr>';
                                                          echo '<th>DATE</th>';
                                                          echo '<th>BP</th>';
                                                          echo '<th>RR</th>';
                                                          echo '<th>PR</th>';
                                                          echo '<th>TEMP</th>';
                                                          echo '<th>SPO2</th>';
                                                          echo '<th>WT.</th>';
                                                          echo '<th>PAIN SCALE</th>';
                                                          echo '<th>INTERVENTIONS</th>';
                                                      echo '</tr>';
                                                  echo '</thead>';
                                                  echo '<tbody>';
                                                      echo '<tr>';
                                                          echo '<td><input type="datetime-local" name="date-vitalSign" value="'. htmlspecialchars($row['Vitals_DateTime']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="bp-vitalSign" value="'. htmlspecialchars($row['Blood_Pressure']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="rr-vitalSign" value="'. htmlspecialchars($row['Respiratory_Rate']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="pr-vitalSign" value="'. htmlspecialchars($row['Pulse_Rate']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="temp-vitalSign" value="'. htmlspecialchars($row['Temperature']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="spo2-vitalSign" value="'. htmlspecialchars($row['Oxygen_Lvl']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="wt-vitalSign" value="'. htmlspecialchars($row['Weight']) .'"></td>';
                                                          echo '<td><input type="number" name="pain-vitalSign" min="0" max="10" value="'. htmlspecialchars($row['Pain_Scale']) .'" readonly></td>';
                                                          echo '<td><input type="text" name="interventions-vitalSign" value="'. htmlspecialchars($row['Intervention']) .'" readonly></td>';
                                                      echo '</tr>';
                                            $labelsDisplayed = true; // Sets flag value to true
                                          }

                                          else{
                                            // Display rows without labels
                                                      echo '<tr>';
                                                      echo '<td><input type="datetime-local" name="date-vitalSign" value="'. htmlspecialchars($row['Vitals_DateTime']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="bp-vitalSign" value="'. htmlspecialchars($row['Blood_Pressure']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="rr-vitalSign" value="'. htmlspecialchars($row['Respiratory_Rate']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="pr-vitalSign" value="'. htmlspecialchars($row['Pulse_Rate']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="temp-vitalSign" value="'. htmlspecialchars($row['Temperature']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="spo2-vitalSign" value="'. htmlspecialchars($row['Oxygen_Lvl']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="wt-vitalSign" value="'. htmlspecialchars($row['Weight']) .'"></td>';
                                                      echo '<td><input type="number" name="pain-vitalSign" min="0" max="10" value="'. htmlspecialchars($row['Pain_Scale']) .'" readonly></td>';
                                                      echo '<td><input type="text" name="interventions-vitalSign" value="'. htmlspecialchars($row['Intervention']) .'" readonly></td>';
                                                      echo '</tr>';
                                          }
                                        }
                                        // Display a row at the bottom
                                          echo '<tr>';
                                              echo '<td><input type="datetime-local" name="date-vitalSign"></td>';
                                              echo '<td><input type="text" name="bp-vitalSign"></td>';
                                              echo '<td><input type="text" name="rr-vitalSign"></td>';
                                              echo '<td><input type="text" name="pr-vitalSign"></td>';
                                              echo '<td><input type="text" name="temp-vitalSign"></td>';
                                              echo '<td><input type="text" name="spo2-vitalSign"></td>';
                                              echo '<td><input type="text" name="wt-vitalSign"></td>';
                                              echo '<td><input type="number" name="pain-vitalSign" min="0" max="10"></td>';
                                              echo '<td><input type="text" name="interventions-vitalSign"></td>';
                                          echo '</tr>';
                                        echo '</tbody>';
                                      echo '</table>';
                                    echo '</div>';
                                  echo '</div> <!-- End of .form-row -->';
                            echo '</div> <!-- End of .form-row-container -->';
                  }

                  else{
                    //if there is nothing inside the table
                    echo '<div class="form-row-container">';
                      echo '<div class="form-row auto-input">';
                        if (!$labelsDisplayed) {
                            echo '<div class="table-wrapper">';
                                echo '<table>';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th colspan="10">VITAL SIGNS</th>';
                                        echo '</tr>';
                                        echo '<tr>';
                                            echo '<th>DATE</th>';
                                            echo '<th>BP</th>';
                                            echo '<th>RR</th>';
                                            echo '<th>PR</th>';
                                            echo '<th>TEMP</th>';
                                            echo '<th>SPO2</th>';
                                            echo '<th>WT.</th>';
                                            echo '<th>PAIN SCALE</th>';
                                            echo '<th>INTERVENTIONS</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td><input type="datetime-local" name="date-vitalSign"></td>';
                                            echo '<td><input type="text" name="bp-vitalSign"></td>';
                                            echo '<td><input type="text" name="rr-vitalSign"></td>';
                                            echo '<td><input type="text" name="pr-vitalSign"></td>';
                                            echo '<td><input type="text" name="temp-vitalSign"></td>';
                                            echo '<td><input type="text" name="spo2-vitalSign"></td>';
                                            echo '<td><input type="text" name="wt-vitalSign"></td>';
                                            echo '<td><input type="number" name="pain-vitalSign" min="0" max="10"></td>';
                                            echo '<td><input type="text" name="interventions-vitalSign"></td>';
                                        echo '</tr>';
                                    echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                            $labelsDisplayed = true; // Sets flag value to true
                        }
                      echo '</div> <!-- End of .form-row -->';
                    echo '</div> <!-- End of .form-row-container -->';
                  }
                ?>
                <div class="form-actions">
                    <button type="button" class="edit">Edit</button>
                    <button type="submit" name="Vitals" class="save">Save</button>
                </div>   
        </form>
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>