<?php
session_start();
include('mycon.php'); 

if (isset($_POST['log_user'])) {
    $Email = mysqli_real_escape_string($connection, $_POST['Email']);
    $Password = mysqli_real_escape_string($connection, $_POST['Password']);
    $captcha = $_POST['captcha'];

    // Verify the CAPTCHA
    if ($captcha !== $_SESSION['captcha_code']) {
        echo '<script>alert("Incorrect CAPTCHA! Please try again.");</script>';
        echo '<script>window.location.assign("index.php");</script>';
        exit;
    }

    // Fetch data from API
    $APIUrl = 'http://localhost/docucare_main/sfasfad/DocuCare_Doctor/api.php?table=user_tbl';
    
    $UserDataJson = file_get_contents($APIUrl);
    $UserData = json_decode($UserDataJson, true);
    
    $DoctorUsers = [];
    if(is_array($UserData)){
        foreach($UserData as $User){
            if($User['Position'] == 'Doctor'){
                $DoctorUsers[] = $User;
            }
        }
    }

    $isAuthenticated = false;
    $isDoctor = false; // To check if the user is a doctor
    
    foreach ($UserData as $User) {
        if ($User['Email'] === $Email) {
            if ($User['Position'] === 'Doctor') {
                $isDoctor = true; // Mark that the user is a doctor
    
                // Check if the password is correct
                if ($User['Password'] === $Password) {
                    // Successful login
                    $_SESSION['User_ID'] = $User['User_ID'];
                    $_SESSION['User_FName'] = $User['User_FName'];
                    $_SESSION['User_MName'] = $User['User_MName'];
                    $_SESSION['User_LName'] = $User['User_LName'];
                    $_SESSION['Contact_Num'] = $User['Contact_Num'];
                    $_SESSION['Department'] = $User['Department'];
                    $_SESSION['Position'] = $User['Position'];
                    $_SESSION['Email'] = $Email;
    
                    $isAuthenticated = true;
                    break; // Exit the loop if authentication is successful
                }
            }
        }
    }
    
    // Handle authentication and access restriction messages
    if ($isAuthenticated) {
        // Redirect to the dashboard if authentication is successful
        echo '<script>window.location.assign("dashboard.php");</script>';
    } else {
        if ($isDoctor) {
            // If the user is a doctor but entered the wrong email or password
            echo '<script>alert("Incorrect Email or Password. Please try again.");</script>';
        } else {
            // If the user is not a doctor
            echo '<script>alert("Access Restricted: This platform is for doctors only.");</script>';
        }
        // Redirect back to the login page
        echo '<script>window.location.assign("index.php");</script>';
    }
}
?>