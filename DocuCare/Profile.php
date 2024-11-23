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
    <title>Profile | DocuCare</title>
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
    <?php if($Position == 'Nurse 1' || $Position == 'Nurse 2') { ?>
        <header>
            <h1>Nurse Profile</h1>
        </header>
  
        <section class="profile">
            <div class="profile-container">
                <div class="nurse-profile">
                    <h2>Nurse Details</h2>
                    <div class="profile-info">
                        <img src="img/profile.png" alt="Profile Picture" id="profilePicture">
                        <div class="admin-details">
                            <p><strong>Nurse ID:</strong><span id="NurseID"><?php echo $_SESSION['User_ID'] ?></span></p>
                            <p><strong>Name:</strong> <span id="Name"><?php echo $_SESSION['User_FName'] . ' ' . $_SESSION['User_MName']. ' ' . $_SESSION['User_LName']; ?></span></p>
                            <p><strong>Position/Role:</strong> <span id="Position"><?php echo $_SESSION['Position']?></span></p>
                            <p><strong>Department:</strong> <span id="Department"><?php echo $_SESSION ['Department']?></span></p>
                            <p><strong>Email:</strong> <span id="Email"><?php echo $_SESSION['Email'] ?></span></p>
                            <p><strong>Contact No:</strong> <span id="Contact"><?php echo $_SESSION ['Contact_Num']?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>

        <?php if($Position == 'Admin') { ?>
          <header>
            <h1>Admin Profile</h1>
        </header>

        <section class="profile">
            <div class="profile-container">
                <div class="nurse-profile">
                    <h2>Admin Details</h2>
                    <div class="profile-info">
                        <img src="img/profile.png" alt="Profile Picture" id="profilePicture">
                        <div class="admin-details">
                            <p><strong>Admin ID:</strong><span id="NurseID"><?php echo $_SESSION['User_ID'] ?></span></p>
                            <p><strong>Name:</strong> <span id="Name"><?php echo $_SESSION['User_FName'] . ' ' . $_SESSION['User_MName']. ' ' . $_SESSION['User_LName']; ?></span></p>
                            <p><strong>Position/Role:</strong> <span id="Position"><?php echo $_SESSION['Position']?></span></p>
                            <p><strong>Department:</strong> <span id="Department"><?php echo $_SESSION ['Department']?></span></p>
                            <p><strong>Email:</strong> <span id="Email"><?php echo $_SESSION['Email'] ?></span></p>
                            <p><strong>Contact No:</strong> <span id="Contact"><?php echo $_SESSION ['Contact_Num']?></span></p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <?php } ?>
    </main>

    <script src="main.js"></script>
</body>
</html>