<?php include 'db_connect.php'; ?>
<?php

// Get search input
$search = isset($_GET['search']) ? $_GET['search'] : '';

$sql = "SELECT * FROM dispensaries"; // Your table name is assumed 'dispensary'
if (!empty($search)) {
    $search = $conn->real_escape_string($search);
    $sql .= " WHERE building_no LIKE '%$search%'
           OR street LIKE '%$search%'
           OR district LIKE '%$search%'";
}

$result = $conn->query($sql);

$dispensaries = array();

if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $dispensaries[] = $row;
    }
}

echo json_encode($dispensaries);

$conn->close();
?>
