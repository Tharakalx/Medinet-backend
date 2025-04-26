<?php
// patientreg.php

// Database connection settings
$host = "localhost";
$user = "root";
$password = "";
$database = "medinetdb";

// Connect to database
$conn = new mysqli($host, $user, $password, $database);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if request is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data safely
    $phone = $conn->real_escape_string($_POST['phone']);
    $nic = $conn->real_escape_string($_POST['nic']);
    $name = $conn->real_escape_string($_POST['name']);
    $dob = $conn->real_escape_string($_POST['dob']);
    $address = $conn->real_escape_string($_POST['address']);
    $city = $conn->real_escape_string($_POST['city']);
    $email = $conn->real_escape_string($_POST['email']);
    $blood_group = $conn->real_escape_string($_POST['blood_group']);
    $weight = $conn->real_escape_string($_POST['weight']);
    $height = $conn->real_escape_string($_POST['height']);
    $issue = $conn->real_escape_string($_POST['issue']);

    // If you want to assign default values for missing fields (optional)
    $gender = "Not specified"; 
    $password = "default"; 
    // $dispensary_id = 1;

    // SQL Insert
    $sql = "INSERT INTO patients 
        (name, nic, phone_number , address, city, email, date_of_birth, blood_group, weight, height, issue, gender, password)
        VALUES 
        ('$name', '$nic', '$phone', '$address', '$city', '$email', '$dob', '$blood_group', '$weight', '$height', '$issue', '$gender', '$password' )";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
