
<?php
include 'db_connect.php';
$conn = connectDB();

if (!$conn) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

$sql = "SELECT appointments.id, appointments.patient_id, patients.name AS patient_name 
        FROM appointments 
        JOIN patients ON appointments.patient_id = patients.phone_number";
$result = $conn->query($sql);

$appointments = [];

if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $appointments[] = $row;
    }
}

header('Content-Type: application/json');

echo json_encode($appointments);

$conn->close();
?>
