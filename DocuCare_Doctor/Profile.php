<?php
session_start();
include('mycon.php');
include('Queries.php');
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
    <?php if($Position == 'Doctor') { ?>
          <header>
            <h1>Doctor Profile</h1>
        </header>

        <section class="profile">
            <div class="profile-container">
                <div class="nurse-profile">
                    <div class="profile-info">
                        <div class="admin-details">
                            <p><strong>Doctor ID:</strong><span id="NurseID"><?php echo $_SESSION['User_ID'] ?></span></p>
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

        <section class="recent">
        <h1>Recently Updated Order</h1><hr>
        <div class="box-container" id="patient_infoList">
        <!-- PHP START HERE -->
        <?php
          include('mycon.php');

          $BaseAPIURL = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';


          $PatientData = file_get_contents($BaseAPIURL . 'patient_info');
          $PatientArray = json_decode($PatientData, true);

          $ContactData = file_get_contents($BaseAPIURL . 'patient_emergency_contact');
          $ContactArray = json_decode($ContactData, true);

          // Combines contact and patient data
          $CombinedPatientData = [];
          if(is_array($PatientArray)){
            foreach($PatientArray as $Patient){
              if(is_array($ContactArray)){
                foreach($ContactArray as $Contact){
                  if ($Patient['Patient_ID'] == $Contact['Patient_ID']){
                    $CombinedPatientData[] = array_merge($Patient, $Contact);
                  }
                }
              }
            }
          }

          $DocOrder_query = "SELECT *
          FROM doctors_order 
          WHERE doctors_order.Status <> 'x'
          ORDER BY Doctor_Order_Date DESC
          LIMIT 3";
          $resultDocOrder = $connection->query($DocOrder_query);
  
          $DoctorOrder = [];// Initialize the array
          if($resultDocOrder){
              while ($row = $resultDocOrder -> fetch_assoc()){
                  $DoctorOrder[] = $row; // Store each row in the DoctorOrder array
              }
          }


          $CombinedData = [];
          if (is_array($DoctorOrder)) {
            foreach ($DoctorOrder as $Order) {
              if (is_array($CombinedPatientData)) {
                foreach ($CombinedPatientData as $Patient) {
                  if ($Patient['Patient_ID'] == $Order['Patient_ID']) {
                      // If a match is found, merge data and add to CombinedData
                      $CombinedData[] = array_merge($Patient, $Order);
                  }
                }
              }
            }
          }
    
           echo "<table id='patientTable' border='1' width='100%'>";
           echo "<tr align='center' class='tblheader'>
                 <td><b>Patient ID</b></td>
                 <td><b>Patient Name</b></td>
                 <td><b>Gender</b></td>
                 <td><b>Primary Physician</b></td>
                 <td><b>Contact</b></td>
                 <td><b>Last Updated</b></td> 
                 <td class='no-print'><b>Manage</b></td>
          </tr>";

          $hasCombinedData = !empty($CombinedData);
          if ($hasCombinedData) {
            foreach ($CombinedData as $row) { 
                 $Patient_ID = $row['Patient_ID'];
                 echo '<tr>
                    <td class="patient-id">' . $row['Patient_ID'] . '</td>
                    <td class="patient-name">' . $row['Patient_FName'] . ' ' . $row['Patient_LName'] . '</td>
                    <td>' . $row['Sex'] . '</td>
                    <td>' . $row['Attending_Physician'] . '</td>
                    <td>' . $row['Emergency_Contact'] . '</td>
                    <td>' . $row['Doctor_Order_Date'] . '</td> 
                    <td>
                        <input type="button" name="info" value="View Info" class="btn" onclick="window.location.href=\'doctorsOrder.php?Patient_ID=' . $Patient_ID . '\'">
                        <button class="btn-icon" onclick="window.location.href=\'doctorsOrder.php?Patient_ID=' . $Patient_ID . '\'">
                            <i class="fas fa-info-circle"></i> 
                        </button>
                    </td>
                  </tr>';
            }     
          }
          else {
           echo "<tr><td colspan='7' align='center'>No recent doctors' orders found.</td></tr>"; 
          }
          echo "</table>";
         ?>
        </div>
      </section>
    <?php } ?>
    </main>

    <script src="main.js"></script>
</body>
</html>