<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "medinetdb";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM medicines";
$result = $conn->query($sql);

$medicines = array();
while($row = $result->fetch_assoc()) {
  $medicines[] = $row;
}

echo json_encode($medicines);

$conn->close();
?>
