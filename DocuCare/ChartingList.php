<?php
session_start();
include('mycon.php');
$Position = $_SESSION['Position'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Charting List Dashboard | DocuCare</title>
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
            <h1>Patient Charting Dashboard</h1>
        </header>

        <section class="search">
            <a href="#" class="search-icon"><i class="fas fa-search"></i></a>
            <input type="text" id="searchInput" placeholder="Search patient name or ID here" >     
        </section>

        <section class="search-result">
            <h1>Search Results</h1><hr>
            <div class="box-container" id="patient_infoList">
                <!-- PHP START HERE -->
                <?php
                include('mycon.php');
                $sql = "SELECT * FROM patient_info 
                        JOIN patient_emergency_contact
                        ON patient_info.Patient_ID = patient_emergency_contact.Patient_ID";
                $result = $connection->query($sql);
                echo "<table border='1' width='100%'>";
                echo "<tr align='center' class=tblheader>
                        <td><b>Patient ID</b></td>
                        <td><b>Patient Name</b></td>
                        <td><b>Gender</b></td>
                        <td><b>Primary Physician</b></td>
                        <td><b>Contact</b></td>
                        <td class='no-print'><b>Manage</b></td>
                      </tr>";
                   if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        $Patient_ID = $row['Patient_ID'];
                        echo'<tr>
                                <td>'.$row['Patient_ID'].'</td>
                                <td>'.$row['Patient_FName'].' '.$row['Patient_LName'].'</td>
                                <td>'.$row['Sex'].'</td>
                                <td>'.$row['Attending_Physician'].'</td>
                                <td>'.$row['Emergency_Contact'].'</td>                                  
                                <td>
                                    <input type="button" name="info" value="View Info" class="btn" onclick="window.location.href=\'patientinfo.php?Patient_ID='.$Patient_ID.'\'">
                                    <button class="btn-icon" onclick="window.location.href=\'patientinfo.php?Patient_ID='.$Patient_ID.'\'">
                                          <i class="fas fa-info-circle"></i> 
                                    </button>
                                </td>
                            </tr>';
                    }
                  } else {
                    echo "<tr><td colspan='6' align='center'>No results found.</td></tr>";
                 }
               echo "</table>";
            ?>
            </div>
        </section>
    </main>

    <script src="main.js"></script>
</body>
</html>