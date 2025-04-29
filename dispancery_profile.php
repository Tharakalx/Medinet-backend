<?php
// dispancery_profile.php

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

// Initialize PHP variables for the dispensary details
$id = null;
$address = $city = $license_number = $contact_number = $doctor_id = $open_time = $close_time = "";

// Check if the id is provided
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare SQL query to fetch the dispensary details by ID
    $sql = "SELECT * FROM dispensaries WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id); // "i" denotes integer type
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if a row is returned
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();

        // Store the fetched data in PHP variables
        $address = $row['address'];
        $city = $row['city'];
        $license_number = $row['license_number'];
        $contact_number = $row['contact_number'];
        $doctor_id = $row['doctor_id'];
        $open_time = $row['open_time'];
        $close_time = $row['close_time'];

        // Send the data as JSON
        echo json_encode([
            'id' => $id,
            'address' => $address,
            'city' => $city,
            'license_number' => $license_number,
            'contact_number' => $contact_number,
            'doctor_id' => $doctor_id,
            'open_time' => $open_time,
            'close_time' => $close_time
        ]);
    } else {
        // Send error message if dispensary not found
        echo json_encode(["message" => "Dispensary not found"]);
    }

    // Close the prepared statement
    $stmt->close();
} else {
    echo json_encode(["message" => "No dispensary ID provided"]);
}

// Close connection
$conn->close();
?>
