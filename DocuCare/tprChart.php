<?php
session_start();
include('mycon.php');
$Position = $_SESSION['Position'];

// Check if patientID is set in the URL
if (isset($_GET['Patient_ID'])) {
    $Patient_ID = mysqli_real_escape_string($connection, $_GET['Patient_ID']);
    
    // Query to fetch patient information
    $query = "SELECT * FROM patient_info WHERE Patient_ID = '$Patient_ID'";
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

//if form submission is successful
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    echo '<script>alert("Successfully Saved!");</script>';
}
include('KardexQueries.php');
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

        canvas {
            max-width: 100%;
            min-width: 200px; 
            min-height: 200px; 
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
        <div class="form-container">
            <form class="TPR">
                <h1>TPR Graphic Chart</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group short">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="No first name entered." value="<?php echo htmlspecialchars ($patient['Patient_FName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="No middle name entered." value="<?php echo htmlspecialchars ($patient['Patient_MName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="No last name entered." value="<?php echo htmlspecialchars ($patient['Patient_LName']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="age">AGE:</label>
                            <input type="number" id="age" name="age" placeholder="Enter age">
                        </div>
                        <div class="form-group short">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex">
                                <option value="">Select sex</option>
                                <option value="Male">Male</option>
                                <option value="Female">Female</option>
                                <option value="Other">Other</option>
                            </select>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number">
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s">
                        </div>
                        <div class="form-group short">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patient_ID" name="patient_ID" placeholder="Enter patient number">
                        </div>
                    </div> 
                </div>

                <div class="form-row-container">
                    <h2>INITIAL VITAL SIGNS (ER):</h2>
                    <div class="form-row">
                        <div class="table-wrapper">
                            <table>
                                <tr>
                                  <td><label for="dateTime">DATE TIME:</label></td>
                                  <td colspan="3"><input type="datetime-local" id="dateTime" name="dateTime"></td>
                                </tr>
                                <tr>
                                  <td><label for="bloodPressure">BLOOD PRESSURE:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="bloodPressure" name="bloodPressure" placeholder="mmHg"></div></td>
                                  <td colspan="2"><label for="otherData">OTHER DATA:</label></td>
                                </tr>
                                <tr>
                                  <td><label for="pulseRate">PULSE RATE:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="pulseRate" name="pulseRate" placeholder="beats/min"></div></td>
                                  <td><label for="weight">WEIGHT:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="weight" name="weight" placeholder="kg"></div></td>
                                </tr>
                                <tr>
                                  <td><label for="respiratoryRate">RESPIRATORY RATE:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="respiratoryRate" name="respiratoryRate" placeholder="breaths/min"></div></td>
                                  <td><label for="ie">IE:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="ie" name="ie" placeholder="cm"></div></td>
                                </tr>
                                <tr>
                                  <td><label for="temperature">TEMPERATURE:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="temperature" name="temperature" placeholder="°C"></div></td>
                                  <td><label for="fht">FHT:</label></td>
                                  <td><div class="input-suffix"><input type="text" id="fht" name="fht" placeholder="beats/min"></div></td>
                                </tr>
                              </table>
                        </div>
                    </div>  
                </div>

                <div class="form-row-container">
                    <div class="form-row">
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <td><input type="date" name="TPR-date" /></td>  
                                        <th>Day No.</th>
                                        <td><input type="number" name="TPR-Day-No" /></td>    
                                    </tr>
                                    <tr>
                                        <th>Time</th>
                                        <th>Temperature</th>
                                        <th>Pulse</th>
                                        <th>Respiration</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>12 AM</td>
                                        <td><input type="text" id="time12AMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time12AMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time12AMResp" placeholder="Respiration"></td>
                                    </tr>
                                    <tr>
                                        <td>4 AM</td>
                                        <td><input type="text" id="time4AMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time4AMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time4AMResp" placeholder="Respiration"></td>
                                    </tr>
                                    <tr>
                                        <td>8 AM</td>
                                        <td><input type="text" id="time8AMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time8AMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time8AMResp" placeholder="Respiration"></td>
                                    </tr>
                                    <tr>
                                        <td>12 PM</td>
                                        <td><input type="text" id="time12PMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time12PMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time12PMResp" placeholder="Respiration"></td>
                                    </tr>
                                    <tr>
                                        <td>4 PM</td>
                                        <td><input type="text" id="time4PMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time4PMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time4PMResp" placeholder="Respiration"></td>
                                    </tr>
                                    <tr>
                                        <td>8 PM</td>
                                        <td><input type="text" id="time8PMTemp" placeholder="Temperature"></td>
                                        <td><input type="text" id="time8PMPulse" placeholder="Pulse"></td>
                                        <td><input type="text" id="time8PMResp" placeholder="Respiration"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="table-wrapper">
                            <canvas id="tprChart" width="800" height="400"></canvas>
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="table-wrapper">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Metric</th>
                                        <th>12 - 4 AM</th>
                                        <th>8 - 12 PM</th>
                                        <th>4 - 8 PM</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Blood Pressure</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>Urine</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                    <tr>
                                        <td>Stool</td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                        <td><input type="text"></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="button" class="edit">Edit</button>
                    <button type="submit" class="save">Save</button>
                </div>

            </form>
       </div>
    </main>

    <script src="main.js"></script>

    <script>
        var tprChart;
        var labels = ['12 AM', '4 AM', '8 AM', '12 PM', '4 PM', '8 PM'];
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
                            borderColor: 'rgba(255, 99, 132, 1)',
                            backgroundColor: 'rgba(255, 99, 132, 0.2)',
                            borderWidth: 1
                        },
                        {
                            label: 'Pulse',
                            data: pulseData,
                            borderColor: 'rgba(54, 162, 235, 1)',
                            backgroundColor: 'rgba(54, 162, 235, 0.2)',
                            borderWidth: 1
                        },
                        {
                            label: 'Respiration',
                            data: respData,
                            borderColor: 'rgba(75, 192, 192, 1)',
                            backgroundColor: 'rgba(75, 192, 192, 0.2)',
                            borderWidth: 1
                        }
                    ]
                },
                options: {
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        }

        function updateChart() {
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

            // Update chart data
            tprChart.data.datasets[0].data = tempValues;
            tprChart.data.datasets[1].data = pulseValues;
            tprChart.data.datasets[2].data = respValues;
            tprChart.update();
        }

        document.addEventListener('DOMContentLoaded', function() {
            createTPRChart();

            // Add event listeners to update chart on input change
            document.querySelectorAll('input').forEach(input => {
                input.addEventListener('input', updateChart);
            });
        });
    </script>
</body>
</html>