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
    <title>IV Fluid Record | DocuCare</title>
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
            <form class="IVfluid" method="POST" action="ivRecordScript.php">
                <h1>Intravenous Fluid Record</h1>
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
                
                    $hasIVRecord = $resultIVRecord ->num_rows > 0;
                    if ($hasIVRecord) {
                     // IV records form row when there is data
                        echo '<div class="form-row-container">';
                            while ($row = $resultIVRecord->fetch_assoc()) {
                                echo '<div class="form-row auto-input">';
                                    // Only display labels if they haven't been displayed yet
                                    if (!$labelsDisplayed) {
                                        echo '<div class="table-wrapper">';
                                            echo '<table id="iv-fluid-table">';
                                                echo '<thead>';
                                                    echo '<tr class="table-header">';
                                                        echo '<th colspan="9">I. INTRAVENOUS FLUID RECORD</th>';
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                        echo '<th>Date</th>';
                                                        echo '<th>Bottle No</th>';
                                                        echo '<th>IV Solution</th>';
                                                        echo '<th>Volume</th>';
                                                        echo '<th>Incorporation</th>';
                                                        echo '<th>Regulation</th>';
                                                        echo '<th>Time Started</th>';
                                                        echo '<th>Date/Time Consumed</th>';
                                                        echo '<th>Remark</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                    echo '<tr>';
                                                        echo '<td><input type="date" name="date-ivf" value="'. htmlspecialchars($row['IV_Date']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="bottle-no-ivf" value="'. htmlspecialchars($row['Bottle_No']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="iv-solution-ivf" value="'. htmlspecialchars($row['IV_Solution']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="volume-ivf" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="incorporation-ivf" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="regulation-ivf" value="'. htmlspecialchars($row['Regulation']) .'" readonly></td>';
                                                        echo '<td><input type="time" name="time-started-ivf" value="'. htmlspecialchars($row['Start_Time']) .'" readonly></td>';
                                                        echo '<td><input type="datetime-local" name="date-time-consumed-ivf" value="'. htmlspecialchars($row['Time_End']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="remark-ivf" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                                    echo '</tr>';
                                                $labelsDisplayed = true; // Sets flag value to true
                                    }

                                    else{
                                        // Display rows without labels
                                        echo '<tr>';
                                            echo '<td><input type="date" name="date-ivf" value="'. htmlspecialchars($row['IV_Date']) .'" readonly></td>';
                                            echo '<td><input type="text" name="bottle-no-ivf" value="'. htmlspecialchars($row['Bottle_No']) .'" readonly></td>';
                                            echo '<td><input type="text" name="iv-solution-ivf" value="'. htmlspecialchars($row['IV_Solution']) .'" readonly></td>';
                                            echo '<td><input type="text" name="volume-ivf" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                            echo '<td><input type="text" name="incorporation-ivf" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                            echo '<td><input type="text" name="regulation-ivf" value="'. htmlspecialchars($row['Regulation']) .'" readonly></td>';
                                            echo '<td><input type="time" name="time-started-ivf" value="'. htmlspecialchars($row['Start_Time']) .'" readonly></td>';
                                            echo '<td><input type="datetime-local" name="date-time-consumed-ivf" value="'. htmlspecialchars($row['Time_End']) .'" readonly></td>';
                                            echo '<td><input type="text" name="remark-ivf" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                        echo '</tr>';
                                    } 
                            }
                                // Display a row at the bottom
                                echo '<tr>';
                                    echo '<td><input type="date" name="date-ivf"></td>';
                                    echo '<td><input type="text" name="bottle-no-ivf"></td>';
                                    echo '<td><input type="text" name="iv-solution-ivf"></td>';
                                    echo '<td><input type="text" name="volume-ivf"></td>';
                                    echo '<td><input type="text" name="incorporation-ivf"></td>';
                                    echo '<td><input type="text" name="regulation-ivf"></td>';
                                    echo '<td><input type="time" name="time-started-ivf"></td>';
                                    echo '<td><input type="datetime-local" name="date-time-consumed-ivf"></td>';
                                    echo '<td><input type="text" name="remark-ivf"></td>';
                                echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    }

                    else{
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row auto-input">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="iv-fluid-table">';
                                        echo '<thead>';
                                            echo '<tr class="table-header">';
                                                echo '<th colspan="9">I. INTRAVENOUS FLUID RECORD</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>Bottle No</th>';
                                                echo '<th>IV Solution</th>';
                                                echo '<th>Volume</th>';
                                                echo '<th>Incorporation</th>';
                                                echo '<th>Regulation</th>';
                                                echo '<th>Time Started</th>';
                                                echo '<th>Date/Time Consumed</th>';
                                                echo '<th>Remark</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><input type="date" name="date-ivf"></td>';
                                                echo '<td><input type="text" name="bottle-no-ivf"></td>';
                                                echo '<td><input type="text" name="iv-solution-ivf"></td>';
                                                echo '<td><input type="text" name="volume-ivf"></td>';
                                                echo '<td><input type="text" name="incorporation-ivf"></td>';
                                                echo '<td><input type="text" name="regulation-ivf"></td>';
                                                echo '<td><input type="time" name="time-started-ivf"></td>';
                                                echo '<td><input type="datetime-local" name="date-time-consumed-ivf"></td>';
                                                echo '<td><input type="text" name="remark-ivf"></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                    
                ?>
                
                <?php
                    // Flag used to check if labels have been displayed
                    $labelsDisplayed = false;
                
                    $hasSideDripRecord = $resultSideDripRecord ->num_rows > 0;
                    if ($hasSideDripRecord) {
                     // SD records form row when there is data
                        echo '<div class="form-row-container">';
                            while ($row = $resultSideDripRecord->fetch_assoc()) {
                                echo '<div class="form-row auto-input">';
                                    // Only display labels if they haven't been displayed yet
                                    if (!$labelsDisplayed) {
                                        echo '<div class="table-wrapper">';
                                            echo '<table id="side-drips-table">';
                                                echo '<thead>';
                                                    echo '<tr class="table-header">';
                                                        echo '<th colspan="9">II. SIDE DRIPS</th>';
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                        echo '<th>Date</th>';
                                                        echo '<th>Bottle No</th>';
                                                        echo '<th>IV Solution</th>';
                                                        echo '<th>Volume</th>';
                                                        echo '<th>Incorporation</th>';
                                                        echo '<th>Regulation</th>';
                                                        echo '<th>Time Started</th>';
                                                        echo '<th>Date/Time Consumed</th>';
                                                        echo '<th>Remark</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                    echo '<tr>';
                                                        echo '<td><input type="date" name="date-sideDrips" value="'. htmlspecialchars($row['SD_Date']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="bottle-no-sideDrips" value="'. htmlspecialchars($row['Bottle_No']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="iv-solution-sideDrips" value="'. htmlspecialchars($row['IV_Solution']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="volume-sideDrips" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="incorporation-sideDrips" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="regulation-sideDrips" value="'. htmlspecialchars($row['Regulation']) .'" readonly></td>';
                                                        echo '<td><input type="time" name="time-started-sideDrips" value="'. htmlspecialchars($row['Start_Time']) .'" readonly></td>';
                                                        echo '<td><input type="datetime-local" name="date-time-consumed-sideDrips" value="'. htmlspecialchars($row['Time_End']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="remark-sideDrips" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                                    echo '</tr>';
                                                $labelsDisplayed = true; // Sets flag value to true
                                    }

                                    else{
                                        // Display rows without labels
                                        echo '<tr>';
                                            echo '<td><input type="date" name="date-sideDrips" value="'. htmlspecialchars($row['SD_Date']) .'" readonly></td>';
                                            echo '<td><input type="text" name="bottle-no-sideDrips" value="'. htmlspecialchars($row['Bottle_No']) .'" readonly></td>';
                                            echo '<td><input type="text" name="iv-solution-sideDrips" value="'. htmlspecialchars($row['IV_Solution']) .'" readonly></td>';
                                            echo '<td><input type="text" name="volume-sideDrips" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                            echo '<td><input type="text" name="incorporation-sideDrips" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                            echo '<td><input type="text" name="regulation-sideDrips" value="'. htmlspecialchars($row['Regulation']) .'" readonly></td>';
                                            echo '<td><input type="time" name="time-started-sideDrips" value="'. htmlspecialchars($row['Start_Time']) .'" readonly></td>';
                                            echo '<td><input type="datetime-local" name="date-time-consumed-sideDrips" value="'. htmlspecialchars($row['Time_End']) .'" readonly></td>';
                                            echo '<td><input type="text" name="remark-sideDrips" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                        echo '</tr>';
                                    } 
                            }
                                // Display a row at the bottom
                                echo '<tr>';
                                    echo '<td><input type="date" name="date-sideDrips"></td>';
                                    echo '<td><input type="text" name="bottle-no-sideDrips"></td>';
                                    echo '<td><input type="text" name="iv-solution-sideDrips"></td>';
                                    echo '<td><input type="text" name="volume-sideDrips"></td>';
                                    echo '<td><input type="text" name="incorporation-sideDrips"></td>';
                                    echo '<td><input type="text" name="regulation-sideDrips"></td>';
                                    echo '<td><input type="time" name="time-started-sideDrips"></td>';
                                    echo '<td><input type="datetime-local" name="date-time-consumed-sideDrips"></td>';
                                    echo '<td><input type="text" name="remark-sideDrips"></td>';
                                echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    }

                    else{
                        //if there is nothing inside the table
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row auto-input">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="side-drips-table">';
                                        echo '<thead>';
                                            echo '<tr class="table-header">';
                                                echo '<th colspan="9">II. SIDE DRIPS</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>Bottle No</th>';
                                                echo '<th>IV Solution</th>';
                                                echo '<th>Volume</th>';
                                                echo '<th>Incorporation</th>';
                                                echo '<th>Regulation</th>';
                                                echo '<th>Time Started</th>';
                                                echo '<th>Date/Time Consumed</th>';
                                                echo '<th>Remark</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><input type="date" name="date-sideDrips"></td>';
                                                echo '<td><input type="text" name="bottle-no-sideDrips"></td>';
                                                echo '<td><input type="text" name="iv-solution-sideDrips"></td>';
                                                echo '<td><input type="text" name="volume-sideDrips"></td>';
                                                echo '<td><input type="text" name="incorporation-sideDrips"></td>';
                                                echo '<td><input type="text" name="regulation-sideDrips"></td>';
                                                echo '<td><input type="time" name="time-started-sideDrips"></td>';
                                                echo '<td><input type="datetime-local" name="date-time-consumed-sideDrips"></td>';
                                                echo '<td><input type="text" name="remark-sideDrips"></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>

                <?php
                    // Flag used to check if labels have been displayed
                    $labelsDisplayed = false;
                
                    $hasFastDripRecord = $resultFastDripRecord ->num_rows > 0;
                    if ($hasFastDripRecord) {
                     // Vital Signs form row when there is data
                        echo '<div class="form-row-container">';
                            while ($row = $resultFastDripRecord->fetch_assoc()) {
                                echo '<div class="form-row auto-input">';
                                    // Only display labels if they haven't been displayed yet
                                    if (!$labelsDisplayed) {
                                        echo '<div class="table-wrapper">';
                                            echo '<table id="fast-drip-table">';
                                                echo '<thead>';
                                                    echo '<tr class="table-header">';
                                                        echo '<th colspan="6">III. STAT FAST DRIP</th>';
                                                    echo '</tr>';
                                                    echo '<tr>';
                                                        echo '<th>Date</th>';
                                                        echo '<th>IVF</th>';
                                                        echo '<th>Volume</th>';
                                                        echo '<th>Incorporation</th>';
                                                        echo '<th>Time</th>';
                                                        echo '<th>Remark</th>';
                                                    echo '</tr>';
                                                echo '</thead>';
                                                echo '<tbody>';
                                                    echo '<tr>';
                                                        echo '<td><input type="date" name="date-fastDrip" value="'. htmlspecialchars($row['SFD_Date']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="ivf-fastDrip" value="'. htmlspecialchars($row['IVF']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="volume-fastDrip" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="incorporation-fastDrip" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                                        echo '<td><input type="time" name="time-fastDrip" value="'. htmlspecialchars($row['Time_Taken']) .'" readonly></td>';
                                                        echo '<td><input type="text" name="remark-fastDrip" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                                    echo '</tr>';
                                                $labelsDisplayed = true; // Sets flag value to true
                                    }

                                    else{
                                        // Display rows without labels
                                        echo '<tr>';
                                            echo '<td><input type="date" name="date-fastDrip" value="'. htmlspecialchars($row['SFD_Date']) .'" readonly></td>';
                                            echo '<td><input type="text" name="ivf-fastDrip" value="'. htmlspecialchars($row['IVF']) .'" readonly></td>';
                                            echo '<td><input type="text" name="volume-fastDrip" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                            echo '<td><input type="text" name="incorporation-fastDrip" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                            echo '<td><input type="time" name="time-fastDrip" value="'. htmlspecialchars($row['Time_Taken']) .'" readonly></td>';
                                            echo '<td><input type="text" name="remark-fastDrip" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                        echo '</tr>';
                                    } 
                            }
                                // Display a row at the bottom
                                    echo '<tr>';
                                        echo '<td><input type="date" name="date-fastDrip"></td>';
                                        echo '<td><input type="text" name="ivf-fastDrip"></td>';
                                        echo '<td><input type="text" name="volume-fastDrip"></td>';
                                        echo '<td><input type="text" name="incorporation-fastDrip"></td>';
                                        echo '<td><input type="time" name="time-fastDrip"></td>';
                                        echo '<td><input type="text" name="remark-fastDrip"></td>';
                                    echo '</tr>';
                                echo '</tbody>';
                                echo '</table>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                    }

                    else{
                        //if there is nothing inside the table
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row auto-input">';
                                echo '<div class="table-wrapper">';
                                    echo '<table id="fast-drip-table">';
                                        echo '<thead>';
                                            echo '<tr class="table-header">';
                                                echo '<th colspan="6">III. STAT FAST DRIP</th>';
                                            echo '</tr>';
                                            echo '<tr>';
                                                echo '<th>Date</th>';
                                                echo '<th>IVF</th>';
                                                echo '<th>Volume</th>';
                                                echo '<th>Incorporation</th>';
                                                echo '<th>Time</th>';
                                                echo '<th>Remark</th>';
                                            echo '</tr>';
                                        echo '</thead>';
                                        echo '<tbody>';
                                            echo '<tr>';
                                                echo '<td><input type="date" name="date-fastDrip"></td>';
                                                echo '<td><input type="text" name="ivf-fastDrip"></td>';
                                                echo '<td><input type="text" name="volume-fastDrip"></td>';
                                                echo '<td><input type="text" name="incorporation-fastDrip"></td>';
                                                echo '<td><input type="time" name="time-fastDrip"></td>';
                                                echo '<td><input type="text" name="remark-fastDrip"></td>';
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
                    <button type="submit" name="IVRecord" class="save">Save</button>
                </div>
            </form>
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>