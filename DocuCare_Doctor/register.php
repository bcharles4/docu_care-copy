<?php
 session_start();
 include('mycon.php');

 $result = $connection->query("SELECT MAX(User_ID) AS max_id FROM user_tbl");
 $row = $result->fetch_assoc();
 
 // Check if there are no Nurse yet
 if ($row['max_id'] === NULL) {
 $nextUserID = 1; // Start from 1 if no Nurse exist
 } 
 
 else {
 $nextUserID = $row['max_id'] + 1;
 }

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>DocuCare Register</title>
    <link rel="icon" type="image/png" sizes="32x32" href="img/logo.png">
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="register-form">
        <div class="container">
            <div class="main2">
                <div class="content2">
                    <h2>Add New User</h2>
                    <form method="POST" action="RegisterScript.php">
                        <div class="input-pair">
                          <input type="text" name="User_FName" placeholder="First Name" required>
                          <input type="text" name="User_MName" placeholder="Middle Name" required>
                        </div>
                        <div class="input-pair">
                          <input type="text" name="User_LName" placeholder="Last Name" required>
                          <input type="text" name="ContactNo" placeholder="Contact No." required> 
                        </div>     
                        <div class="input-pair">       
                            <input type="text" name="Department" placeholder="Department" required>  
                            <select name="Position" required>
                                <option value="" disabled selected>Position/Role</option>
                                <option value="Nurse 1">Nurse 1</option>
                                <option value="Nurse 2">Nurse 2</option>
                                <option value="Admin">Admin</option>
                            </select>       
                        </div>
                        <input type="email" name="Email" placeholder="Email" required>
                        <input type="password" name="Password" placeholder="Password" required>  
  
                        <input type="submit" id="reg-btn" name="register" value="Register"/>
                    </form>
                </div>
                <div class="form-img">
                    <img src="img/bg.png" alt="Background Image">
                </div>
            </div>
        </div>
    </div>
</body>
</html>