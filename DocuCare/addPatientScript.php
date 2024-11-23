<?php
session_start();

$server = 'localhost';
$user = 'root';
$pass ='';
$db = 'docudatasql';

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try{
	$connection = mysqli_connect($server, $user, $pass, $db);
}catch (Exception $ex)
{
	echo'Error';
}

if(isset($_POST['New_Patient']))
{
    $Patient_ID = mysqli_real_escape_string($connection, $_POST['patientID']);
	$Patient_Name = mysqli_real_escape_string($connection, $_POST['patientName']);
	$Age = mysqli_real_escape_string($connection, $_POST['age']);
	$Sex = mysqli_real_escape_string($connection, $_POST['sex']);
	$Room_Num = mysqli_real_escape_string($connection, $_POST['roomNo']);
    $Address = mysqli_real_escape_string($connection, $_POST['address']);
	$birthplace = mysqli_real_escape_string($connection, $_POST['birthplace']);
	$DoB = mysqli_real_escape_string($connection, $_POST['DoB']);
	$Attending_Physician = mysqli_real_escape_string($connection, $_POST['attendingPhysician']);
	$Mother_Name = mysqli_real_escape_string($connection, $_POST['motherName']);
	$Mother_Contact = mysqli_real_escape_string($connection, $_POST['motherPhone']);
    $Father_Name = mysqli_real_escape_string($connection, $_POST['fatherName']);
	$Father_Contact = mysqli_real_escape_string($connection, $_POST['fatherPhone']);
	$Emergency_Contact_Name = mysqli_real_escape_string($connection, $_POST['emergencyContactName']);
	$Emergency_Contact = mysqli_real_escape_string($connection, $_POST['emergencyContactPhone']);
    $Relation_to_Patient = mysqli_real_escape_string($connection, $_POST['emergencyContactRelationship']);
	$Medical_History = mysqli_real_escape_string($connection, $_POST['medicalHistory']);
	$Allergies = mysqli_real_escape_string($connection, $_POST['allergies']);
	$Current_Medication = mysqli_real_escape_string($connection, $_POST['currentMedications']);

	//insert data to table
	$insert = "INSERT INTO patient_tbl (Patient_ID, Patient_Name, Age, Sex, Room_Num, Address, Birthplace, DoB, Attending_Physician, Mother_Name, 
                                        Mother_Contact, Father_Name, Father_Contact, Emergency_Contact_Name, Emergency_Contact, 
                                        Relation_to_Patient, Medical_History, Allergies, Current_Medication)

				VALUES('$Patient_ID', '$Patient_Name', '$Age', '$Sex', '$Room_Num', '$Address', '$birthplace', '$DoB', '$Attending_Physician', '$Mother_Name', 
                    '$Mother_Contact', '$Father_Name', '$Father_Contact', '$Emergency_Contact_Name', '$Emergency_Contact', 
                    '$Relation_to_Patient', '$Medical_History', '$Allergies', '$Current_Medication')";

	try{
		$insert_result = mysqli_query($connection, $insert);

		if($insert_result)
		{
			if(mysqli_affected_rows($connection) > 0)
			{
				print '<script>alert("Sucessfully Added!");</script>';
				Print '<script>window.location.assign("ChartingList.php");</script>';
			}else{
				echo'Data not inserted!';
			}
		}
	}
	catch (Exception $ex)
	{
		echo 'Error Insert'.$ex -> getMessage();
	}
}
?>
