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
          text-align: center;
          justify-content: center;
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
        <div class="form-container">
            <form class="IVfluid" method="POST" action="ivRecordScript.php">
                <h1>Intravenous Fluid Record</h1>
                <div class="form-row-container">
                    <div class="form-row">
                       <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" name="Patient_ID" value="<?php echo htmlspecialchars($TargetPatient_ID); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_FName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_MName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value="<?php echo htmlspecialchars ($PatientInfo['Patient_LName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="age">AGE:</label>
                            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars ($PatientInfo['Age']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex" disabled>
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($PatientInfo['Sex'] == 'Male') echo 'selected'; ?> readonly>Male</option>
                                <option value="Female" <?php if ($PatientInfo['Sex'] == 'Female') echo 'selected'; ?> readonly>Female</option>
                                <option value="Other" <?php if ($PatientInfo['Sex'] == 'Other') echo 'selected'; ?> readonly>Other</option>
                            </select>
                        </div>

                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" value="<?php echo htmlspecialchars ($PatientInfo['Attending_Physician']); ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" value="<?php echo htmlspecialchars ($PatientInfo['Room_Num']); ?>" readonly>
                        </div>

                    </div> 
                </div>
                
                <?php
                    // Query to count total records
                    $totalQuery = "SELECT COUNT(*) as total FROM ivfr_IV WHERE Patient_ID = '$TargetPatient_ID'";
                    $totalResult = $connection->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalRecords = $totalRow['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                
                    $hasIV = !empty($IVInfo);
                    if ($hasIV) {
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
                                        foreach ($IVInfo as $row){
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
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }else{
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
                                                echo '<td><input type="date" name="date-ivf" readonly></td>';
                                                echo '<td><input type="text" name="bottle-no-ivf" readonly></td>';
                                                echo '<td><input type="text" name="iv-solution-ivf" readonly></td>';
                                                echo '<td><input type="text" name="volume-ivf" readonly></td>';
                                                echo '<td><input type="text" name="incorporation-ivf" readonly></td>';
                                                echo '<td><input type="text" name="regulation-ivf" readonly></td>';
                                                echo '<td><input type="time" name="time-started-ivf" readonly></td>';
                                                echo '<td><input type="datetime-local" name="date-time-consumed-ivf" readonly></td>';
                                                echo '<td><input type="text" name="remark-ivf" readonly></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
   
                ?>
                
                <?php
                 // Query to count total records
                    $totalQuery = "SELECT COUNT(*) as total FROM ivfr_side_drips WHERE Patient_ID = '$TargetPatient_ID'";
                    $totalResult = $connection->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalRecords = $totalRow['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                
                    $hasSD = !empty($SDInfo);
                    if ($hasSD) {
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
                                        foreach($SDInfo as $row){
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
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }else{
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
                                                echo '<td><input type="date" name="date-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="bottle-no-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="iv-solution-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="volume-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="incorporation-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="regulation-sideDrips" readonly></td>';
                                                echo '<td><input type="time" name="time-started-sideDrips" readonly></td>';
                                                echo '<td><input type="datetime-local" name="date-time-consumed-sideDrips" readonly></td>';
                                                echo '<td><input type="text" name="remark-sideDrips" readonly></td>';
                                            echo '</tr>';
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>

                <?php
                    // Query to count total records
                    $totalQuery = "SELECT COUNT(*) as total FROM ivfr_fast_drip WHERE Patient_ID = '$TargetPatient_ID'";
                    $totalResult = $connection->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalRecords = $totalRow['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);
                
                    $hasFDInfo = !empty($FDInfo);
                    if ($hasFDInfo) {
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
                                        foreach($FDInfo as $row){
                                            echo '<tr>';
                                                echo '<td><input type="date" name="date-fastDrip" value="'. htmlspecialchars($row['SFD_Date']) .'" readonly></td>';
                                                echo '<td><input type="text" name="ivf-fastDrip" value="'. htmlspecialchars($row['IVF']) .'" readonly></td>';
                                                echo '<td><input type="text" name="volume-fastDrip" value="'. htmlspecialchars($row['Volume']) .'" readonly></td>';
                                                echo '<td><input type="text" name="incorporation-fastDrip" value="'. htmlspecialchars($row['Incorporation']) .'" readonly></td>';
                                                echo '<td><input type="time" name="time-fastDrip" value="'. htmlspecialchars($row['Time_Taken']) .'" readonly></td>';
                                                echo '<td><input type="text" name="remark-fastDrip" value="'. htmlspecialchars($row['Remarks']) .'" readonly></td>';
                                            echo '</tr>';
                                        }
                                        echo '</tbody>';
                                    echo '</table>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';

                        // Pagination Controls
                      echo '<div class="pagination">';
                      if ($current_page > 1) {
                          echo '<a href="?Patient_ID=' . $Patient_ID . '&page=1"><<</a>';
                          echo '<a href="?Patient_ID=' . $Patient_ID . '&page=' . ($current_page - 1) . '"><</a>';
                      }                  
                      for ($i = 1; $i <= $totalPages; $i++) {
                          if ($i == $current_page) {
                              echo '<strong>' . $i . '</strong>';
                          } else {
                              echo '<a href="?Patient_ID=' . $Patient_ID . '&page=' . $i . '">' . $i . '</a>';
                          }
                      }                         
                      if ($current_page < $totalPages) {
                          echo '<a href="?Patient_ID=' . $Patient_ID . '&page=' . ($current_page + 1) . '">></a>';
                          echo '<a href="?Patient_ID=' . $Patient_ID . '&page=' . $totalPages . '">>></a>';
                      }                     
                      echo '</div>';  

                    }else{
                      //if there is nothing inside the table
                      echo '<div class="form-row-container">';
                        echo '<div class="form-row no-data-row">';                   
                          echo '<p class="no-data">No Data</p>';
                        echo '</div>';
                      echo '</div>';
                    }
                ?>
            </form>
       </div>
       <?php } ?>
    </main>

    <script src="main.js"></script>
</body>
</html>