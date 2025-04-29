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

$name = $data['name'];
$stock = $data['stock'];
$expiry = $data['expiry'];

$sql = "INSERT INTO medicines (name, stock, expiry) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sis", $name, $stock, $expiry);

if ($stmt->execute()) {
  echo "Medicine added successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$conn->close();
?>
