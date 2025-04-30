<?php
// backend.php

// Database connection details
$host = 'localhost';
$user = 'root';
$password = '';
$database = 'medinetdb';

// Connect to MySQL
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check request type
$requestMethod = $_SERVER['REQUEST_METHOD'];

// Handle GET request for dispensary details
if ($requestMethod == 'GET' && isset($_GET['id'])) {
    $dispensary_id = $_GET['id'];

    // Prepare SQL query to fetch dispensary details by ID
    $sql = "SELECT * FROM dispensaries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $dispensary_id); // "i" denotes integer type
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Send the dispensary data as JSON
        echo json_encode([
            'id' => $row['id'],
            'address' => $row['address'],
            'city' => $row['city'],
            'license_number' => $row['license_number'],
            'contact_number' => $row['contact_number'],
            'doctor_id' => $row['doctor_id'],
            'open_time' => $row['open_time'],
            'close_time' => $row['close_time']
        ]);
    } else {
        // Send error message if dispensary not found
        echo json_encode(["message" => "Dispensary not found"]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Handle POST request for adding an appointment
elseif ($requestMethod == 'POST') {
    // Get the appointment data from the frontend (sent as JSON)
    $data = json_decode(file_get_contents('php://input'), true);

    // Extract the values
    $doctor_id = $data['doctor_id'];
    $patient_id = $data['patient_id'];
    $patient_number = $data['patient_number'];
    $dispensary_id = $data['dispensary_id'];
    $date = $data['date'];
    $time_slot = $data['time_slot'];
    $status = $data['status'];

    // Insert the appointment data into the appointments table
    $sql = "INSERT INTO appointments (doctor_id, patient_id, patient_number, dispensary_id, date, time_slot, status)
            VALUES (?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("isssiss", $doctor_id, $patient_id, $patient_number, $dispensary_id, $date, $time_slot, $status);

    if ($stmt->execute()) {
        // Return success response if appointment is added
        echo json_encode(['success' => true]);
    } else {
        // Return error response if appointment insertion fails
        echo json_encode(['success' => false, 'message' => $stmt->error]);
    }

    // Close the prepared statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
