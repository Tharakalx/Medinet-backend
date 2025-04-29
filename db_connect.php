<?php
function connectDB() {
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'medinetdb';

    $conn = new mysqli($host, $user, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    return $conn;
}
?>
