<?php
include 'db_connect.php';


$appointmentId = $_POST['id'];

$sql = "DELETE FROM appointments WHERE id=$appointmentId";

if ($conn->query($sql) === TRUE) {
    echo "Appointment removed successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>