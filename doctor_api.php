<?php
header("Content-Type: application/json");
require_once 'db_connection.php';

$action = $_GET['action'] ?? '';
$doctor_id = 'DOC001'; // Hardcoded for simplicity

try {
    switch ($action) {
        case 'get_appointments':
            $stmt = $pdo->prepare("SELECT * FROM appointments WHERE status='Pending'");
            $stmt->execute();
            echo json_encode($stmt->fetchAll());
            break;
            
        case 'accept_appointment':
            $id = $_POST['id'];
            $pdo->prepare("UPDATE appointments SET status='Accepted' WHERE id=?")->execute([$id]);
            echo json_encode(['success' => true]);
            break;
            
        case 'remove_appointment':
            $id = $_POST['id'];
            $pdo->prepare("DELETE FROM appointments WHERE id=?")->execute([$id]);
            echo json_encode(['success' => true]);
            break;
            
        case 'get_patient':
            $patient_id = $_GET['patient_id'];
            $stmt = $pdo->prepare("SELECT * FROM patients WHERE patient_id=?");
            $stmt->execute([$patient_id]);
            echo json_encode($stmt->fetch());
            break;
            
        case 'add_prescription':
            $patient_id = $_POST['patient_id'];
            $medicine = $_POST['medicine'];
            $pdo->prepare("INSERT INTO prescriptions (patient_id, doctor_id, medicine, date) VALUES (?,?,?,NOW())")
               ->execute([$patient_id, $doctor_id, $medicine]);
            echo json_encode(['success' => true]);
            break;
            
        default:
            throw new Exception("Invalid action");
    }
} catch (Exception $e) {
    http_response_code(400);
    echo json_encode(['error' => $e->getMessage()]);
}
?>