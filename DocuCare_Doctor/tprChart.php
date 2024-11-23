<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];
    
    $BaseAPIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=';

    //Fetch Patient ID in the url
    $TargetPatient_ID = $_GET['Patient_ID'];

    $recordsPerPage = 1; 
    include('Queries.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>TPR Graphic Chart | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            <form class="TPR">
                <h1>TPR Graphic Chart</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patient_ID" name="patient_ID" placeholder="Enter patient number" value = "<?php echo htmlspecialchars($PatientInfo['Patient_ID']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="No first name entered." value="<?php echo htmlspecialchars ($PatientInfo['Patient_FName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="No middle name entered." value="<?php echo htmlspecialchars ($PatientInfo['Patient_MName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="No last name entered." value="<?php echo htmlspecialchars ($PatientInfo['Patient_LName']); ?>" readonly>
                        </div>
                        <div class="form-group">
                            <label for="age">AGE:</label>
                            <input type="number" id="age" name="age" placeholder="Enter age" value="<?php echo htmlspecialchars ($PatientInfo['Age']); ?>" readonly>
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
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s" value ="<?php echo htmlspecialchars ($PatientInfo ['Attending_Physician']);?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number" value="<?php echo htmlspecialchars ($PatientInfo['Room_Num']); ?>" readonly>
                        </div>
                    </div> 
                </div>
                
                <?php
                    // Query to count total records
                    $totalQuery = "SELECT COUNT(*) as total FROM  tpr_initial_vitals WHERE Patient_ID = '$TargetPatient_ID'";
                    $totalResult = $connection->query($totalQuery);
                    $totalRow = $totalResult->fetch_assoc();
                    $totalRecords = $totalRow['total'];
                    $totalPages = ceil($totalRecords / $recordsPerPage);

                    echo '<div class="form-row-container">';
                    echo '<h2>INITIAL VITAL SIGNS (ER):</h2>';

                    $hasInitialVitals = !empty($TPRInitialVitalsInfo);
                        if ($hasInitialVitals) {      
                            // Display existing rows starting from page 2
                            foreach ($TPRInitialVitalsInfo as $row) {
                                echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                    echo '<table>';
                                    echo '<tr>';
                                        echo '<td><label for="dateTime">DATE TIME:</label></td>';
                                        echo '<td colspan="3"><input type="datetime-local" id="dateTime" name="dateTime" value="' . htmlspecialchars($row['Initial_Vitals_Date']) . '" readonly></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><label for="bloodPressure">BLOOD PRESSURE:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="bloodPressure" name="bloodPressure" placeholder="mmHg" value="' . htmlspecialchars($row['Blood_Pressure']) . '" readonly></div></td>';
                                        echo '<td colspan="2"><label for="otherData">OTHER DATA:</label></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><label for="pulseRate">PULSE RATE:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="pulseRate" name="pulseRate" placeholder="beats/min" value="' . htmlspecialchars($row['Pulse_Rate']) . '" readonly></div></td>';
                                        echo '<td><label for="weight">WEIGHT:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="weight" name="weight" placeholder="kg" value="' . htmlspecialchars($row['Weight']) . '" readonly></div></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><label for="respiratoryRate">RESPIRATORY RATE:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="respiratoryRate" name="respiratoryRate" placeholder="breaths/min" value="' . htmlspecialchars($row['Respiratory_Rate']) . '" readonly></div></td>';
                                        echo '<td><label for="ie">IE:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="ie" name="ie" placeholder="N/A" value="' . htmlspecialchars($row['IE']) . '" readonly></div></td>';
                                    echo '</tr>';
                                    echo '<tr>';
                                        echo '<td><label for="temperature">TEMPERATURE:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="temperature" name="temperature" placeholder="°C" value="' . htmlspecialchars($row['Temperature']) . '" readonly></div></td>';
                                        echo '<td><label for="fht">FHT:</label></td>';
                                        echo '<td><div class="input-suffix"><input type="text" id="fht" name="fht" placeholder="N/A" value="' . htmlspecialchars($row['FHT']) . '" readonly></div></td>';
                                    echo '</tr>';
                                    echo '</table>';
                                echo '</div>'; // End of table-wrapper
                                echo '</div>';  // End of form-row           
                            }
                        }else{
                             //if there is nothing inside the table
                            echo '<div class="form-row-container">';
                              echo '<div class="form-row no-data-row">';                   
                                echo '<p class="no-data">No Data</p>';
                              echo '</div>';
                            echo '</div>';                 
                            
                        }
                        echo '</div>';// End of form-row-container
                ?>

                <div class="form-row-container">
                <?php
                    $TPRVitalsData = file_get_contents($BaseAPIUrl . 'tpr_vital_signs');
                    $TPRVitalsArray = json_decode($TPRVitalsData, true);

                    // Filter data for the specific patient
                    $TPRVitalsInfo = [];
                    if (is_array($TPRVitalsArray)) {
                        foreach ($TPRVitalsArray as $TPRVitals) {
                            if ($TPRVitals['Patient_ID'] == $TargetPatient_ID) {
                                $TPRVitalsInfo[] = $TPRVitals;
                            }
                        }
                    }

                    $TPRVitalsInfo = array_slice($TPRVitalsInfo, $offset, $recordsPerPage);

                    // Group data by 'Vitals_Date' and 'Day_Number'
                    $GroupedData = [];
                    if (is_array($TPRVitalsInfo)) {
                        foreach ($TPRVitalsInfo as $VitalsInfo) {
                            $Date = $VitalsInfo['Vitals_Date'];
                            $DayNumber = $VitalsInfo['Day_Number'];
                            $time = $VitalsInfo['Vitals_Time_Check'];

                            // Create a unique key for the combination of date and day number
                            $key = $Date . '_' . $DayNumber;

                            // Initialize the array for this key if not already set
                            if (!isset($GroupedData[$key])) {
                                $GroupedData[$key] = [
                                    'date' => $Date,
                                    'day_number' => $DayNumber,
                                    'vitals' => []
                                ];
                            }
                            // Add the vital signs info to the corresponding group
                            $GroupedData[$key]['vitals'][] = $VitalsInfo;
                        }
                    }

                    // Define time slots and match times to slots
                    $timeSlotRanges = [
                        '12 AM - 4 AM' => ['00:00:00', '03:59:59'],
                        '4 AM - 8 AM' => ['04:00:00', '07:59:59'],
                        '8 AM - 12 PM' => ['08:00:00', '11:59:59'],
                        '12 PM - 4 PM' => ['12:00:00', '15:59:59'],
                        '4 PM - 8 PM' => ['16:00:00', '19:59:59'],
                        '8 PM - 12 AM' => ['20:00:00', '23:59:59']
                    ];

                    $hasRecords = false; // Flag to check if there are any records

                    foreach ($GroupedData as $key => $group) {
                        $Date = $group['date'];
                        $DayNumber = $group['day_number'];
                        $vitalsArray = $group['vitals'];

                        // If there are vitals, set the flag to true
                        if (!empty($vitalsArray)) {
                            $hasRecords = true;
                        }

                        // Echo the table structure
                        echo '<div class="form-row">';
                        echo '<div class="table-wrapper">';
                        echo '<table>';
                        echo '<thead>';
                        echo '<tr>';
                        echo '<th>Date</th>';
                        echo '<td><input type="date" name="TPR-date[]" value="' . $Date . '" readonly/></td>';
                        echo '<th>Day No.</th>';
                        echo '<td><input type="number" name="TPR-Day-No[]" value="' . $DayNumber . '" readonly/></td>';
                        echo '</tr>';
                        echo '<tr>';
                        echo '<th>Time Slot</th>';
                        echo '<th>Temperature</th>';
                        echo '<th>Pulse</th>';
                        echo '<th>Respiration</th>';
                        echo '</tr>';
                        echo '</thead>';
                        echo '<tbody>';

                        // Loop over each time slot
                        foreach ($timeSlotRanges as $slot => $range) {
                            echo '<tr>';
                            echo '<td>' . $slot . '</td>';

                            // Find the matching vital signs entry for the current time slot
                            $found = false;
                            foreach ($vitalsArray as $Vitals) {
                                $vitalTime = $Vitals['Vitals_Time_Check']; // Assuming 'Time' is in HH:MM:SS format
                                if ($vitalTime >= $range[0] && $vitalTime <= $range[1]) {
                                    echo '<td><input type="text" name="Temperature[' . $slot . ']" value="' . htmlspecialchars($Vitals['Temperature']) . '" /></td>';
                                    echo '<td><input type="text" name="Pulse[' . $slot . ']" value="' . htmlspecialchars($Vitals['Pulse']) . '" /></td>';
                                    echo '<td><input type="text" name="Respiration[' . $slot . ']" value="' . htmlspecialchars($Vitals['Respiration']) . '" /></td>';
                                    $found = true;
                                    break;
                                }
                            }

                            // If no vital signs entry was found for this time slot, display empty fields
                            if (!$found) {
                                echo '<td><input type="text" name="Temperature[' . $slot . ']" value="" /></td>';
                                echo '<td><input type="text" name="Pulse[' . $slot . ']" value="" /></td>';
                                echo '<td><input type="text" name="Respiration[' . $slot . ']" value="" /></td>';
                            }

                            echo '</tr>';
                        }

                        echo '</tbody>';
                        echo '</table>';
                        echo '</div>';
                        echo '</div>';
                    }

                    // If no records were found, display an empty table
                    if (!$hasRecords) {
                      echo '<div class="form-row-container">';
                        echo '<div class="form-row no-data-row">';                   
                           echo '<p class="no-data">No Data</p>';
                         echo '</div>';
                      echo '</div>';  
                    }
                ?>

                    <div class="form-row">
                        <div class="chartBox-tpr">
                            <canvas class="canva-table" id="tprChart"></canvas>
                        </div>
                    </div>

                    <?php
                        $TPRVitalsOutputData = file_get_contents($BaseAPIUrl . 'tpr_vital_signs_output');
                        $TPRVitalsOutputArray = json_decode($TPRVitalsOutputData, true);
                        
                        $TPRVitalsOutputInfo = [];
                        if (is_array($TPRVitalsOutputArray)) {
                            foreach ($TPRVitalsOutputArray as $TPRVitalsOutput) {
                                if ($TPRVitalsOutput['Patient_ID'] == $TargetPatient_ID) {
                                    $TPRVitalsOutputInfo[] = $TPRVitalsOutput;
                                }
                            }
                        }

                        $TPRVitalsOutputInfo = array_slice($TPRVitalsOutputInfo, $offset, $recordsPerPage);
                        
                        // Array to hold data grouped by date and time slot
                        $dataByDate = [];
                        
                        // Loop through each entry in the fetched output data
                        foreach ($TPRVitalsOutputInfo as $row) {
                            $Date = $row['Date'];
                            $time = $row['Output_Time_Check'];
                            $timeHour = (int)date('G', strtotime($time));
                        
                            // Determine the time slot based on the hour
                            if ($timeHour >= 0 && $timeHour < 4) {
                                $timeSlot = '12 AM - 4 AM';
                            } elseif ($timeHour >= 16 && $timeHour < 20) {
                                $timeSlot = '4 PM - 8 PM';
                            } elseif ($timeHour >= 20 && $timeHour < 24) {
                                $timeSlot = '8 PM - 12 AM';
                            }
                        
                            // Store data in array grouped by date and time slot
                            $dataByDate[$Date][$timeSlot] = [
                                'Blood Pressure' => $row['Blood_Pressure'] ?? 'No data entry',
                                'Urine' => $row['Urine'] ?? 'No data entry',
                                'Stool' => $row['Stool'] ?? 'No data entry',
                                'Output_Time_Check' => $time,
                            ];
                        }                  
                        
                        // Render the table for the fetched and organized data
                        if (!empty($dataByDate)) {
                            foreach ($dataByDate as $Date => $timeSlotData) {
                                echo '<div class="form-row">';
                                echo '<div class="table-wrapper">';
                                echo '<table>';
                                echo '<thead>';
                                echo '<tr>';
                                echo '<th>Metric</th>';
                                echo '<th>12 AM - 4 AM</th>';
                                echo '<th>4 PM - 8 PM</th>';
                                echo '<th>8 PM - 12 AM</th>';
                                echo '</tr>';
                                echo '</thead>';
                                echo '<tbody>';
                                
                                // Metrics for each time slot
                                foreach (['Blood Pressure', 'Urine', 'Stool'] as $metric) {
                                    echo '<tr>';
                                    echo "<td>$metric</td>";
                                    foreach (['12 AM - 4 AM', '4 PM - 8 PM', '8 PM - 12 AM'] as $timeSlot) {
                                        echo '<td>';
                                        if (!empty($timeSlotData[$timeSlot][$metric])) {
                                            echo '<input type="text" placeholder="' . $metric . '" name="' . $metric . '[' . $timeSlot . ']" value="' . htmlspecialchars($timeSlotData[$timeSlot][$metric]) . '" />';
                                        } else {
                                            echo 'No data entry';
                                        }
                                        echo '</td>';
                                    }
                                    echo '</tr>';
                                }
                                echo '</tbody>';
                                echo '</table>';
                                echo '</div>'; // Close table-wrapper
                                echo '</div>'; // Close form-row
                            }
                        } else {
                            //if there is nothing inside the table
                           echo '<div class="form-row-container">';
                              echo '<div class="form-row no-data-row">';                   
                                 echo '<p class="no-data">No Data</p>';
                              echo '</div>';
                           echo '</div>';  
                        }

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
                    ?>
                </div>
            </form>
       </div>
       <?php } ?>
    </main>

    <script src="main.js"></script>

    <script>
    var tprChart;
    var labels = ['12 AM - 4 AM', '4 AM - 8 AM', '8 AM - 12 PM', '12 PM - 4 PM', '4 PM - 8 PM', '8 PM - 12 AM'];
    
    // default empty data for TPR
    var tempData = [0, 0, 0, 0, 0, 0];
    var pulseData = [0, 0, 0, 0, 0, 0];
    var respData = [0, 0, 0, 0, 0, 0];

    function createTPRChart() {
        var ctx = document.getElementById('tprChart').getContext('2d');
        tprChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [
                    {
                        label: 'Temperature',
                        data: tempData,
                        borderColor: 'rgba(54, 162, 235, 1)',
                        backgroundColor: 'rgba(54, 162, 235, 0.2)',
                        borderWidth: 2
                    },
                    {
                        label: 'Pulse',
                        data: pulseData,
                        borderColor: 'rgba(153, 102, 255, 1)',
                        backgroundColor: 'rgba(153, 102, 255, 0.2)',
                        borderWidth: 2
                    },
                    {
                        label: 'Respiration',
                        data: respData,
                        borderColor: 'rgba(255, 99, 132, 1)',
                        backgroundColor: 'rgba(255, 99, 132, 0.2)',
                        borderWidth: 2
                    }
                ]
            },
            options: {
                maintainAspectRatio: false, 
                scales: {
                    y: {
                        beginAtZero: true 
                    }
                }
            }
        });
    }

    // update chart base on user input
    function updateChart() {
        // Fetch TPR values from the input fields
        var tempValues = [
            parseFloat(document.getElementById('time12AMTemp').value) || 0,
            parseFloat(document.getElementById('time4AMTemp').value) || 0,
            parseFloat(document.getElementById('time8AMTemp').value) || 0,
            parseFloat(document.getElementById('time12PMTemp').value) || 0,
            parseFloat(document.getElementById('time4PMTemp').value) || 0,
            parseFloat(document.getElementById('time8PMTemp').value) || 0
        ];

        var pulseValues = [
            parseFloat(document.getElementById('time12AMPulse').value) || 0,
            parseFloat(document.getElementById('time4AMPulse').value) || 0,
            parseFloat(document.getElementById('time8AMPulse').value) || 0,
            parseFloat(document.getElementById('time12PMPulse').value) || 0,
            parseFloat(document.getElementById('time4PMPulse').value) || 0,
            parseFloat(document.getElementById('time8PMPulse').value) || 0
        ];

        var respValues = [
            parseFloat(document.getElementById('time12AMResp').value) || 0,
            parseFloat(document.getElementById('time4AMResp').value) || 0,
            parseFloat(document.getElementById('time8AMResp').value) || 0,
            parseFloat(document.getElementById('time12PMResp').value) || 0,
            parseFloat(document.getElementById('time4PMResp').value) || 0,
            parseFloat(document.getElementById('time8PMResp').value) || 0
        ];

        // Update the chart's dataset values
        tprChart.data.datasets[0].data = tempValues;
        tprChart.data.datasets[1].data = pulseValues;
        tprChart.data.datasets[2].data = respValues;

        tprChart.update();
    }

    // load past data on the chart
    function loadPastData() {
        // Predefined time slots
        const timeSlots = ['12 AM - 4 AM', '4 AM - 8 AM', '8 AM - 12 PM', '12 PM - 4 PM', '4 PM - 8 PM', '8 PM - 12 AM'];
        const temperatureData = [];
        const pulseData = [];
        const respirationData = [];

        timeSlots.forEach(slot => {
            // fetch past data from past inputs 
            const tempValue = document.querySelector(`input[name="Temperature[${slot}]"]`) ? document.querySelector(`input[name="Temperature[${slot}]"]`).value : 0;
            const pulseValue = document.querySelector(`input[name="Pulse[${slot}]"]`) ? document.querySelector(`input[name="Pulse[${slot}]"]`).value : 0;
            const respValue = document.querySelector(`input[name="Respiration[${slot}]"]`) ? document.querySelector(`input[name="Respiration[${slot}]"]`).value : 0;

            // Add data to arrays
            temperatureData.push(parseFloat(tempValue) || 0);
            pulseData.push(parseFloat(pulseValue) || 0);
            respirationData.push(parseFloat(respValue) || 0);
        });

        // Update the chart data with the past values
        tprChart.data.datasets[0].data = temperatureData;
        tprChart.data.datasets[1].data = pulseData;
        tprChart.data.datasets[2].data = respirationData;

        tprChart.update();
    }

     // Initialize the TPR chart
    document.addEventListener('DOMContentLoaded', function() {
        createTPRChart(); 
        loadPastData();

        // Add event listeners to input fields to update the chart in real-time
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('input', updateChart);
        });
    });
</script>

</body>
</html>