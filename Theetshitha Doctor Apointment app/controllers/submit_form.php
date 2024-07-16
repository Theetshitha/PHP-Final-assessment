<?php
include '../config/config.php';


function sanitizeInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
   
    $patientName = sanitizeInput($_POST['patientName']);
    $patientAge = intval($_POST['patientAge']);
    $reason = sanitizeInput($_POST['reason']);
    $contactNo = sanitizeInput($_POST['contactNo']);
    $dateTime = $_POST['dateTime']; 

    $currentDateTime = date('Y-m-d H:i:s');
    if ($dateTime < $currentDateTime) {
        $response = ['success' => false, 'message' => 'Cannot book an appointment for a past date or time.'];
    } else {
        // Check if the date and time slot is available and there's a 30-minute break
        $sqlCheck = "SELECT COUNT(*) AS count FROM appointments WHERE ABS(TIMESTAMPDIFF(MINUTE, dateTime, ?)) < 30";
        $stmtCheck = $pdo->prepare($sqlCheck);
        $stmtCheck->execute([$dateTime]);
        $result = $stmtCheck->fetch(PDO::FETCH_ASSOC);

        if ($result['count'] > 0) {
            
            $response = ['success' => false, 'message' => 'Doctor is not available. Choose alternate date and time.'];
        } else {
            
            $sqlInsert = "INSERT INTO appointments (patientName, patientAge, reason, contactNo, dateTime)
                          VALUES (?, ?, ?, ?, ?)";
            $stmtInsert = $pdo->prepare($sqlInsert);
            $stmtInsert->execute([$patientName, $patientAge, $reason, $contactNo, $dateTime]);

            if ($stmtInsert) {
                $response = ['success' => true];
            } else {
                $response = ['success' => false, 'message' => 'Failed to insert appointment. Please try again.'];
            }
        }
    }

    // Return response as JSON
    header('Content-Type: application/json');
    echo json_encode($response);
    exit; 
}
?>
