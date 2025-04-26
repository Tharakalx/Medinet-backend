<?php
include 'db_connect.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    if (isset($_GET['action']) && $_GET['action'] === 'get') {
        $sql = "SELECT * FROM medicines";
        $result = $conn->query($sql);

        $medicines = [];
        while ($row = $result->fetch_assoc()) {
            $medicines[] = $row;
        }
        echo json_encode($medicines);
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];

    if ($action === 'add') {
        $name = $_POST['name'];
        $stock = $_POST['stock'];
        $expiry = $_POST['expiry'];

        $stmt = $conn->prepare("INSERT INTO medicines (name, stock, expiry) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $stock, $expiry);
        $stmt->execute();
        echo "success";
    }

    if ($action === 'update') {
        $id = $_POST['id'];
        $name = $_POST['name'];
        $stock = $_POST['stock'];
        $expiry = $_POST['expiry'];

        $stmt = $conn->prepare("UPDATE medicines SET name=?, stock=?, expiry=? WHERE id=?");
        $stmt->bind_param("sisi", $name, $stock, $expiry, $id);
        $stmt->execute();
        echo "success";
    }

    if ($action === 'delete') {
        $id = $_POST['id'];

        $stmt = $conn->prepare("DELETE FROM medicines WHERE id=?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        echo "success";
    }
}
?>

