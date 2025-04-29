<?php
include 'db_connect.php';
$conn = connectDB();

$appointmentId = $_POST['id'];

$sql = "UPDATE appointments SET status='Accepted' WHERE id=$appointmentId";

if ($conn->query($sql) === TRUE) {
    echo "Appointment accepted successfully";
} else {
    echo "Error: " . $conn->error;
}

$conn->close();
?>
