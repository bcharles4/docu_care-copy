<?php
include('mycon.php');

  //count total patients
  $PatientQuery = "SELECT COUNT(Patient_ID) AS Patient_ID FROM patient_info";
  $PatientQueryResult = $connection->query($PatientQuery);
  
    $row = $PatientQueryResult->fetch_assoc();
    $TotalPatients = $row["Patient_ID"];

  //count total patients admitted today
  $AdmissionsToday='WIP';

  //count occupied rooms
  $OccupiedRoomsQuery='SELECT COUNT(Room_Number) AS Room_Number FROM rooms WHERE Room_Status = "Occupied"';
  $OccupiedRoomQueryResult = $connection->query($OccupiedRoomsQuery);
  
    $row = $OccupiedRoomQueryResult->fetch_assoc();
    $TotalOccupiedRooms = $row["Room_Number"];

  //count vacant rooms
  $AvailableRoomsQuery='SELECT COUNT(Room_Number) AS Room_Number FROM rooms WHERE Room_Status = "Available"';
  $VacantRoomQueryResult = $connection->query($AvailableRoomsQuery);
  
    $row = $VacantRoomQueryResult->fetch_assoc();
    $TotalAvailableRooms = $row["Room_Number"];
?>