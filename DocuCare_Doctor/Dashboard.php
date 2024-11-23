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
      <header>
        <h1>Dashboard</h1>
      </header>

      <?php if($Position == 'Doctor') { ?>
        <section class="overview">
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Patients Currently Admitted</h3>
              <p id="totalPatients"><?php echo $TotalPatients?></p>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="card-content">
            <div class="text-content">
              <h3>Patient Admissions Today</h3>
              <p id="AdmissionToday"><?php echo $TotalAdmissionsToday?></p>
            </div>
          </div>
        </div>
      </section>

      <section class="quick-links">
        <h2>Quick Links</h2>
        <ul>
          <li><a href="doctorsOrderList.php">Add Doctor's Order</a></li>
          <li><a href="patientList.php">View Patient Information</a></li>
        </ul>
      </section>
      <?php } ?>

    </main>

    <script src="main.js"></script>
  </body>
</html>
