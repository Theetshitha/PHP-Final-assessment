<?php
class Appointment {
    private $pdo;

    public function __construct($pdo) {
        $this->pdo = $pdo;
    }

    public function getAllAppointments($start, $limit) {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments ORDER BY dateTime ASC LIMIT :start, :limit");
        $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalAppointments() {
        $stmt = $this->pdo->query("SELECT COUNT(*) as count FROM appointments");
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function searchAppointments($query, $start, $limit) {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE patientName LIKE :query OR reason LIKE :query ORDER BY dateTime ASC LIMIT :start, :limit");
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->bindValue(':start', (int) $start, PDO::PARAM_INT);
        $stmt->bindValue(':limit', (int) $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSearchResults($query) {
        $stmt = $this->pdo->prepare("SELECT COUNT(*) as count FROM appointments WHERE patientName LIKE :query OR reason LIKE :query");
        $stmt->bindValue(':query', '%' . $query . '%', PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getAppointmentById($id) {
        $stmt = $this->pdo->prepare("SELECT * FROM appointments WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateAppointment($id, $patientName, $patientAge, $reason, $contactNo, $dateTime) {
        $stmt = $this->pdo->prepare("UPDATE appointments SET patientName = :patientName, patientAge = :patientAge, reason = :reason, contactNo = :contactNo, dateTime = :dateTime WHERE id = :id");
        $stmt->bindValue(':patientName', $patientName, PDO::PARAM_STR);
        $stmt->bindValue(':patientAge', $patientAge, PDO::PARAM_INT);
        $stmt->bindValue(':reason', $reason, PDO::PARAM_STR);
        $stmt->bindValue(':contactNo', $contactNo, PDO::PARAM_STR);
        $stmt->bindValue(':dateTime', $dateTime, PDO::PARAM_STR);
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }

    public function deleteAppointment($id) {
        $stmt = $this->pdo->prepare("DELETE FROM appointments WHERE id = :id");
        $stmt->bindValue(':id', (int) $id, PDO::PARAM_INT);
        return $stmt->execute();
    }
}
?>
