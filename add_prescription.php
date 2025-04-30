<?php
include 'db_connect.php';


$patientId = $_POST['patient_id'];
$description = $_POST['description'];
$appointment_id =$_POST['appointment_id']; // hardcoded
$doctor_id  = 2;
$sql = "INSERT INTO prescriptions (patient_id,doctor_id , appointment_id, description) 
        VALUES ('$patientId', '$doctor_id','$appointment_id', '$description')";

if ($conn->query($sql) === TRUE) {
    echo "Prescription added successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>