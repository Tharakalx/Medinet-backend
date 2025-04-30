<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medinetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$id = $_GET['id'];

$sql = "DELETE FROM medicines WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
  echo "Medicine deleted successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$conn->close();
?>
