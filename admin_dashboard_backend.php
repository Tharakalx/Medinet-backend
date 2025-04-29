<?php
include 'db_connect.php';

$type = isset($_GET['type']) ? $_GET['type'] : '';

switch ($type) {
    case 'doctor':
        $sql = "SELECT name, id, phone_number, mbbs, license_number, hospital ,dispensary_id FROM doctors";
        break;

    case 'patient':
        
        $sql = "SELECT phone_number, name, TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) AS age, gender, city FROM patients";
        break;

    case 'dispensaries':
        $sql = "SELECT id, address, city, license_number, contact_number, doctor_id, open_time, close_time FROM dispensaries";
        break;
    case 'countdispensaries':
            $sql ="SELECT COUNT(*) AS total_dispensaries
            FROM dispensaries";
            
          break;  
            
     case 'countdiPatients':
            $sql ="SELECT COUNT(*) AS total_Patients
            FROM patients";
          break; 
          
     case 'countdiDoctors':
            $sql ="SELECT COUNT(*) AS total_Doctors
            FROM doctors";
          break;  
     case 'countdiAppointments':
        $sql = "SELECT COUNT(*) AS total_Appointments 
        FROM appointments 
        WHERE DATE(date) = CURDATE()";

          break;   
          case 'appointmentslast14days':
            $sql = "SELECT DATE(date) as appointment_day, COUNT(*) as count
                    FROM appointments
                    WHERE date >= CURDATE() - INTERVAL 13 DAY
                    GROUP BY DATE(date)
                    ORDER BY appointment_day";
            break;
          

    default:
        echo json_encode(["error" => "Invalid or missing 'type' parameter."]);
        exit;
}

$result = $conn->query($sql);

$data = [];
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }
}

echo json_encode($data);
$conn->close();
?>
