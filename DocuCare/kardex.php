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
    include('Queries.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Kardex | DocuCare</title>
    <title>TPR Graphic Chart | DocuCare</title>
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
            <form class="kardex" method="POST" action="kardexScript.php">
                <input type="hidden" name="Patient_ID" value="<?php echo htmlspecialchars($Patient_ID); ?>">
                <h1>Kardex</h1>
                <div class="form-row-container">
                    <div class="form-row">
                        <div class="form-group">
                            <?php
                            $hasPrecaution = $resultPrecaution -> num_rows > 0;

                            if ($hasPrecaution){
                                while ($row = $resultPrecaution->fetch_assoc()) {
                                    echo '<label for="precautions">PRECAUTIONS:</label>';
                                    echo '<input type="text" id="precautions" name="precautions" placeholder="Enter precautions" value = "'. htmlspecialchars ($row['Precautions']) . '">';
                                }
                            }

                            else{
                                echo '<label for="precautions">PRECAUTIONS:</label>';
                                echo '<input type="text" id="precautions" name="precautions" placeholder="Enter precautions">';
                            }
                            
                            ?>
                        </div>
                        <div class="form-group">
                            <label for="dateTimeAdmitted">DATE/TIME ADMITTED:</label>
                            <input type="datetime-local" id="dateTimeAdmitted" name="dateTimeAdmitted" value="<?php echo htmlspecialchars ($patient['Admission_Date']); ?>">
                        </div>
                        <div class="form-group">
                            <?php
                                $hasHospitalNum = $resultHospitalNum -> num_rows > 0;

                                if ($hasHospitalNum){
                                    while ($row = $resultHospitalNum->fetch_assoc()) {
                                        echo '<label for="hospitalNo">HOSPITAL NO.:</label>';
                                        echo '<input type="text" id="hospitalNo" name="hospitalNo" placeholder="Enter hospital number" value = "'.htmlspecialchars($row['Hospital_Num']).'">';
                                    }
                                }

                                else{
                                    echo '<label for="hospitalNo">HOSPITAL NO.:</label>';
                                    echo '<input type="text" id="hospitalNo" name="hospitalNo" placeholder="Enter hospital number">';
                                }
                            ?>
                        </div>
                    </div>
    
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
                            <input type="text" id="age" name="age" value="<?php echo htmlspecialchars ($patient['Age']); ?>">
                        </div>
                        <div class="form-group short">
                            <label for="sex">SEX:</label>
                            <select id="sex" name="sex">
                                <option value="">Select sex</option>
                                <option value="Male" <?php if ($patient['Sex'] == 'Male') echo 'selected'; ?>>Male</option>
                                <option value="Female" <?php if ($patient['Sex'] == 'Female') echo 'selected'; ?>>Female</option>
                                <option value="Other" <?php if ($patient['Sex'] == 'Other') echo 'selected'; ?>>Other</option>
                            </select>
                        </div>
                        <div class="form-group short">
                            <?php
                                $hasWeight = $resultWeight -> num_rows > 0;

                                if ($hasWeight){
                                    while ($row = $resultWeight->fetch_assoc()) {
                                        echo '<label for="weight">Wt.:</label>';
                                        echo '<div class="input-container">';
                                            echo '<input type="text" id="weight" name="weight" placeholder="Enter weight" value = "'. htmlspecialchars($row['Weight']) .'">';
                                            echo '<span class="input-label">kg</span>';
                                        echo '</div>';
                                    }
                                }

                                else{
                                    echo '<label for="weight">Wt.:</label>';
                                    echo '<div class="input-container">';
                                        echo '<input type="text" id="weight" name="weight" placeholder="Enter weight">';
                                        echo '<span class="input-label">kg</span>';
                                    echo '</div>';
                                }
                            ?>
                        </div>
                        <div class="form-group short">
                            <label for="roomNo">ROOM NO.:</label>
                            <input type="text" id="roomNo" name="roomNo" value="<?php echo htmlspecialchars ($patient['Room_Num']); ?>">
                        </div>
                    </div>

                    <div class="form-row">
                        <div class="form-group">
                            <label for="street-address">Street Address:</label>
                            <input type="text" id="street-address" name="street-address" placeholder="Enter street address" value="<?php echo htmlspecialchars ($patient['Street']); ?>">
                        </div>                 
                        <div class="form-group">
                            <label for="house-number">House/Apartment Number:</label>
                            <input type="text" id="house-number" name="house-number" placeholder="Enter house/apartment number" value="<?php echo htmlspecialchars ($patient['House_Num']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="subdivision">Subdivision:</label>
                            <input type="text" id="subdivision" name="subdivision" placeholder="N/A" value="<?php echo htmlspecialchars ($patient['Subdivision']); ?>">
                        </div>                                
                    </div> 

                    <div class="form-row">             
                        <div class="form-group">
                            <label for="barangay">Barangay:</label>
                            <input type="text" id="barangay" name="barangay" placeholder="Enter barangay" value="<?php echo htmlspecialchars ($patient['Barangay']); ?>">
                        </div>                
                        <div class="form-group">
                            <label for="city">City:</label>
                            <input type="text" id="city" name="city" placeholder="Enter city" value="<?php echo htmlspecialchars ($patient['City']); ?>">
                        </div>               
                        <div class="form-group">
                            <label for="province">Province:</label>
                            <input type="text" id="province" name="province" placeholder="Enter province" value="<?php echo htmlspecialchars ($patient['Province']); ?>">
                        </div>                    
                    </div> 
        
                    <div class="form-row">

                        <div class="form-group">
                            <label for="attendingPhysician">ATTENDING PHYSICIAN/S:</label>
                            <input type="text" id="attendingPhysician" name="attendingPhysician" value="<?php echo htmlspecialchars ($patient['Attending_Physician']); ?>">
                        </div>
                        <div class="form-group">
                            <label for="admittingDiagnosis">ADMITTING DIAGNOSIS:</label>
                            <input type="text" id="admittingDiagnosis" name="admittingDiagnosis" placeholder="Enter admitting diagnosis" value = "<?php echo htmlspecialchars($patient['Admitting_Diagnosis']); ?>">
                        </div>
                    </div>
        
                </div>

                <?php
                        // Flag used to check if labels have been displayed
                        $labelsDisplayed = false;
                
                        $hasEndorsements = $resultEndorsement && $resultEndorsement->num_rows > 0;
                
                        if ($hasEndorsements) {
                            // Endorsement form row when there is data
                            echo '<div class="form-row-container">';
                                while ($row = $resultEndorsement->fetch_assoc()) {
                                    echo '<div class="form-row auto-input">';
                                        // Only display labels if they haven't been displayed yet
                                        if (!$labelsDisplayed) {
                                            echo '<div class="form-group short">';
                                                echo '<label for="endorsedate">DATE:</label>';
                                                echo '<input type="date" id="endorsedate" value="' . htmlspecialchars($row['Endorsement_Date']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<label for="specialEndorsement">SPECIAL ENDORSEMENT:</label>';
                                                echo '<input type="text" id="specialEndorsement" value="' . htmlspecialchars($row['Special_Endorsement']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<label for="remarks">REMARKS:</label>';
                                                echo '<input type="text" id="remarks" value="' . htmlspecialchars($row['Endorsement_Remarks']) . '" readonly>';
                                            echo '</div>';
                                
                                            $labelsDisplayed = true; // Sets flag value to true
                                        } 
                                        
                                        else {
                                            // Display rows without labels
                                            echo '<div class="form-group short">';
                                                echo '<input type="date" value="' . htmlspecialchars($row['Endorsement_Date']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<input type="text" value="' . htmlspecialchars($row['Special_Endorsement']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<input type="text" value="' . htmlspecialchars($row['Endorsement_Remarks']) . '" readonly>';
                                            echo '</div>';
                                        }
                                    echo '</div>'; // Close form-row div 
                                }
                            
                                // Display a row at the bottom
                                echo '<div class="form-row auto-input">';
                    
                                    echo '<div class="form-group short">';
                                        echo '<input type="date" id="endorsedate" name="endorsedate">';
                                    echo '</div>';
                                
                                    echo '<div class="form-group">';
                                        echo '<input type="text" id="specialEndorsement" name="specialEndorsement" placeholder="Enter special endorsement">';
                                    echo '</div>';
                                
                                    echo '<div class="form-group">';
                                        echo '<input type="text" id="remarks" name="remarks" placeholder="Enter remarks">';
                                    echo '</div>';
                    
                                echo '</div>'; // Close form-row
                            echo '</div>'; // Close form-row-container
                        } 
                        
                        // Endorsement form row if there is no data
                        else {
                            //if there is nothing inside the table
                            echo '<div class="form-row-container">';
                                echo '<div class="form-row auto-input">';
                                    if (!$labelsDisplayed) {
                                        echo '<div class="form-group short">';
                                            echo '<label for="endorsedate">DATE:</label>';
                                            echo '<input type="date" id="endorsedate" name="endorsedate">';
                                        echo '</div>';
                                
                                        echo '<div class="form-group">';
                                            echo '<label for="specialEndorsement">SPECIAL ENDORSEMENT:</label>';
                                            echo '<input type="text" id="specialEndorsement" name="specialEndorsement" placeholder="Enter special endorsement">';
                                        echo '</div>';
                                
                                        echo '<div class="form-group">';
                                            echo '<label for="remarks">REMARKS:</label>';
                                            echo '<input type="text" id="remarks" name="remarks" placeholder="Enter remarks">';
                                        echo '</div>';
                                        
                                        $labelsDisplayed = true;
                                    }
                                echo '</div>'; // Close form-row
                            echo '</div>'; // Close form-row-container
                        }
                ?>

                <?php
                    // IV Fluids Section
                    echo '<h2>INTRAVENOUS FLUIDS</h2>';

                    // Reuse flag
                    $labelsDisplayedIV = false;

                    $hasIV = $resultIV && $resultIV->num_rows > 0;

                    // Container for IV Fluids
                    echo '<div class="form-row-container">';

                    if ($hasIV) {
                        // IVF form rows when there is data
                        while ($row = $resultIV->fetch_assoc()) {
                            echo '<div class="form-row auto-input">';
                            // Display labels and fields for IVF
                            if (!$labelsDisplayedIV) {
                                echo '<div class="form-group short">';
                                    echo '<label for="ivfdate">DATE:</label>';
                                    echo '<input type="date" id="ivfdate" value="' . htmlspecialchars($row['IVFluid_Date']) . '" readonly>';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<label for="ivf">IVF:</label>';
                                    echo '<input type="text" id="ivf" value="' . htmlspecialchars($row['IVFluid']) . '" readonly>';
                                echo '</div>';

                                $labelsDisplayedIV = true; // Set flag value to true
                            } else {
                                // Display rows without labels
                                echo '<div class="form-group short">';
                                    echo '<input type="date" value="' . htmlspecialchars($row['IVFluid_Date']) . '" readonly>';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<input type="text" value="' . htmlspecialchars($row['IVFluid']) . '" readonly>';
                                echo '</div>';
                            }
                            echo '</div>'; // Close form-row
                        }
                    } else {
                        // Display the form row for IVF when there is no data
                        echo '<div class="form-row auto-input">';
                        if (!$labelsDisplayedIV) {
                            echo '<div class="form-group short">';
                                echo '<label for="ivfdate">DATE:</label>';
                                echo '<input type="date" id="ivfdate" name="ivfdate">';
                            echo '</div>';

                            echo '<div class="form-group">';
                                echo '<label for="ivf">IVF:</label>';
                                echo '<input type="text" id="ivf" name="ivf" placeholder="Enter IVF">';
                            echo '</div>';

                            $labelsDisplayedIV = true;
                        }
                        echo '</div>'; // Close form-row
                    }
                    echo '</div>'; // Close form-row-container
                ?>
                
                <?php
                    // Side Drips Section
                    // Reuse flag
                    $labelsDisplayedDrips = false;

                    $hasSideDrips = $resultTransfusion && $resultTransfusion->num_rows > 0;

                    // Container for Side Drips
                    echo '<div class="form-row-container">';

                    if ($hasSideDrips) {
                        // Side Drips form rows when there is data
                        while ($row = $resultTransfusion->fetch_assoc()) {
                            echo '<div class="form-row auto-input">';
                            // Display labels and fields for Side Drips
                            if (!$labelsDisplayedDrips) {
                                echo '<div class="form-group short">';
                                    echo '<label for="sideDripsDate">DATE:</label>';
                                    echo '<input type="date" id="sideDripsDate" value="' . htmlspecialchars($row['Drips_Transfusion_Date']) . '" readonly>';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<label for="sideDrips">SIDE DRIPS/BLOOD TRANSFUSION:</label>';
                                    echo '<input type="text" id="sideDrips" value="' . htmlspecialchars($row['Drips_Transfusion']) . '" readonly>';
                                echo '</div>';

                                $labelsDisplayedDrips = true; // Set flag value to true
                            } else {
                                // Display rows without labels
                                echo '<div class="form-group short">';
                                    echo '<input type="date" value="' . htmlspecialchars($row['Drips_Transfusion_Date']) . '" readonly>';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<input type="text" value="' . htmlspecialchars($row['Drips_Transfusion']) . '" readonly>';
                                echo '</div>';
                            }
                            echo '</div>'; // Close form-row
                        }
                    } else {
                        // Display the form row for Side Drips when there is no data
                        echo '<div class="form-row auto-input">';
                        if (!$labelsDisplayedDrips) {
                            echo '<div class="form-group short">';
                                echo '<label for="sideDripsDate">DATE:</label>';
                                echo '<input type="date" id="sideDripsDate" name="sideDripsDate">';
                            echo '</div>';

                            echo '<div class="form-group">';
                                echo '<label for="sideDrips">SIDE DRIPS/BLOOD TRANSFUSION:</label>';
                                echo '<input type="text" id="sideDrips" name="sideDrips" placeholder="Enter side drips/blood transfusion">';
                            echo '</div>';

                            $labelsDisplayedDrips = true;
                        }
                        echo '</div>'; // Close form-row
                    }
                    echo '</div>'; // Close form-row-container
                ?>

                <?php
                    // Contraptions Section
                    $hasContraptions = $resultContraptions -> num_rows > 0;

                    if ($hasContraptions){
                        while ($row = $resultContraptions->fetch_assoc()) {
                            echo '<div class="form-row-container">';
                                echo '<div class="form-row">';
                                    echo '<div class="form-group">';
                                        echo '<label for="contraptions">CONTRAPTIONS:</label>';
                                        echo '<textarea id="contraptions" name="contraptions" placeholder="Enter contraptions">'. htmlspecialchars($row['Contraptions']) . '</textarea>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }
                    
                    else{
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row">';
                                echo '<div class="form-group">';
                                    echo '<label for="contraptions">CONTRAPTIONS:</label>';
                                    echo '<textarea id="contraptions" name="contraptions" placeholder="Enter contraptions"></textarea>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
                
                <?php
                    // Monitoring Section
                    $hasMonitoring = $resultMonitoring -> num_rows > 0;

                    if ($hasMonitoring){
                        while ($row = $resultMonitoring->fetch_assoc()) {
                            echo '<div class="form-row-container">';
                                echo '<div class="form-row">';
                                    echo '<div class="form-group">';
                                        echo '<label for="monitoring">MONITORING:</label>';
                                        echo '<textarea id="monitoring" name="monitoring" placeholder="Enter monitoring">' . htmlspecialchars($row['Monitoring']) . '</textarea>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                    }

                    else{
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row">';
                                echo '<div class="form-group">';
                                    echo '<label for="monitoring">MONITORING:</label>';
                                    echo '<textarea id="monitoring" name="monitoring" placeholder="Enter monitoring"></textarea>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    }
                ?>
                
                <?php
                    // DIAGNOSTICS Section
                    echo '<h2>DIAGNOSTICS</h2>'; 

                    // Reuse flag
                    $labelsDisplayed = false;

                    $hasDiagnostics = $resultDiagnostics && $resultDiagnostics->num_rows > 0;
                    // Flag used to check if labels have been displayed
                    $labelsDisplayed = false;

                    if ($hasDiagnostics) {
                        // Diagnostics form row when there is data
                        echo '<div class="form-row-container">';
                        
                        while ($row = $resultDiagnostics->fetch_assoc()) {
                            $selectedCheck = $row['Diagnostics_Category']; // Single value for the diagnostic check
                            
                            echo '<div class="form-row auto-input">';
                            
                            // Only display labels if they haven't been displayed yet
                                if (!$labelsDisplayed) {
                                    echo '<div class="form-group short">';
                                        echo '<label for="date">DATE:</label>';
                                        echo '<input type="date" id="date" value="' . htmlspecialchars($row['Diagnostic_Date']) . '" readonly>';
                                    echo '</div>';

                                    echo '<div class="form-group">';
                                        echo '<label for="diagnostic">1-Request, 2-Extracted/Done, 3-Results in, 4-Relayed, 5-Acknowledge:</label>';
                                        echo '<input type="text" id="diagnostic" value="' . htmlspecialchars($row['Diagnostics']) . '" readonly>';
                                    echo '</div>';
                                    
                                    echo '<div class="checkbox-group row">';
                                        echo '<label>Options:</label>';
                                        echo '<div class="checkboxes">';
                                            // Individual checkboxes (1 to 5)
                                            echo '<label><input type="checkbox" id="checkbox1" name="options[]" value="1" ' . ($selectedCheck == 1 ? 'checked' : '') . ' disabled> 1</label>';
                                            echo '<label><input type="checkbox" id="checkbox2" name="options[]" value="2" ' . ($selectedCheck == 2 ? 'checked' : '') . ' disabled> 2</label>';
                                            echo '<label><input type="checkbox" id="checkbox3" name="options[]" value="3" ' . ($selectedCheck == 3 ? 'checked' : '') . ' disabled> 3</label>';
                                            echo '<label><input type="checkbox" id="checkbox4" name="options[]" value="4" ' . ($selectedCheck == 4 ? 'checked' : '') . ' disabled> 4</label>';
                                            echo '<label><input type="checkbox" id="checkbox5" name="options[]" value="5" ' . ($selectedCheck == 5 ? 'checked' : '') . ' disabled> 5</label>';
                                        echo '</div>';
                                    echo '</div>'; 

                                    $labelsDisplayed = true; // Set the flag to true to prevent showing labels again
                                } else {
                                    // Display rows without labels (for additional rows)
                                    echo '<div class="form-group short">';
                                        echo '<input type="date" value="' . htmlspecialchars($row['Diagnostic_Date']) . '" readonly>';
                                    echo '</div>';

                                    echo '<div class="form-group">';
                                        echo '<input type="text" value="' . htmlspecialchars($row['Diagnostics']) . '" readonly>';
                                    echo '</div>';
                                    
                                    echo '<div class="checkbox-group row auto-cb">';
                                        echo '<div class="checkboxes">';
                                            // Individual checkboxes (1 to 5)
                                            echo '<label><input type="checkbox" id="checkbox1" name="options[]" value="1" ' . ($selectedCheck == 1 ? 'checked' : '') . ' disabled> 1</label>';
                                            echo '<label><input type="checkbox" id="checkbox2" name="options[]" value="2" ' . ($selectedCheck == 2 ? 'checked' : '') . ' disabled> 2</label>';
                                            echo '<label><input type="checkbox" id="checkbox3" name="options[]" value="3" ' . ($selectedCheck == 3 ? 'checked' : '') . ' disabled> 3</label>';
                                            echo '<label><input type="checkbox" id="checkbox4" name="options[]" value="4" ' . ($selectedCheck == 4 ? 'checked' : '') . ' disabled> 4</label>';
                                            echo '<label><input type="checkbox" id="checkbox5" name="options[]" value="5" ' . ($selectedCheck == 5 ? 'checked' : '') . ' disabled> 5</label>';
                                        echo '</div>';
                                    echo '</div>'; 
                                }
                            
                            echo '</div>'; // Close form-row 
                        }

                        // Display a row at the bottom for new entry
                        echo '<div class="form-row auto-input">';
                            echo '<div class="form-group short">';
                                echo '<input type="date" id="date" name="date">';
                            echo '</div>';
                            
                            echo '<div class="form-group">';
                                echo '<input type="text" id="diagnostic" name="diagnostic" placeholder="Enter diagnostics">';
                            echo '</div>';
                            
                            echo '<div class="checkbox-group row auto-cb">';
                                echo '<div class="checkboxes">';
                                    echo '<label><input type="checkbox" id="checkbox1" name="options[]" value="1"> 1</label>';
                                    echo '<label><input type="checkbox" id="checkbox2" name="options[]" value="2"> 2</label>';
                                    echo '<label><input type="checkbox" id="checkbox3" name="options[]" value="3"> 3</label>';
                                    echo '<label><input type="checkbox" id="checkbox4" name="options[]" value="4"> 4</label>';
                                    echo '<label><input type="checkbox" id="checkbox5" name="options[]" value="5"> 5</label>';
                                echo '</div>';
                            echo '</div>'; 
                        echo '</div>'; // Close form-row

                        echo '</div>';  // Close form-row-container
                    } else {
                        // Diagnostics form row if there is no data
                        echo '<div class="form-row-container">';
                            echo '<div class="form-row auto-input">';
                            
                            if (!$labelsDisplayed) {
                                echo '<div class="form-group short">';
                                    echo '<label for="date">DATE:</label>';
                                    echo '<input type="date" id="date" name="date">';
                                echo '</div>';

                                echo '<div class="form-group">';
                                    echo '<label for="diagnostic">1-Request, 2-Extracted/Done, 3-Results in, 4-Relayed, 5-Acknowledge:</label>';
                                    echo '<input type="text" id="diagnostic" name="diagnostic" placeholder="Enter diagnostics">';
                                echo '</div>';

                                echo '<div class="checkbox-group row">';
                                    echo '<label>Options:</label>';
                                    echo '<div class="checkboxes">';
                                        echo '<label><input type="checkbox" id="checkbox1" name="options[]" value="1"> 1</label>';
                                        echo '<label><input type="checkbox" id="checkbox2" name="options[]" value="2"> 2</label>';
                                        echo '<label><input type="checkbox" id="checkbox3" name="options[]" value="3"> 3</label>';
                                        echo '<label><input type="checkbox" id="checkbox4" name="options[]" value="4"> 4</label>';
                                        echo '<label><input type="checkbox" id="checkbox5" name="options[]" value="5"> 5</label>';
                                    echo '</div>';
                                echo '</div>'; 
                                
                                $labelsDisplayed = true; // Set the flag to true
                            }
                            
                            echo '</div>'; // Close form-row
                        echo '</div>'; // Close form-row-container
                    }
                ?>

                <?php
                    //Vital signs Section
                    echo '<div class="form-group-container">';
                        $hasVitals = $resultVitals -> num_rows > 0;

                        if ($hasVitals){

                            while ($row = $resultVitals->fetch_assoc()) {
                                $selectedCheck = $row['Vitals_Category'];
                                echo '<div class="form-row-container kardex-checkbox">';
                                    echo '<div class="form-row">';
                                        echo '<div class="checkbox-group">';
                                            echo '<label>VITAL SIGNS</label>';
                                            echo '<div class="checkboxes">';
                                                echo '<label><input type="checkbox" name="vitals[]" value="q1" ' . ($selectedCheck == 1 ? 'checked' : '') . ' disabled> q1</label>';
                                                echo '<label><input type="checkbox" name="vitals[]" value="q2" ' . ($selectedCheck == 2 ? 'checked' : '') . ' disabled> q2</label>';
                                                echo '<label><input type="checkbox" name="vitals[]" value="q4" ' . ($selectedCheck == 3 ? 'checked' : '') . ' disabled> q4</label>';
                                                echo '<label><input type="checkbox" name="vitals[]" value="FHT" ' . ($selectedCheck == 4 ? 'checked' : '') . ' disabled> FHT</label>';
                                                echo '<label>Others: <input type="text" id="vitalothersinput" name="vitalothersinput" value="' . $row['Other_Info'] . '" readonly></label>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }

                        else{
                            echo '<div class="form-row-container kardex-checkbox">';
                            echo '<div class="form-row">';
                                echo '<div class="checkbox-group">';
                                    echo '<label>VITAL SIGNS</label>';
                                    echo '<div class="checkboxes">';
                                        echo '<label><input type="checkbox" name="vitals[]" value="q1"> q1</label>';
                                        echo '<label><input type="checkbox" name="vitals[]" value="q2"> q2</label>';
                                        echo '<label><input type="checkbox" name="vitals[]" value="q4"> q4</label>';
                                        echo '<label><input type="checkbox" name="vitals[]" value="FHT"> FHT</label>';
                                        echo '<label>Others: <input type="text" id="vitalothersinput" name="vitalothersinput"></label>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        }

                        //Monitor I & O Section
                        $hasIO = $resultIO -> num_rows > 0;

                        if ($hasIO){

                            while ($row = $resultIO->fetch_assoc()) {
                                $selectedCheck = $row['IO_Category'];
                                echo '<div class="form-row-container kardex-checkbox">';
                                    echo '<div class="form-row">';
                                        echo '<div class="checkbox-group">';
                                            echo '<label>MONITOR I & O</label>';
                                            echo '<div class="checkboxes">';
                                                echo '<label><input type="checkbox" name="monitor[]" value="q1" ' . ($selectedCheck == 1 ? 'checked' : '') . ' disabled> q1</label>';
                                                echo '<label><input type="checkbox" name="monitor[]" value="q2" ' . ($selectedCheck == 2 ? 'checked' : '') . ' disabled> q2</label>';
                                                echo '<label><input type="checkbox" name="monitor[]" value="q4" ' . ($selectedCheck == 3 ? 'checked' : '') . ' disabled> q4</label>';
                                                echo '<label><input type="checkbox" name="monitor[]" value="qShift" ' . ($selectedCheck == 4 ? 'checked' : '') . ' disabled> q Shift</label>';
                                                echo '<label>Others: <input type="text" id="monitorothersinput" name="monitorothersinput" value = "' .$row['Other_Info']. '" readonly></label>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }

                        else{
                            echo '<div class="form-row-container kardex-checkbox">';
                            echo '<div class="form-row">';
                                echo '<div class="checkbox-group">';
                                    echo '<label>MONITOR I & O</label>';
                                    echo '<div class="checkboxes">';
                                        echo '<label><input type="checkbox" name="monitor[]" value="q1"> q1</label>';
                                        echo '<label><input type="checkbox" name="monitor[]" value="q2"> q2</label>';
                                        echo '<label><input type="checkbox" name="monitor[]" value="q4"> q4</label>';
                                        echo '<label><input type="checkbox" name="monitor[]" value="qShift"> q Shift</label>';
                                        echo '<label>Others: <input type="text" id="monitorothersinput" name="monitorothersinput"></label>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                        }

                        //Diet Section
                        $hasDiet = $resultDiet -> num_rows > 0;

                        if ($hasDiet){

                            while ($row = $resultDiet->fetch_assoc()) {
                                $selectedCheck = $row['Diet_Category'];
                                echo '<div class="form-row-container kardex-checkbox">';
                                    echo '<div class="form-row">';
                                        echo '<div class="checkbox-group">';
                                            echo '<label>DIET / NUTRITION</label>';
                                            echo '<div class="checkboxes">';
                                                echo '<label><input type="checkbox" name="diet[]" value="NPO" ' . ($selectedCheck == 1 ? 'checked' : '') . ' disabled> NPO</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="DAT" ' . ($selectedCheck == 2 ? 'checked' : '') . ' disabled> DAT</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="BRAT_DIET" ' . ($selectedCheck == 3 ? 'checked' : '') . ' disabled> BRAT DIET</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="SOFT_DIET" ' . ($selectedCheck == 4 ? 'checked' : '') . ' disabled> SOFT DIET</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="General_Liquid" ' . ($selectedCheck == 5 ? 'checked' : '') . ' disabled> General Liquid</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="Clear_Liquid" ' . ($selectedCheck == 6 ? 'checked' : '') . ' disabled> Clear Liquid</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="Diet_for_Age" ' . ($selectedCheck == 7 ? 'checked' : '') . ' disabled> Diet for Age</label>';
                                                echo '<label><input type="checkbox" name="diet[]" value="Breast_Feeding" ' . ($selectedCheck == 8 ? 'checked' : '') . ' disabled> Breast Feeding</label>';
                                                echo '<label>Others: <input type="text" id="Dietothersinput" name="Dietothersinput" value = "' .$row['Other_Info']. '" readonly></label>';
                                                echo '<label for="lastmeal">LAST MEAL:</label>';
                                                echo '<input type="text" id="lastmeal" name="lastmeal" placeholder="Enter last meal" value = "' .$row['Last_Meal']. '" readonly>';
                                            echo '</div>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                            }
                        }
                        else{
                            echo '<div class="form-row-container kardex-checkbox">';
                            echo '<div class="form-row">';
                                echo '<div class="checkbox-group">';
                                    echo '<label>DIET / NUTRITION</label>';
                                    echo '<div class="checkboxes">';
                                        echo '<label><input type="checkbox" name="diet[]" value="NPO"> NPO</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="DAT"> DAT</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="BRAT_DIET"> BRAT DIET</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="SOFT_DIET"> SOFT DIET</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="General_Liquid"> General Liquid</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="Clear_Liquid"> Clear Liquid</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="Diet_for_Age"> Diet for Age</label>';
                                        echo '<label><input type="checkbox" name="diet[]" value="Breast_Feeding"> Breast Feeding</label>';
                                        echo '<label>Others: <input type="text" id="Dietothersinput" name="Dietothersinput"></label>';
                                        echo '<label for="lastmeal">LAST MEAL:</label>';
                                        echo '<input type="text" id="lastmeal" name="lastmeal" placeholder="Enter last meal">';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        echo '</div>';
                    echo '</div>';
                        }
                ?>


                <?php
                    // MEDICATIONS  Section
                    echo '<h2>MEDICATIONS</h2>';
                        // Reuse flag
                        $labelsDisplayed = false;
                    
                        $hasMedications = $resultMedications && $resultMedications->num_rows > 0;
                        // Flag used to check if labels have been displayed
                        $labelsDisplayed = false;
                
                        if ($hasMedications) {
                            // Diagnostics form row when there is data
                            echo '<div class="form-row-container">';
                                while ($row = $resultMedications->fetch_assoc()) {
                                    
                                    echo '<div class="form-row auto-input">';
                                        // Only display labels if they haven't been displayed yet
                                        if (!$labelsDisplayed) {
                                            echo '<div class="form-group short">';
                                                echo '<label for="generic-name">GENERIC NAME:</label>';
                                                echo '<input type="tex" id="generic-name" value="' . htmlspecialchars($row['Medication_Name']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<label for="medremarks">REMARKS:</label>';
                                                echo '<input type="text" id="medremarks" value="' . htmlspecialchars($row['Medication_Remarks']) . '" readonly>';
                                            echo '</div>';

                                            $labelsDisplayed = true; // Sets flag value to true
                                        } 
                                        
                                        else {
                                            // Display rows without labels
                                            echo '<div class="form-group short">';
                                                echo '<input type="text" value="' . htmlspecialchars($row['Medication_Name']) . '" readonly>';
                                            echo '</div>';
                                
                                            echo '<div class="form-group">';
                                                echo '<input type="text" value="' . htmlspecialchars($row['Medication_Remarks']) . '" readonly>';
                                            echo '</div>';

                                        }
                                    echo '</div>'; // Close form-row 
                                }
                            
                                // Display a row at the bottom
                                echo '<div class="form-row auto-input">';

                                    echo '<div class="form-group short">';
                                        echo '<input type="text" id="generic-name" name="generic-name" placeholder="Enter generic name">';
                                    echo '</div>';
                                
                                    echo '<div class="form-group">';
                                        echo '<input type="text" id="medremarks" name="medremarks" placeholder="Enter remarks">';
                                    echo '</div>';
                
                                echo '</div>'; // Close form-row
                            echo'</div>';// Close form-row-container
                        }
                        
                        // Medication form row if there is no data
                        else {
                            //if there is nothing inside the table
                            echo '<div class="form-row-container">';
                                echo '<div class="form-row auto-input">';
                                    if (!$labelsDisplayed) {
                                        echo '<div class="form-group short">';
                                            echo '<label for="generic-name">GENERIC NAME:</label>';
                                            echo '<input type="text" id="generic-name" name="generic-name" placeholder="Enter generic name">';
                                        echo '</div>';
                                
                                        echo '<div class="form-group">';
                                            echo '<label for="medremarks">REMARKS:</label>';
                                            echo '<input type="text" id="medremarks" name="medremarks" placeholder="Enter remarks">';
                                        echo '</div>';
                                        
                                        $labelsDisplayed = true;
                                    }
                                echo '</div>'; // Close form-row
                            echo '</div>'; // Close form-row-container
                        }
                ?>

                <?php
                    // Special Endorsement Section
                    $hasOtherEndorsement = $resultOtherEndorsement -> num_rows > 0;

                        if ($hasOtherEndorsement){
                            while ($row = $resultOtherEndorsement->fetch_assoc()) {
                                echo '<h2>OTHERS / SPECIAL ENDORSEMENT</h2>';
                                echo '<div class="form-row-container">';
                                    echo '<div class="form-row">';
                                        echo '<div class="form-group">';
                                            echo '<textarea id="specialendorse" name="specialendorse" placeholder="Enter special endorsement">' . htmlspecialchars($row['Other_Endorsement']) . '</textarea>';
                                        echo '</div>';
                                    echo '</div>';
                                echo '</div>';
                            }
                        }
                        
                        else{
                            echo '<h2>OTHERS / SPECIAL ENDORSEMENT</h2>';
                            echo '<div class="form-row-container">';
                                echo '<div class="form-row">';
                                    echo '<div class="form-group">';
                                        echo '<textarea id="specialendorse" name="specialendorse" placeholder="Enter special endorsement"></textarea>';
                                    echo '</div>';
                                echo '</div>';
                            echo '</div>';
                        }
                ?>
                

                <div class="form-actions">
                    <button type="button" class="edit">Edit</button>
                    <button type="submit" name="Kardex" class="save">Save</button>
                </div>
                          
            </form>
        </div>    
    </main>

    <script src="main.js"></script>
   
</body>
</html>