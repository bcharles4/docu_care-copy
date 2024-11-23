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
            <form class="IntakeOutput" method="POST" action="intakeOutputScript.php">
                <h1>24 Hours Intake And Output Record</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group short">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value="<?php echo htmlspecialchars ($patient['Patient_FName']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value="<?php echo htmlspecialchars ($patient['Patient_MName']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value="<?php echo htmlspecialchars ($patient['Patient_LName']); ?>" readonly>
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
                
                  $hasAMIO = $resultAMIO ->num_rows > 0;
                  if ($hasAMIO) {
                    // Vital Signs form row when there is data
                    echo '<div class="form-row-container">';
                      while ($row = $resultAMIO->fetch_assoc()) {
                        echo '<div class="form-row auto-input">';
                          // Only display labels if they haven't been displayed yet
                          if (!$labelsDisplayed) {
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
                                    echo '<tr>';
                                        echo '<td rowspan="3"><input type="date" name="date-Intake" value="'. htmlspecialchars($row['Date']) .'" readonly></td>';
                                        echo '<td style="font-weight: bold; color: #000;">AM</td>';
                                        echo '<td><input type="text" name="oral-am" value="'. htmlspecialchars($row['AM_Oral_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="parental-am" value="'. htmlspecialchars($row['AM_Parental_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="other-am" value="'. htmlspecialchars($row['AM_Other_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intake_total-am" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_AM_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="urine-am" value="'. htmlspecialchars($row['AM_Urine_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="stool-am" value="'. htmlspecialchars($row['AM_Stool_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="drainage-am" value="'. htmlspecialchars($row['AM_Drainage_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="output_total-am" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_AM_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intakeOutputremarks-am" value="'. htmlspecialchars($row['AM_Remarks']) .'" readonly></td>';
                                    echo '</tr>';
                                
                                    echo '<tr>';
                                        echo '<td style="font-weight: bold; color: #000;">PM</td>';
                                        echo '<td><input type="text" name="oral-pm" value="'. htmlspecialchars($row['PM_Oral_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="parental-pm" value="'. htmlspecialchars($row['PM_Parental_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="other-pm" value="'. htmlspecialchars($row['PM_Other_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intake_total-pm" style="font-weight: bold;"  value="'. htmlspecialchars($row['Total_PM_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="urine-pm" value="'. htmlspecialchars($row['PM_Urine_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="stool-pm" value="'. htmlspecialchars($row['PM_Stool_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="drainage-pm" value="'. htmlspecialchars($row['PM_Drainage_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="output_total-pm" style="font-weight: bold;"  value="'. htmlspecialchars($row['PM_Total_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intakeOutputremarks-pm" value="'. htmlspecialchars($row['PM_Remarks']) .'" readonly></td>';
                                    echo '</tr>';
                                
                                    echo '<tr>';
                                        echo '<td style="font-weight: bold; color: #000;">NIGHT</td>';
                                        echo '<td><input type="text" name="oral-nt" value="'. htmlspecialchars($row['Night_Oral_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="parental-nt" value="'. htmlspecialchars($row['Night_Parental_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="other-nt" value="'. htmlspecialchars($row['Night_Other_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intake_total-nt" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Night_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="urine-nt" value="'. htmlspecialchars($row['Night_Urine_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="stool-nt" value="'. htmlspecialchars($row['Night_Stool_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="drainage-nt" value="'. htmlspecialchars($row['Night_Drainage_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="output_total-nt" style="font-weight: bold;" value="'. htmlspecialchars($row['Night_Total_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intakeOutputremarks-nt" value="'. htmlspecialchars($row['Night_Remarks']) .'" readonly></td>';
                                    echo '</tr>';

                                    echo '<tr style="font-weight: bold;">';
                                        echo '<td colspan="2" style="color: #000;">TOTAL</td>';
                                        echo '<td><input type="text" name="oral-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Oral_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="parental-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Parental_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="other-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Other_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intake-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Intake']) .'" readonly></td>';
                                        echo '<td><input type="text" name="urine-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Urine_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="stool-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Stool_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="drainage-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Drainage_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="output-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Output']) .'" readonly></td>';
                                        echo '<td><input type="text" name="intakeOutputremarks-total" value="'. htmlspecialchars($row['Total_Remarks']) .'" readonly></td>';
                                    echo '</tr>';
                                    $labelsDisplayed = true; // Sets flag value to true
                          }

                          else{
                            // Display rows without labels
                            echo '<tr>';
                                echo '<td rowspan="3"><input type="date" name="date-Intake" value="'. htmlspecialchars($row['Date']) .'" readonly></td>';
                                echo '<td style="font-weight: bold; color: #000;">AM</td>';
                                echo '<td><input type="text" name="oral-am" value="'. htmlspecialchars($row['AM_Oral_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="parental-am" value="'. htmlspecialchars($row['AM_Parental_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="other-am" value="'. htmlspecialchars($row['AM_Other_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="intake_total-am" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_AM_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="urine-am" value="'. htmlspecialchars($row['AM_Urine_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="stool-am" value="'. htmlspecialchars($row['AM_Stool_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="drainage-am" value="'. htmlspecialchars($row['AM_Drainage_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="output_total-am" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_AM_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="intakeOutputremarks-am" value="'. htmlspecialchars($row['AM_Remarks']) .'" readonly></td>';
                            echo '</tr>';
                        
                            echo '<tr>';
                                echo '<td style="font-weight: bold; color: #000;">PM</td>';
                                echo '<td><input type="text" name="oral-pm" value="'. htmlspecialchars($row['PM_Oral_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="parental-pm" value="'. htmlspecialchars($row['PM_Parental_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="other-pm" value="'. htmlspecialchars($row['PM_Other_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="intake_total-pm" style="font-weight: bold;"  value="'. htmlspecialchars($row['Total_PM_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="urine-pm" value="'. htmlspecialchars($row['PM_Urine_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="stool-pm" value="'. htmlspecialchars($row['PM_Stool_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="drainage-pm" value="'. htmlspecialchars($row['PM_Drainage_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="output_total-pm" style="font-weight: bold;"  value="'. htmlspecialchars($row['PM_Total_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="intakeOutputremarks-pm" value="'. htmlspecialchars($row['PM_Remarks']) .'" readonly></td>';
                            echo '</tr>';
                        
                            echo '<tr>';
                                echo '<td style="font-weight: bold; color: #000;">NIGHT</td>';
                                echo '<td><input type="text" name="oral-nt" value="'. htmlspecialchars($row['Night_Oral_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="parental-nt" value="'. htmlspecialchars($row['Night_Parental_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="other-nt" value="'. htmlspecialchars($row['Night_Other_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="intake_total-nt" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Night_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="urine-nt" value="'. htmlspecialchars($row['Night_Urine_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="stool-nt" value="'. htmlspecialchars($row['Night_Stool_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="drainage-nt" value="'. htmlspecialchars($row['Night_Drainage_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="output_total-nt" style="font-weight: bold;" value="'. htmlspecialchars($row['Night_Total_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="intakeOutputremarks-nt" value="'. htmlspecialchars($row['Night_Remarks']) .'" readonly></td>';
                            echo '</tr>';

                            echo '<tr style="font-weight: bold;">';
                                echo '<td colspan="2" style="color: #000;">TOTAL</td>';
                                echo '<td><input type="text" name="oral-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Oral_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="parental-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Parental_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="other-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Other_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="intake-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Intake']) .'" readonly></td>';
                                echo '<td><input type="text" name="urine-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Urine_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="stool-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Stool_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="drainage-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Drainage_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="output-total" style="font-weight: bold;" value="'. htmlspecialchars($row['Total_Output']) .'" readonly></td>';
                                echo '<td><input type="text" name="intakeOutputremarks-total" value="'. htmlspecialchars($row['Total_Remarks']) .'" readonly></td>';
                            echo '</tr>';
                          }
                        }
                        // Display a row at the bottom
                        echo '<tr>';
                            echo '<td rowspan="3"><input type="date" name="date-Intake"></td>';
                            echo '<td style="font-weight: bold; color: #000;">AM</td>';
                            echo '<td><input type="text" name="oral-am"></td>';
                            echo '<td><input type="text" name="parental-am"></td>';
                            echo '<td><input type="text" name="other-am"></td>';
                            echo '<td><input type="text" name="intake_total-am" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="urine-am"></td>';
                            echo '<td><input type="text" name="stool-am"></td>';
                            echo '<td><input type="text" name="drainage-am"></td>';
                            echo '<td><input type="text" name="output_total-am" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="intakeOutputremarks-am"></td>';
                        echo '</tr>';
                    
                        echo '<tr>';
                            echo '<td style="font-weight: bold; color: #000;">PM</td>';
                            echo '<td><input type="text" name="oral-pm"></td>';
                            echo '<td><input type="text" name="parental-pm"></td>';
                            echo '<td><input type="text" name="other-pm"></td>';
                            echo '<td><input type="text" name="intake_total-pm" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="urine-pm"></td>';
                            echo '<td><input type="text" name="stool-pm"></td>';
                            echo '<td><input type="text" name="drainage-pm"></td>';
                            echo '<td><input type="text" name="output_total-pm" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="intakeOutputremarks-pm"></td>';
                        echo '</tr>';
                    
                        echo '<tr>';
                            echo '<td style="font-weight: bold; color: #000;">NIGHT</td>';
                            echo '<td><input type="text" name="oral-nt"></td>';
                            echo '<td><input type="text" name="parental-nt"></td>';
                            echo '<td><input type="text" name="other-nt"></td>';
                            echo '<td><input type="text" name="intake_total-nt" style="font-weight: bold;"readonly></td>';
                            echo '<td><input type="text" name="urine-nt"></td>';
                            echo '<td><input type="text" name="stool-nt"></td>';
                            echo '<td><input type="text" name="drainage-nt"></td>';
                            echo '<td><input type="text" name="output_total-nt" style="font-weight: bold;"readonly></td>';
                            echo '<td><input type="text" name="intakeOutputremarks-nt"></td>';
                        echo '</tr>';

                        echo '<tr style="font-weight: bold;">';
                            echo '<td colspan="2" style="color: #000;">TOTAL</td>';
                            echo '<td><input type="text" name="oral-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="parental-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="other-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="intake-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="urine-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="stool-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="drainage-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="output-total" style="font-weight: bold;" readonly></td>';
                            echo '<td><input type="text" name="intakeOutputremarks-total"></td>';
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
                                  echo '<tr>';
                                      echo '<td rowspan="3"><input type="date" name="date-Intake"></td>';
                                      echo '<td style="font-weight: bold; color: #000;">AM</td>';
                                      echo '<td><input type="text" name="oral-am"></td>';
                                      echo '<td><input type="text" name="parental-am"></td>';
                                      echo '<td><input type="text" name="other-am"></td>';
                                      echo '<td><input type="text" name="intake_total-am" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="urine-am"></td>';
                                      echo '<td><input type="text" name="stool-am"></td>';
                                      echo '<td><input type="text" name="drainage-am"></td>';
                                      echo '<td><input type="text" name="output_total-am" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="intakeOutputremarks-am"></td>';
                                  echo '</tr>';
                              
                                  echo '<tr>';
                                      echo '<td style="font-weight: bold; color: #000;">PM</td>';
                                      echo '<td><input type="text" name="oral-pm"></td>';
                                      echo '<td><input type="text" name="parental-pm"></td>';
                                      echo '<td><input type="text" name="other-pm"></td>';
                                      echo '<td><input type="text" name="intake_total-pm" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="urine-pm"></td>';
                                      echo '<td><input type="text" name="stool-pm"></td>';
                                      echo '<td><input type="text" name="drainage-pm"></td>';
                                      echo '<td><input type="text" name="output_total-pm" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="intakeOutputremarks-pm"></td>';
                                  echo '</tr>';
                              
                                  echo '<tr>';
                                      echo '<td style="font-weight: bold; color: #000;">NIGHT</td>';
                                      echo '<td><input type="text" name="oral-nt"></td>';
                                      echo '<td><input type="text" name="parental-nt"></td>';
                                      echo '<td><input type="text" name="other-nt"></td>';
                                      echo '<td><input type="text" name="intake_total-nt" style="font-weight: bold;"readonly></td>';
                                      echo '<td><input type="text" name="urine-nt"></td>';
                                      echo '<td><input type="text" name="stool-nt"></td>';
                                      echo '<td><input type="text" name="drainage-nt"></td>';
                                      echo '<td><input type="text" name="output_total-nt" style="font-weight: bold;"readonly></td>';
                                      echo '<td><input type="text" name="intakeOutputremarks-nt"></td>';
                                  echo '</tr>';

                                  echo '<tr style="font-weight: bold;">';
                                      echo '<td colspan="2" style="color: #000;">TOTAL</td>';
                                      echo '<td><input type="text" name="oral-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="parental-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="other-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="intake-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="urine-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="stool-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="drainage-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="output-total" style="font-weight: bold;" readonly></td>';
                                      echo '<td><input type="text" name="intakeOutputremarks-total"></td>';
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
                <button type="submit" name="InOut" class="save">Save</button>
            </div>
        </form>
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>