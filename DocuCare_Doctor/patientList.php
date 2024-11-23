<?php
session_start();
include('mycon.php');
$Position = $_SESSION['Position'];
$User_ID = $_SESSION['User_ID'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient List Dashboard | DocuCare</title>
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
        <header>
            <h1>Patient List Dashboard</h1>
        </header>

        <section class="search">
            <a href="#" class="search-icon"><i class="fas fa-search"></i></a>
            <input type="text" id="searchInput" placeholder="Search patient name or ID here" >  
            <select id="patientTypeFilter" name="patientTypeFilter" onchange="filterPatients()">
                <option value="all">All Patient Types</option>
                <option value="Inpatient">Inpatient</option>
                <option value="Outpatient">Outpatient</option>
            </select>        
        </section>

        <section class="search-result">
            <h1>Search Results</h1><hr>
            <div class="box-container" id="patient_infoList">
                <!-- PHP START HERE -->
            <?php
                include('mycon.php');

                $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';

                
                // Fetch data from patient info table
                $PatientInfoData = file_get_contents($BaseAPIUrl . 'patient_info');
                $PatientInfoArray = json_decode ($PatientInfoData, true);
                
                // Fetch patients handled by the user
                $PatientInfo = [];
                if (is_array($PatientInfoArray)) {
                    foreach ($PatientInfoArray as $Patient) {
                        if ($Patient['Attending_Physician'] == $User_ID) {
                            $PatientInfo[] = $Patient;
                        }
                    }
                }

                // Fetch data from patient user table
                $UserInfoData = file_get_contents($BaseAPIUrl . 'user_tbl');
                $UserInfoArray = json_decode ($UserInfoData, true);

                $DoctorName = [];
                if(is_array($UserInfoArray)){
                  foreach($UserInfoArray as $User){
                    if($User['User_ID'] == $User_ID){
                      $DoctorName = $User['User_FName'] . ' ' . $User['User_LName'];
                    }
                  }
                }


                //Fetch data from patient emergency contacts table
                $EmergencyContactData = file_get_contents($BaseAPIUrl . 'patient_emergency_contact');
                $EmergencyContactArray = json_decode($EmergencyContactData, true);

                // Creat an array that will hold the patient id
                $PatientContact = [];
                if (is_array($EmergencyContactArray)){
                  // Loop each array to 
                  foreach($EmergencyContactArray as $EmergencyContact){
                    $PatientContact [$EmergencyContact['Patient_ID']] = $EmergencyContact;
                  }
                }

                // Get the patient type filter value
                $patientTypeFilter = isset($_GET['patientType']) ? $_GET['patientType'] : '';

                echo "<table id='patientTable' border='1' width='100%'>";
                echo "<tr align='center' class=tblheader>
                        <td><b>Patient ID</b></td>
                        <td><b>Patient Name</b></td>
                        <td><b>Patient Type</b></td>
                        <td><b>Gender</b></td>
                        <td><b>Primary Physician</b></td>
                        <td><b>Contact</b></td>
                        <td class='no-print'><b>Manage</b></td>
                      </tr>";

                if (is_array($PatientInfo) && count($PatientInfo) > 0) {
                  foreach ($PatientInfo as $Patient) {
                      // Sets Patient ID of each patient array
                      $Patient_ID = $Patient['Patient_ID'];
                      $patientType = $Patient['Patient_Type'];

                          // Determine redirect page based on patient type
                          $redirectPage = ($patientType === 'Outpatient') ? 'outpatientInfo.php' : 'inpatientInfo.php';
                          
                          // Retrieve emergency contact if available
                          $EmergencyContact = isset($PatientContact[$Patient_ID]) ? 
                              $PatientContact[$Patient_ID]['Emergency_Contact'] : 
                              'No Contact';

                        echo'<tr>
                                <td class="patient-id">'.$Patient['Patient_ID'].'</td>
                                <td class="patient-name">'.$Patient['Patient_FName'].' '.$Patient['Patient_LName'].'</td>
                                <td class="patient_type">' . $Patient['Patient_Type'] . '</td>
                                <td>'.$Patient['Sex'].'</td>
                                <td>'.$DoctorName.'</td>
                                <td>'.$EmergencyContact.'</td>                                 
                                <td>
                                    <input type="button" name="info" value="View Info" class="btn" onclick="window.location.href=\'' . $redirectPage . '?Patient_ID=' . $Patient_ID . '\'">
                                    <button class="btn-icon" onclick="window.location.href=\'' . $redirectPage . '?Patient_ID=' . $Patient_ID . '\'">
                                       <i class="fas fa-info-circle"></i> 
                                    </button>
                                </td>
                            </tr>';
                  }
                    echo "</table>";
                }
            ?>
            </div>
        </section>
    </main>

    <script src="main.js"></script>

    <script>
      //search bar input
      const searchInput = document.getElementById("searchInput");
      const patientTable = document.getElementById("patientTable");
      const tableRows = patientTable.getElementsByTagName("tr");

      // Listen for input events 
      searchInput.addEventListener("input", function () {
        const searchTerm = searchInput.value.toLowerCase();

        // Loop through all rows in the table 
        for (let i = 1; i < tableRows.length; i++) {
            const row = tableRows[i];
            const patientId = row.getElementsByClassName("patient-id")[0].innerText.toLowerCase();
            const patientName = row.getElementsByClassName("patient-name")[0].innerText.toLowerCase();
            const patientType = row.getElementsByClassName("patient_type")[0].innerText.toLowerCase();

            // Check if the search term is in the Patient ID, Name, Type
            if (patientId.includes(searchTerm) || patientName.includes(searchTerm) || patientType.includes(searchTerm)) {
                row.style.display = ""; // Show row if it matches
            } else {
                row.style.display = "none"; // Hide row if it doesn't match
            }
        }
      });
    </script>
</body>
</html>