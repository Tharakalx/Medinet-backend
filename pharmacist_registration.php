<?php
// Database connection
$conn = new mysqli('localhost', 'root', '', 'madinetdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get form data safely
    $name = $_POST['name'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';

    // Basic validation
    if (empty($name) || empty($phone_number) || empty($username) || empty($password)) {
        die('Please fill all the fields.');
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Use Prepared Statement for safer insert
    $stmt = $conn->prepare("INSERT INTO pharmacists (name, phone_number, username, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $phone_number, $username, $hashed_password);

    if ($stmt->execute()) {
        // Get last inserted pharmacist id
        $pharmacist_id = $conn->insert_id;
        // Redirect to a confirmation page or another relevant page
        header("Location: ../Medinet-frontend/login.php");
        exit();
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
} else {
    die('Invalid request.');
}

$conn->close();