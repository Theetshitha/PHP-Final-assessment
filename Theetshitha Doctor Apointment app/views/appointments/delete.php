<?php
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents("php://input"));

    if (isset($data->id)) {
        $id = intval($data->id);

        // Assuming you have an Appointment class in models/Appointment.php
        include '../../models/Appointment.php';
        $appointment = new Appointment($pdo);

        $success = $appointment->deleteAppointment($id);

        if ($success) {
            http_response_code(200);
            echo json_encode(['success' => true, 'message' => 'Appointment deleted successfully.']);
        } else {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Failed to delete appointment.']);
        }
    } else {
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Invalid request.']);
    }
} else {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method Not Allowed.']);
}
?>
