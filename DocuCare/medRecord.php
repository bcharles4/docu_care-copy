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
    <title>Medication Record | DocuCare</title>
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
            <form class="medRecord">
                <h1>Medication Record</h1>
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
                    <div class="form-row">
                        <div class="guide">
                            <h3>Medication Record Table</h3>
                            <h4><span>USE THE FOLLOWING LEGENDS IF THE MEDICATION WAS NOT GIVEN DUE TO THE FF REASONS:</span></h4>
                            <p><span>Rx</span> - unavailable/prescribeed, <span>NPO</span> - if pt. is on NPO, <span>-IVF</span> - no IV Access, <span>REFUSED</span> - if refused, ensure patient signed waiver
                            <span>↑BP/↓BP/↑RR, etc.</span> - if medication is contraindicated for pt's vitals</p>
                        </div>      
                    </div>

                    <div class="form-row">
                        <div class="table-wrapper">
                            <table id="medRecord-SO-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>Hospital Day</th>
                                        <th>I. Standing Orders</th>
                                        <th>10-6</th>
                                        <th>6-2</th>
                                        <th>2-10</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="date" name="med-date-SO" /></td>  
                                        <td>
                                            <select name="hospital_day1">
                                                <option value="">Select Day</option>
                                                <option value="Monday">Monday</option>
                                                <option value="Tuesday">Tuesday</option>
                                                <option value="Wednesday">Wednesday</option>
                                                <option value="Thursday">Thursday</option>
                                                <option value="Friday">Friday</option>
                                                <option value="Saturday">Saturday</option>
                                                <option value="Sunday">Sunday</option>
                                            </select>
                                        </td>       
                                        <td><input type="text" name="standing_order" /></td>
                                        <td><input type="text" name="SO_10_6" /></td>
                                        <td><input type="text" name="SO_6_2" /></td>
                                        <td><input type="text" name="SO_2_10" /></td>
                                        <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>                           
                    </div>
                    <div class="add-row-button" id="add-row-button-medRecordSO">
                        <i class="fas fa-plus"></i>
                        <span>Add New</span>
                    </div> 
                </div>

                <div class="form-row-container">
                    <h3>PRN Medications</h3>
                    <div class="form-row">
                        <div class="table-wrapper">
                            <table id="medRecord-PRN-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>II. PRN Medications</th>
                                        <th>10-6</th>
                                        <th>6-2</th>
                                        <th>2-10</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="date" name="med-date-PRN" /></td>        
                                        <td><input type="text" name="PRN-Med" /></td>
                                        <td><input type="text" name="PRN_10_6" /></td>
                                        <td><input type="text" name="PRN_6_2" /></td>
                                        <td><input type="text" name="PRN_2_10" /></td>
                                        <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    <div class="add-row-button" id="add-row-button-medRecordPRN">
                        <i class="fas fa-plus"></i>
                        <span>Add New</span>
                    </div>                        
                </div>

                <div class="form-row-container">
                    <h3>STAT Order Medications</h3>
                    <div class="form-row">
                        <div class="table-wrapper">
                            <table id="medRecord-STAT-table">
                                <thead>
                                    <tr>
                                        <th>Date</th>
                                        <th>III. STAT Order Medications</th>
                                        <th>10-6</th>
                                        <th>6-2</th>
                                        <th>2-10</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr> 
                                        <td><input type="date" name="med-date-STAT" /></td>        
                                        <td><input type="text" name="stat_order" /></td>
                                        <td><input type="text" name="STAT_10_6" /></td>
                                        <td><input type="text" name="STAT_6_2" /></td>
                                        <td><input type="text" name="STAT_2_10" /></td>   
                                        <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td> 
                                    </tr>
                                </tbody>
                            </table>
                        </div>  
                    </div>
                    <div class="add-row-button" id="add-row-button-medRecordSTAT">
                        <i class="fas fa-plus"></i>
                        <span>Add New</span>
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
</body>
</html>