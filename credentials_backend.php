<?php
$conn = new mysqli('localhost', 'root', '', 'madinetdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$nic_no = $_POST['nic_no'];
$username = $_POST['username'];
$password = $_POST['password'];

// Hash the password for security
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Insert into doctor_login table
$sql = "INSERT INTO doctorlogin (nic_no, username, password)
        VALUES ('$nic_no', '$username', '$hashed_password')";

if ($conn->query($sql) === TRUE) {
    // Registration complete - redirect to main login
    header("Location: ../Medinet-frontend/pages/pharmecist_registration.php");
    
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
