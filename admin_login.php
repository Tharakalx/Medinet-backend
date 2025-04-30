<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST');
header('Access-Control-Allow-Headers: Content-Type');
header('Access-Control-Allow-Credentials: true');

// Get JSON input
$data = json_decode(file_get_contents('php://input'), true);

// Validate input
if (!isset($data['username']) || !isset($data['password'])) {
    echo json_encode([
        "success" => false,
        "message" => "Username and password are required"
    ]);
    exit();
}

$username = $data['username'];
$password = $data['password'];

// Database connection
$conn = new mysqli("localhost", "root", "", "medinetdb");

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Connection failed']));
}

// Check admin credentials
$stmt = $conn->prepare("SELECT * FROM admins WHERE username = ? AND password = ?");
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    // Start session and store admin info
    session_start();
    $_SESSION['user_id'] = $admin['admin_id'];  // Changed from 'id' to 'admin_id'
    $_SESSION['user_type'] = 'admin';
    
    echo json_encode([
        'success' => true,
        'message' => 'Login successful',
        'userType' => 'Admin',
        'userData' => $admin 
    ]);
} else {
    echo json_encode([
        'success' => false, 
        'message' => 'Invalid credentials'
    ]);
}

$stmt->close();
$conn->close();
?>