<?php
    session_start();
    include('mycon.php');
    $Position = $_SESSION['Position'];

    $result = $connection->query("SELECT MAX(Patient_ID) AS max_id FROM patient_info");
    $row = $result->fetch_assoc();
    
    // Check if there are no patients yet
    if ($row['max_id'] === NULL) {
    $nextPatientID = 1; // Start from 1 if no patients exist
    } 
    
    else {
    $nextPatientID = $row['max_id'] + 1;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Patient Information | DocuCare</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <script src="https://kit.fontawesome.com/1e3d5daa34.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <link rel="stylesheet" href="style2.css">  
    <style>
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
            <form class="addPatient" method="POST" action="addPatientScript.php">
                <h1>Patient Information</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group short">
                            <label for="patientName">First Name:</label>
                            <input type="text" id="patientFName" name="patientFName" placeholder="Enter patient’s first name">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Middle Name:</label>
                            <input type="text" id="patientMName" name="patientMName" placeholder="Enter patient’s middle name">
                        </div>
                        <div class="form-group short">
                            <label for="patientName">Last Name:</label>
                            <input type="text" id="patientLName" name="patientLName" placeholder="Enter patient’s last name">
                        </div>
                        <div class="form-group">
                            <label for="DoB">Date of Birth:</label>
                            <input type="date" id="DoB" name="DoB" required>
                        </div>
                        <div class="form-group short">
                            <label for="age">AGE:</label>
                            <input type="number" id="age" name="age"  readonly>
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
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="street-address">Street Address:</label>
                            <input type="text" id="street-address" name="street-address" placeholder="Enter street address" required>
                        </div>                 
                        <div class="form-group">
                            <label for="house-number">House/Apartment Number:</label>
                            <input type="text" id="house-number" name="house-number" placeholder="Enter house/apartment number" required>
                        </div>
                        <div class="form-group">
                            <label for="subdivision">Subdivision:</label>
                            <input type="text" id="subdivision" name="subdivision" placeholder="Enter subdivision">
                        </div>                                
                    </div> 

                    <div class="form-row">             
                        <div class="form-group">
                            <label for="barangay">Barangay:</label>
                            <input type="text" id="barangay" name="barangay" placeholder="Enter barangay" required>
                        </div>                
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" placeholder="Enter city" required>
                        </div>               
                        <div class="form-group">
                            <label for="province">Province:</label>
                            <input type="text" id="province" name="province" placeholder="Enter province" required>
                        </div>                    
                    </div> 

                    <div class="form-row">
                        <div class="form-group">
                            <label for="birthplace">Birthplace:</label>
                            <input type="text" id="birthplace" name="birthplace" placeholder="Enter birthplace" required>
                        </div>
                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" placeholder="Enter attending physician/s">
                        </div>
                        <div class="form-group short">
                            <label for="patient_ID">PATIENT NO.:</label>
                            <input type="text" id="patientID" name="patientID" value="<?php echo $nextPatientID; ?>" readonly>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number">
                        </div>
                    </div> 
                </div>
    
                <!-- Guardian Information -->
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="motherName">Mother's Name:</label>
                            <input type="text" id="motherName" name="motherName" placeholder="Enter mother's name" required>
                        </div>
                        <div class="form-group short">
                            <label for="motherContact">Contact No.:</label>
                            <input type="tel" id="motherPhone" name="motherPhone" placeholder="Enter mother's contact no." required>
                        </div>
                        <div class="form-group">
                            <label for="fatherName">Father's Name:</label>
                            <input type="text" id="fatherName" name="fatherName" placeholder="Enter father's name" required>
                        </div>
                        <div class="form-group short">
                            <label for="fatherContact">Contact No.:</label>
                            <input type="tel" id="fatherPhone" name="fatherPhone" placeholder="Enter father's contact no." required>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="emergencyContactName">Emergency Contact Name:</label>
                            <input type="text" id="emergencyContactName" name="emergencyContactName" placeholder="Enter emergency contact name" required>
                        </div>
                        <div class="form-group short">
                            <label for="emergencyContactPhone">Emergency Contact No.:</label>
                            <input type="tel" id="emergencyContactPhone" name="emergencyContactPhone" placeholder="Enter emergency contact no." required>
                        </div>
                        <div class="form-group short">
                            <label for="emergencyContactRelationship">Relationship to Patient:</label>
                            <input type="text" id="emergencyContactRelationship" name="emergencyContactRelationship" placeholder="Enter relationship to patient" required>
                        </div>
                    </div>
                </div>
  
                <!-- Medical History -->
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="medicalHistory">Medical History:</label>
                            <textarea id="medicalHistory" name="medicalHistory" placeholder="Enter medical history"></textarea>
                        </div>
                    </div>
                    <div class="form-row">
                        <div class="form-group">
                            <label for="allergies">Allergies:</label>
                            <textarea id="allergies" name="allergies" placeholder="Enter allergies"></textarea>
                        </div>
                    </div>
                     
                    <div class="form-row">
                        <div class="form-group">
                            <label for="currentMedications">Current Medications:</label>
                            <textarea id="currentMedications" name="currentMedications" placeholder="Enter current medications"></textarea>
                        </div>
                    </div>
                </div>
    
                <input type='submit' class="submit-btn" name='New_Patient' value='SUBMIT'>
            </form>
        </div>
    </main>


    <script src="main.js"></script>
    
</body>
</html>