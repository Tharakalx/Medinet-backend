<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medinetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$patient_id = $_GET['patient_id'];

$sql = "SELECT * FROM prescriptions WHERE patient_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $patient_id);
$stmt->execute();
$result = $stmt->get_result();

$prescriptions = array();
while($row = $result->fetch_assoc()) {
  $prescriptions[] = $row;
}

echo json_encode($prescriptions);

$conn->close();
?>
