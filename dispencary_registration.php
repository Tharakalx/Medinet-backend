<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'madinetdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data safely
    $name = $_POST['name'] ?? '';
    $building_no = $_POST['building_no'] ?? '';
    $street = $_POST['street'] ?? '';
    $city = $_POST['city'] ?? '';
    $district = $_POST['district'] ?? '';
    $zip = $_POST['zip'] ?? '';
    $contact_number = $_POST['contact_number'] ?? '';
    $open_time = $_POST['open_time'] ?? '';
    $close_time = $_POST['close_time'] ?? '';

    // Basic validation
    if (empty($name) || empty($building_no) || empty($street) || empty($city) || empty($district) || empty($zip) || empty($contact_number) || empty($open_time) || empty($close_time)) {
        die('Please fill all the fields.');
    }

    // Use Prepared Statement for safer insert
    $stmt = $conn->prepare("INSERT INTO dispensaries (name, building_no, street, city, district, zip, contact_number, open_time, close_time) 
                            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $name, $building_no, $street, $city, $district, $zip, $contact_number, $open_time, $close_time);

    if ($stmt->execute()) {
        // Get last inserted dispensary id
        $dispensary_id = $conn->insert_id;
        // Redirect to doctor registration page with dispensary id
        header("Location: ../Medinet-frontend/pages/doctor_registration.php?dispensary_id=$dispensary_id");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    die('Invalid request.');
}

$conn->close();
?>
