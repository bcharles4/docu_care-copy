<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];

    // Check if patientID is set in the URL
    if (isset($_GET['Patient_ID'])) {
    $Patient_ID = mysqli_real_escape_string($connection, $_GET['Patient_ID']);
    
    // Query to fetch patient information
    $query = "SELECT * FROM patient_info 
                        JOIN patient_emergency_contact
                        ON patient_info.Patient_ID = patient_emergency_contact.Patient_ID
                        WHERE patient_info.Patient_ID = '$Patient_ID'";
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
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Room Management List Dashboard | DocuCare</title>
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
        <header>
            <h1>Patient Information</h1>
        </header>

        <section class="profile-container">
            <div class="patient-profile">
                <h2>Patient Details</h2>
                <div class="profile-info">
                    <div class="patient-details">
                        <p><strong>Patient ID:</strong> <span id="Patient_ID"><?php echo htmlspecialchars ($patient['Patient_ID']); ?></span></p>
                        <p><strong>Name:</strong> <span id="Name"><?php echo htmlspecialchars ($patient['Patient_FName']).' '.($patient['Patient_MName']).' '.($patient['Patient_LName']); ?></span></p>
                        <p><strong>Gender:</strong> <span id="Gender"><?php echo htmlspecialchars ($patient['Sex']); ?></span></p>
                        <p><strong>Date of Birth:</strong> <span id="DoB"><?php echo htmlspecialchars ($patient['DoB']);?></span></p>
                        <p><strong>Birthplace:</strong> <span id="Birthplace"><?php echo htmlspecialchars ($patient['Birthplace']);?></span></p>
                        <p><strong>Address:</strong> <span id="Address"><?php echo htmlspecialchars ($patient['Street']).' '.($patient['House_Num']).' '.($patient['Subdivision']).' '.($patient['Barangay']).' '.($patient['City']).' '.($patient['Province']);?></span></p>
                        <p><strong>Emergency Contact:</strong> <span id="Emergency-Contact"><?php echo htmlspecialchars ($patient['Emergency_Contact_Name']); ?></span></p>
                        <p><strong>Contact No.:</strong> <span id="Contact-Num"><?php echo htmlspecialchars ($patient['Emergency_Contact']); ?></span></p>
                    </div>
                </div>
            </div>

            <div class="info-btn">
                <ul>
                    <li><a href="kardex.php?Patient_ID=<?php echo $Patient_ID; ?>">Kardex</a></li>
                    <li><a href="tprChart.php?Patient_ID=<?php echo $Patient_ID; ?>">TPR Graphic Chart</a></li>
                    <li><a href="vitalsign.php?Patient_ID=<?php echo $Patient_ID; ?>">Vital Signs Monitoring</a></li>
                    <li><a href="intakeOutput.php?Patient_ID=<?php echo $Patient_ID; ?>">24 Hours Intake and Output Record</a></li>
                    <li><a href="ivRecord.php?Patient_ID=<?php echo $Patient_ID; ?>">Intravenous Fluid Record</a></li>
                </ul>
            </div>
        </section>
    </main>

    <script src="main.js"></script>
</body>
</html>