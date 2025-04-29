<?php
// Unified login system for all user types

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

$username = $data['username'];
$password = $data['password'];

// Array of tables to check
$tables = [
    'admins' => 'Admin',
    'patients' => 'Patient',
    'doctorlogin' => 'Doctor',
    'pharmacists' => 'Pharmacist'
];

$userFound = false;

// Check each table for the credentials
foreach ($tables as $table => $userType) {
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM $table WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result && $result->num_rows > 0) {
        $user = $result->fetch_assoc();
        echo json_encode([
            "success" => true,
            "message" => "Login successful",
            "userType" => $userType,
            "userData" => $user
        ]);
        $userFound = true;
        $stmt->close();
        break;
    }
    $stmt->close();
}

if (!$userFound) {
    echo json_encode([
        "success" => false,
        "message" => "Invalid username or password"
    ]);
}

$conn->close();
?>
