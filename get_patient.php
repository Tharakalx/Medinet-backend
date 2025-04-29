<?php
require 'db_connect.php'; // or db_connection.php, make it consistent
$conn = connectDB();

if (isset($_GET['patient_id'])) {
    $patient_id = $conn->real_escape_string($_GET['patient_id']);

    $sql = "SELECT name, date_of_birth, blood_group, height, weight FROM patients WHERE phone_number = '$patient_id'";
    $result = $conn->query($sql);

    if ($result && $result->num_rows === 1) {
        echo json_encode($result->fetch_assoc());
    } else {
        echo json_encode(["error" => "Patient not found."]);
    }
} else {
    echo json_encode(["error" => "Invalid request."]);
}
?>
