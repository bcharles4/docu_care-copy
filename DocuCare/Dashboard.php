<?php
  session_start();
  include ('counter.php');
  $Position = $_SESSION['Position'];
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css" />
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
        <h1>Dashboard</h1>
      </header>

      <?php if($Position == 'Nurse 1' || $Position == 'Nurse 2') { ?>
      <section class="overview">
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Patients Currently Admitted</h3>
              <p id="totalPatients"><?php echo $TotalPatients?></p>
            </div>
            <img src="img/img1.png" alt="Total Books Image"/>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Patient Admissions Today</h3>
              <p id="AdmissionToday"><?php echo $AdmissionsToday?></p>
            </div>
            <img src="img/img4.png" alt="Genres Image"/>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Occupied Rooms</h3>
              <p id="OccupiedRoom"><?php echo $TotalOccupiedRooms?></p>
            </div>
            <img src="img/img5.png" alt="Authors Image"/>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Vacant Rooms</h3>
              <p id="VacantRoom"><?php echo $TotalAvailableRooms?></p>
            </div>
            <img src="img/img6.png" alt="Users Image"/>
          </div>
        </div>
      </section>
      <?php } ?>

      <?php if($Position == 'Admin') { ?>
      <section class="overview">
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Total Users</h3>
              <p id="totalUsers"><?php echo $TotalPatients?></p>
            </div>
            <img src="img/img1.png" alt="Total Books Image"/>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>New Users Added</h3>
              <p id="usersAdded"><?php echo $AdmissionsToday?></p>
            </div>
            <img src="img/img4.png" alt="Genres Image"/>
          </div>
        </div>
      </section>
      <?php } ?>

      <?php if($Position == 'Nurse 1') { ?>
      <section class="quick-links">
        <h2>Quick Links</h2>
        <ul>
          <li><a href="addPatient.php">Add Patient Info</a></li>
          <li><a href="">View Nurse Schedule</a></li>
        </ul>
      </section>
      <?php } ?>

      <?php if($Position == 'Nurse 2') { ?>
      <section class="quick-links">
        <h2>Quick Links</h2>
        <ul>
        <li><a href="addNurseSched.php">Add Nurse Schedule</a></li>
          <li><a href="roomManagement.php">Add Room</a></li>
        </ul>
      </section>
      <?php } ?>

      <?php if($Position == 'Admin') { ?>
      <section class="quick-links">
        <h2>Quick Links</h2>
        <ul>
        <li><a href="register.php">Add New User</a></li>
          <li><a href="userList.php">View User List</a></li>
        </ul>
      </section>
      <?php } ?>
    </main>

    <script src="main.js"></script>
  </body>
</html>
