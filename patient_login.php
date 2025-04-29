<?php
// patient_login.php

// Allow requests from any origin (CORS) if needed
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Methods: POST");

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$database = "medinetdb";

$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Database connection failed."]);
    exit();
}

// Get the raw POST data
$data = json_decode(file_get_contents("php://input"), true);

// Check if username and password are sent
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode(["success" => false, "message" => "Username and password required."]);
    exit();
}

$username = $conn->real_escape_string($data['username']);
$password = $conn->real_escape_string($data['password']);

// Query to check patient
$query = "SELECT * FROM patients WHERE username = '$username' AND password = '$password'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    echo json_encode(["success" => true, "message" => "Login successful."]);
} else {
    echo json_encode(["success" => false, "message" => "Invalid username or password."]);
}

$conn->close();
?>
