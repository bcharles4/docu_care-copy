<?php
include 'mycon.php'; 

//TPR SCRIPT DELETION QUERIES
if (isset($_GET['act']) && $_GET['act'] == 'DeleteVitals') {
    $Patient_ID = $_GET['Patient_ID'];
    $Vitals_Date	= $_GET['Vitals_Date'];
    $Vitals_Time_Check = $_GET['Vitals_Time_Check'];


    $query = "UPDATE tpr_vital_signs 
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Patient_ID = ? AND Vitals_Date = ? AND Vitals_Time_Check = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'sss', $Patient_ID, $Vitals_Date, $Vitals_Time_Check);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("tprChart.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
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

if (isset($_GET['act']) && $_GET['act'] == 'DeleteVitalsOutput') {
    $Patient_ID = $_GET['Patient_ID'];
    $Date	= $_GET['Date'];
    $Output_Time_Check = $_GET['Output_Time_Check'];


    $query = "UPDATE tpr_vital_signs_output 
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Patient_ID = ? AND Date = ? AND Output_Time_Check = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'sss', $Patient_ID, $Date, $Output_Time_Check);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("tprChart.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
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
//TPR SCRIPT DELETION QUERIES END

//NURSE NOTES DELETION QUERY
if (isset($_GET['act']) && $_GET['act'] == 'DeleteNurseNotes') {
    $Patient_ID = $_GET['Patient_ID'];
    $Date_Time	= $_GET['Date_Time'];
    $Focus = $_GET['Focus'];
    $Action_Response = $_GET['Action_Response'];


    $query = "UPDATE nurse_notes 
              SET Status = 'x', Deletion_Date = CURDATE()
              WHERE Patient_ID = ? AND Date_Time = ? AND Focus = ? AND Action_Response = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $Patient_ID, $Date_Time, $Focus, $Action_Response);
        
        if (mysqli_stmt_execute($stmt)) {
            if (mysqli_stmt_affected_rows($stmt) > 0) {
                print '<script>alert("Successfully Deleted");</script>';
                echo '<script>window.location.assign("nurseNotes.php?Patient_ID=' . htmlspecialchars($Patient_ID) . '");</script>';
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
//NURSE NOTES DELETION QUERY END

//STANDING ORDER RESPONSE DELETION QUERY
if (isset($_GET['act']) && $_GET['act'] == 'DeleteOrderResponse') {
    $Patient_ID = $_GET['Patient_ID'];
    $Order_Start_Date = $_GET['Order_Start_Date']; 
    $Order_Discontinued_Date = $_GET['Order_Discontinued_Date']; 
    $Remarks = $_GET['Remarks'];


    $query = "DELETE FROM standing_order_response 
    WHERE Patient_ID = ?
    AND Order_Start_Date = ?
    AND Order_Discontinued_Date = ?
    AND Remarks = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $Patient_ID, $Order_Start_Date, $Order_Discontinued_Date, $Remarks);
        
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
//STANDING ORDER RESPONSE DELETION QUERY END

//MED RECORDS RESPONSE DELETION QUERY
if (isset($_GET['act']) && $_GET['act'] == 'DeleteSOResponse') {
    $Patient_ID = $_GET['Patient_ID'];
    $SO_10_6 = $_GET['SO_10_6']; 
    $SO_6_2 = $_GET['SO_6_2']; 
    $SO_2_10 = $_GET['SO_2_10'];


    $query = "DELETE FROM medication_record_so_response 
              WHERE Patient_ID = ?
              AND SO_10_6 = ?
              AND SO_6_2 = ?
              AND SO_2_10 = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $Patient_ID, $SO_10_6, $SO_6_2, $SO_2_10);
        
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

if (isset($_GET['act']) && $_GET['act'] == 'DeletePRNResponse') {
    $Patient_ID = $_GET['Patient_ID'];
    $PRN_10_6 = $_GET['PRN_10_6']; 
    $PRN_6_2 = $_GET['PRN_6_2']; 
    $PRN_2_10 = $_GET['PRN_2_10'];


    $query = "DELETE FROM medication_record_prn_response 
              WHERE Patient_ID = ?
              AND PRN_10_6 = ?
              AND PRN_6_2 = ?
              AND PRN_2_10 = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $Patient_ID, $PRN_10_6, $PRN_6_2, $PRN_2_10);
        
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

if (isset($_GET['act']) && $_GET['act'] == 'DeleteSTATResponse') {
    $Patient_ID = $_GET['Patient_ID'];
    $STAT_10_6 = $_GET['STAT_10_6']; 
    $STAT_6_2 = $_GET['STAT_6_2']; 
    $STAT_2_10 = $_GET['STAT_2_10'];


    $query = "DELETE FROM medication_record_stat_response 
              WHERE Patient_ID = ?
              AND STAT_10_6 = ?
              AND STAT_6_2 = ?
              AND STAT_2_10 = ?";
    
    if ($stmt = mysqli_prepare($connection, $query)) {
        mysqli_stmt_bind_param($stmt, 'ssss', $Patient_ID, $STAT_10_6, $STAT_6_2, $STAT_2_10);
        
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
//MED  RECORDS RESPONSE DELETION QUERY END

?>