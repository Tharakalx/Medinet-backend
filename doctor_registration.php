<?php
$conn = new mysqli('localhost', 'root', '', 'madinetdb');

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'] ?? '';
    $nic_no = $_POST['nic_no'] ?? '';
    $email = $_POST['email'] ?? '';
    $phone_number = $_POST['phone_number'] ?? '';
    $hospital = $_POST['hospital'] ?? '';
    $dispensary_id = $_POST['dispensary_id'] ?? '';

    if (empty($name) || empty($nic_no) || empty($email) || empty($phone_number) || empty($hospital) || empty($dispensary_id)) {
        die('Please fill all the fields.');
    }

    // Insert into doctors table
    $sql = "INSERT INTO doctors (name, nic_no, email, phone_number, hospital, dispensary_id)
            VALUES ('$name', '$nic_no', '$email', '$phone_number', '$hospital', '$dispensary_id')";

    if ($conn->query($sql) === TRUE) {
        header("Location: ../Medinet-frontend/pages/set_credentials.php?nic_no=$nic_no");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
} else {
    die('Invalid request.');
}

$conn->close();
?>
