<?php
        require_once 'mycon.php';
       
        if(ISSET($_POST['upload'])){
                $Patient_ID=mysqli_escape_string($connection, $_POST['Patient_ID']);
                $User_ID = mysqli_real_escape_string($connection, $_POST['User_ID']);
                $image_name = $_FILES['image']['name'];
                $image_temp = $_FILES['image']['tmp_name'];
                $image_size = $_FILES['image']['size'];
                $ext = explode(".", $image_name);
                $end = end($ext);
                $allowed_ext = array("jpg", "JPG", "jpeg", "JPEG", "gif", "GIF", "png", "PNG");
                $name = time().".".$end;
                if(!is_dir("upload/"))
                mkdir("upload/");
                $path = "upload/".$name;
                if(in_array($end, $allowed_ext)){
                        if($image_size > 5242880){
                                echo "<script>alert('File too large!')</script>";
                                echo "<script>window.location = 'labResults.php?Patient_ID=$Patient_ID';</script>";
                        }else{
                                if(move_uploaded_file($image_temp, $path)){
                                    $upload_date = date('Y-m-d H:i:s'); // Get current date and time
                                    mysqli_query($connection, "INSERT INTO `patient_lab_results` (Patient_ID, Entered_By_Nurse, File_Name, Upload_Date, Image_Location ) VALUES ('$Patient_ID', '$User_ID', '$name', '$upload_date', '$path')") or die(mysqli_error($connection));   
                                    echo "<script>alert('Image uploaded!')</script>";
                                    echo "<script>window.location = 'labResults.php?Patient_ID=$Patient_ID';</script>";

                                }
                        }
                }else{
                        echo "<script>alert('Invalid image format!')</script>";
                        echo "<script>window.location = 'labResults.php'</script>";
                }
               
               
        }
?>