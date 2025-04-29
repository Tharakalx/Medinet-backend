<?php
// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$database = "medinetdb";

// Enable CORS
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Allow-Headers: Content-Type");
header("Content-Type: application/json");

// Connect to database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die(json_encode(["status" => "error", "message" => "Connection failed: " . $conn->connect_error]));
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the raw POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Validate input
    if (!isset($data['username']) || !isset($data['password'])) {
        echo json_encode(["status" => "error", "message" => "Username and password are required"]);
        exit;
    }

    // Prepare statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM dispensary WHERE username = ? AND password = ?");
    $stmt->bind_param("ss", $data['username'], $data['password']);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Dispensary found
        $dispensary = $result->fetch_assoc();
        echo json_encode([
            "status" => "success",
            "message" => "Login successful",
            "dispensary" => [
                "id" => $dispensary['id'],
                "name" => $dispensary['name'],
                "username" => $dispensary['username'],
                "address" => $dispensary['address'],
                "contact" => $dispensary['contact']
                // Add other dispensary details as needed
            ]
        ]);
    } else {
        // Dispensary not found or invalid credentials
        echo json_encode([
            "status" => "error", 
            "message" => "Invalid username or password"
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    // If not POST request
    echo json_encode([
        "status" => "error", 
        "message" => "Invalid request method. Only POST requests are allowed."
    ]);
}
?>