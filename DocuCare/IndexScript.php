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

    $query1 = mysqli_query($connection, "SELECT * FROM user_tbl WHERE Email = '$Email'");
    $existing = mysqli_num_rows($query1);

    if ($existing > 0) {
        $row = mysqli_fetch_assoc($query1);
        $table_password = $row['Password'];

        if ($Password == $table_password) {

            $_SESSION['User_ID'] = $row['User_ID'];
            $_SESSION['User_FName'] = $row['User_FName'];
            $_SESSION['User_MName'] = $row['User_MName'];
            $_SESSION['User_LName'] = $row['User_LName'];
            $_SESSION['Contact_Num'] = $row['Contact_Num'];
            $_SESSION['Department'] = $row['Department'];
            $_SESSION['Position'] = $row['Position'];
            $_SESSION['Email'] = $Email;

            echo '<script>window.location.assign("dashboard.php");</script>';
            exit;
        } else {
            echo '<script>alert("Incorrect Password! Please try again.");</script>';
            echo '<script>window.location.assign("index.php");</script>';
            exit;
        }
    } else {
        echo '<script>alert("User not found! Please try again.");</script>';
        echo '<script>window.location.assign("index.php");</script>';
        exit;
    }
}
?>