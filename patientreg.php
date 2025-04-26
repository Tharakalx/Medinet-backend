<?php
// Database connection settings
$host = "localhost"; // XAMPP default
$user = "root"; // Default user
$password = ""; // No password for XAMPP by default
$database = "medinet"; // Change this to your actual database name

// Connect to database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $conn->real_escape_string($_POST['name']);
    $nic = $conn->real_escape_string($_POST['nic']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $email = $conn->real_escape_string($_POST['email']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $weight = $conn->real_escape_string($_POST['weight']);
    $height = $conn->real_escape_string($_POST['height']);
    $issue = $conn->real_escape_string($_POST['issue']);

    // Insert into database
    $sql = "INSERT INTO patients (name, nic, phone, address, city, email, dob, blood_group, weight, height, issue) 
            VALUES ('$name', '$nic', '$phone', '$address', '$city', '$email', '$dob', '$blood_group', '$weight', '$height', '$issue')";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
