<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];
    $User_ID = $_SESSION['User_ID'];
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

    include('QueriesDoctor.php');

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Standing Order | DocuCare</title>
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

        .form-actions {
            display: flex;
            justify-content: flex-end;
            margin-top: 20px;
        }

        .form-actions button {
            padding: 10px 20px;
            margin-left: 10px;
            border: none;
            border-radius: 5px;
            font-size: 1rem;
            cursor: pointer;
        }

        .form-actions .edit {
            background-color: #f0ad4e;
            color: #fff;
        }

        .form-actions .save {
            background-color: #5cb85c;
            color: #fff;
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
        <div class="form-container">
        <form class="standingOrder" method = "POST" action = "standingOrderScript.php">
                <h1>Standing Orders</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patient_ID" name="patient_ID" placeholder="Enter patient number" value="<?php echo htmlspecialchars($PatientInfo['Patient_ID']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name" value="<?php echo htmlspecialchars($PatientInfo['Patient_FName']);?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name" value="<?php echo htmlspecialchars($PatientInfo['Patient_MName'])?>">
                        </div>
                        <div class="form-group">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name" value="<?php echo htmlspecialchars($PatientInfo['Patient_LName']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="age">AGE:</label>
                            <input type="number" id="age" name="age" placeholder="Enter age" value="<?php echo htmlspecialchars($PatientInfo['Age']);?>">
                        </div>
                        <div class="form-group">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex">
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($PatientInfo['Sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($PatientInfo['Sex'] == 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($PatientInfo ['Sex'] == 'Other') echo 'selected' ?>>Other</option>
                            </select>
                        </div>
                    
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s" value="<?php echo htmlspecialchars($PatientInfo ['Attending_Physician']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number" value="<?php echo htmlspecialchars($PatientInfo['Room_Num']); ?>">
                        </div>
                    </div> 
                </div>
                <?php
                    // Fetch data from the API
                    $StandingOrderData = file_get_contents($BaseAPIUrl . 'standing_order_response');
                    $StandingOrderArray = json_decode($StandingOrderData, true);
                    
                    $StandingOrderInfo = [];
                    if (is_array($StandingOrderArray)) {
                        foreach ($StandingOrderArray as $StandingResponse) {
                            if ($StandingResponse['Patient_ID'] == $TargetPatient_ID) {
                                $StandingOrderInfo[] = $StandingResponse;
                            }
                        }
                    }

                    $CombinedData = [];
                    if (is_array($StandingOrder)) {
                        foreach ($StandingOrder as $Order) {
                            $matched = false;
                            if (is_array($StandingOrderInfo)) {
                                foreach ($StandingOrderInfo as $Response) {
                                    if ($Response['Standing_Order_ID'] == $Order['Standing_Order_ID']) {
                                        // If a match is found, merge data and add to CombinedData
                                        $CombinedData[] = array_merge($Response, $Order);
                                        $matched = true;
                                    }
                                }
                            }
                            if (!$matched) {
                                // If no match is found, add the order with empty response fields
                                $Order['Date_Ordered'] = $Order['Date_Ordered'] ?? '';
                                $Order['Order'] = $Order['Order'] ?? '';
                                $Order['Order_Start_Date'] = '';
                                $Order['Order_Discontinued_Date'] = '';
                                $Order['Remarks'] = '';
                                $CombinedData[] = $Order;
                            }
                        }
                    }

                    // Query to count total records
                    $totalQuery = "SELECT COUNT(*) as total FROM  standing_order WHERE Patient_ID = '$TargetPatient_ID'";
                    $totalResult = $connection->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalRecords = $totalRow['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    // Check if there are any standing orders for the patient
                    $hasStandingOrder = !empty($StandingOrder);
                    if ($hasStandingOrder) {
                        echo '<div class="form-row-container">';
                          echo '<div class="table-wrapper">';
                            echo '<table id="standing-order-table">';
                              echo '<thead>';
                                echo '<tr>';
                                  echo '<th>DATE ORDERED</th>';
                                  echo '<th>MEDICATION/IVF/IV DRIPS/DIET</th>';
                                  echo '<th>DATE STARTED</th>';
                                  echo '<th>DATE DISCONTINUED</th>';
                                  echo '<th>REMARKS</th>';
                                  echo '<th>ACTION</th>';
                                echo '</tr>';
                              echo '</thead>';
                              echo '<tbody>';
                        if ($current_page == 1) {
                            echo '<tr>';
                              echo '<td><input type="date" name="date_ordered-stdOrder"></td>';
                              echo '<td><input type="text" name="medication-stdOrder"></td>';
                              echo '<td><input type="date" name="date_started-stdOrder" readonly></td>';
                              echo '<td><input type="date" name="date_discontinued-stdOrder" readonly></td>';
                              echo '<td><input type="text" name="remarks-stdOrder" readonly></td>';
                              echo '<td></td>';
                            echo '</tr>';
                        }
                        foreach ($CombinedData as $row) { 
                            echo '<tr>';
                              echo '<input type="hidden" value="'.htmlspecialchars($row['Standing_Order_ID']).'" readonly>';
                              echo '<td><input type="date" value="'.htmlspecialchars($row['Date_Ordered']).'" readonly></td>';
                              echo '<td><input type="text" value="'.htmlspecialchars($row['Order']).'" readonly></td>';
                              echo '<td><input type="date" value="'.htmlspecialchars($row['Order_Start_Date']).'" readonly></td>';
                              echo '<td><input type="date" value="'.htmlspecialchars($row['Order_Discontinued_Date']).'" readonly></td>';
                              echo '<td><input type="text" value="'.htmlspecialchars($row['Remarks']).'" readonly></td>';
                              echo '<td>
                                      <a class="remove-row-button" href="DoctorDeletionQueries.php?act=DeleteStandingOrder&Patient_ID=' . urlencode($TargetPatient_ID) . '&Standing_Order_ID=' . urlencode($row['Standing_Order_ID']). '" onclick="return confirm(\'Are you sure you want to delete this record? This cannot be undone.\');">
                                          <i class="fas fa-trash-alt"></i>
                                      </a>
                                    </td>';
                            echo '</tr>';
                        }
                              echo '</tbody>';
                            echo '</table>';
                          echo '</div>';
                        echo '</div>';

                        // Pagination Controls
                        echo '<div class="pagination">';
                        if ($current_page > 1) {
                            echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=1"><<</a>';
                            echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . ($current_page - 1) . '"><</a>';
                        }
                        for ($i = 1; $i <= $totalPages; $i++) {
                            if ($i == $current_page) {
                                echo '<strong>' . $i . '</strong>';
                            } else {
                                echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . $i . '">' . $i . '</a>';
                            }
                        }
                        if ($current_page < $totalPages) {
                            echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . ($current_page + 1) . '">></a>';
                            echo '<a href="?Patient_ID=' . $TargetPatient_ID . '&page=' . $totalPages . '">>></a>';
                        }
                        echo '</div>';
                    } else {
                        // Display empty table message
                        echo '<div class="form-row-container">';
                        echo '<div class="form-row">';
                            echo '<div class="table-wrapper">';
                                echo '<table id="standing-order-table">';
                                    echo '<thead>';
                                        echo '<tr>';
                                            echo '<th>DATE ORDERED</th>';
                                            echo '<th>MEDICATION/IVF/IV DRIPS/DIET</th>';
                                            echo '<th>DATE STARTED</th>';
                                            echo '<th>DATE DISCONTINUED</th>';
                                            echo '<th>REMARKS</th>';
                                        echo '</tr>';
                                    echo '</thead>';
                                    echo '<tbody>';
                                        echo '<tr>';
                                            echo '<td><input type="date" name="date_ordered-stdOrder"></td>';
                                            echo '<td><input type="text" name="medication-stdOrder"></td>';
                                            echo '<td><input type="date" name="date_started-stdOrder" readonly></td>';
                                            echo '<td><input type="date" name="date_discontinued-stdOrder" readonly></td>';
                                            echo '<td><input type="text" name="remarks-stdOrder" readonly></td>';
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
                    <button type="submit" class="save" name="STD">Save</button>
                </div>
            </form> 
       </div>
    </main>

    <script src="main.js"></script>
</body>
</html>
