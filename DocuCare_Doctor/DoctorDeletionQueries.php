<?php
include 'mycon.php'; 

//STANDING ORDER DELETION QUERY
if (isset($_GET['act']) && $_GET['act'] == 'DeleteStandingOrder') {
    $Patient_ID = $_GET['Patient_ID'];
    $Standing_Order_ID = $_GET['Standing_Order_ID'];

    $query = "DELETE FROM standing_order 
              WHERE Standing_Order_ID = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $Standing_Order_ID);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("standingOrder.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
            } else {
                echo 'No records were deleted!';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

//MEDICATION RECORD DELETION QUERIES
if (isset($_GET['act']) && $_GET['act'] == 'DeleteSO') {
    $Patient_ID = $_GET['Patient_ID'];
    $Medication_SO_ID = $_GET['Medication_SO_ID'];

    $query = "UPDATE medication_record_so 
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Medication_SO_ID = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $Medication_SO_ID);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("medRecord.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
            } else {
                echo 'No records were deleted!';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'DeletePRN') {
    $Patient_ID = $_GET['Patient_ID'];
    $Medication_PRN_ID = $_GET['Medication_PRN_ID'];

    $query = "UPDATE medication_record_prn
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Medication_PRN_ID = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $Medication_PRN_ID);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("medRecord.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
            } else {
                echo 'No records were deleted!';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

if (isset($_GET['act']) && $_GET['act'] == 'DeleteSTAT') {
    $Patient_ID = $_GET['Patient_ID'];
    $Medication_STAT_ID = $_GET['Medication_STAT_ID'];

    $query = "UPDATE medication_record_stat
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Medication_STAT_ID = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $Medication_STAT_ID);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("medRecord.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
            } else {
                echo 'No records were deleted!';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

//DOCTORS ORDER DELETION QUERY
if (isset($_GET['act']) && $_GET['act'] == 'DeleteOrder') {
    $Patient_ID = $_GET['Patient_ID'];
    $Doctor_Order_ID = $_GET['Doctor_Order_ID'];

    $query = "UPDATE doctors_order
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Doctor_Order_ID = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 's', $Doctor_Order_ID);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("doctorsOrder.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
            } else {
                echo 'No records were deleted!';
            }
        } else {
            echo "Error: " . mysqli_error($connection);
        }

        mysqli_stmt_close($stmt);
    } else {
        echo "Error preparing statement: " . mysqli_error($connection);
    }
}

?>