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
    <title>Room Information | DocuCare</title>
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
            <form class="roomManage">
                <h1>Room Information</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" placeholder="Enter room number">
                        </div>
                        <div class="form-group">
                            <label for="age">ROOM TYPE:</label>
                            <input type="text" id="roomType" name="roomType" placeholder="Enter room type">
                        </div>
                        <div class="form-group short">
                            <label for="age">BED CAPACITY:</label>
                            <input type="number" id="bedCap" name="bedCap" placeholder="Enter capacity">
                        </div>
                        <div class="form-group">
                            <label for="age">ROOM STATUS:</label>
                            <input type="text" id="roomStat" name="roomStat" placeholder="Enter status">
                        </div>     
                    </div>
                </div>

                <div class="form-row-container">
                    <div class="form-row">
                        <div class="table-wrapper">
                            <table id="room-info-table">
                                <thead>
                                    <tr>
                                        <th>Assigned Patient ID</th>
                                        <th>Day Shift Nurse ID</th>
                                        <th>Night Shift Nurse ID</th>
                                        <th>Admission Date and Time</th>
                                        <th>Discharge Date and Time</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><input type="text" name="assignedPatientID" placeholder="Patient ID"></td>
                                        <td><input type="text" name="dayShiftNurseID" placeholder="Day Shift Nurse ID"></td>
                                        <td><input type="text" name="nightShiftNurseID" placeholder="Night Shift Nurse ID"></td>  
                                        <td><input type="datetime-local" name="admissionDateTime"></td>
                                        <td><input type="datetime-local" name="dischargeDateTime"></td>
                                        <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div> 
                        <div class="add-row-button" id="add-row-button-roomInfo">
                            <i class="fas fa-plus"></i>
                            <span>Add New</span>
                        </div>    
                    </div>
                </div>

                <div class="form-row-container">
                    <div class="form-row">
                        <div class="table-wrapper">
                            <h3>Maintenance Details</h3>
                            <table id="room-maintenance-table">
                              <thead>
                                <tr>
                                  <th>Scheduled Maintenance Date and Time</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr>
                                  <td><input type="datetime-local" name="maintenanceDateTime"></td>
                                  <td><button class="remove-row-button"><i class="fas fa-trash-alt"></i></button></td>
                                </tr>
                              </tbody>
                            </table>
                        </div>
                        <div class="add-row-button" id="add-row-button-roomMaintain">
                            <i class="fas fa-plus"></i>
                            <span>Add New</span>
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
</body>
</html>