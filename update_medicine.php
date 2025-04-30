<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medinetdb";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$data = json_decode(file_get_contents('php://input'), true);

$id = $data['id'];
$name = $data['name'];
$stock = $data['stock'];
$expiry = $data['expiry'];

$sql = "UPDATE medicines SET name = ?, stock = ?, expiry = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sisi", $name, $stock, $expiry, $id);

if ($stmt->execute()) {
  echo "Medicine updated successfully.";
} else {
  echo "Error updating medicine: " . $stmt->error;
}

$conn->close();
?>
