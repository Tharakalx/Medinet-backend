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

// Handle AJAX validation requests
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['check_field'])) {
    $field = $conn->real_escape_string($_POST['field']);
    $value = $conn->real_escape_string($_POST['value']);
    
    switch($field) {
        case 'username':
            $check_sql = "SELECT username FROM patients WHERE username = '$value'";
            $result = $conn->query($check_sql);
            echo ($result->num_rows > 0) ? "exists" : "available";
            break;
            
        case 'nic':
            $check_sql = "SELECT nic FROM patients WHERE nic = '$value'";
            $result = $conn->query($check_sql);
            echo ($result->num_rows > 0) ? "exists" : "available";
            break;
            
        case 'phone':
            $check_sql = "SELECT phone_number FROM patients WHERE phone_number = '$value'";
            $result = $conn->query($check_sql);
            echo ($result->num_rows > 0) ? "exists" : "available";
            break;
    }
    exit;
}

// Handle full form submission
if ($_SERVER["REQUEST_METHOD"] == "POST" && !isset($_POST['check_field'])) {
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
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);
    $gender = $conn->real_escape_string($_POST['gender']);

    // Check each field separately
    $existing_fields = array();

    // Check username
    $check_username = "SELECT username FROM patients WHERE username = '$username'";
    $result_username = $conn->query($check_username);
    if ($result_username->num_rows > 0) {
        $existing_fields[] = "Username";
    }

    // Check NIC
    $check_nic = "SELECT nic FROM patients WHERE nic = '$nic'";
    $result_nic = $conn->query($check_nic);
    if ($result_nic->num_rows > 0) {
        $existing_fields[] = "NIC";
    }

    // Check phone number
    $check_phone = "SELECT phone_number FROM patients WHERE phone_number = '$phone'";
    $result_phone = $conn->query($check_phone);
    if ($result_phone->num_rows > 0) {
        $existing_fields[] = "Phone number";
    }

    // If any fields exist, return error message
    if (!empty($existing_fields)) {
        echo "exists:" . implode(", ", $existing_fields);
        exit;
    }
    
    // SQL Insert
    $sql = "INSERT INTO patients 
        (name, nic, phone_number, address, city, email, date_of_birth, blood_group, weight, height, gender, password, username)
        VALUES 
        ('$name', '$nic', '$phone', '$address', '$city', '$email', '$dob', '$blood_group', '$weight', '$height', '$gender', '$password', '$username')";

    if ($conn->query($sql) === TRUE) {
        echo "success";
    } else {
        echo "Error: " . $conn->error;
    }

    $conn->close();
}
?>
