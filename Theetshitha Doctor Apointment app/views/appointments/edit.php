<?php
include '../../config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $sql = "SELECT * FROM appointments WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$id]);
    $appointment = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$appointment) {
        header('Location: index.php');
        exit;
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = intval($_POST['id']);
    $patientName = htmlspecialchars($_POST['patientName']);
    $patientAge = intval($_POST['patientAge']);
    $reason = htmlspecialchars($_POST['reason']);
    $contactNo = htmlspecialchars($_POST['contactNo']);
    $dateTime = $_POST['dateTime'];

    $sqlUpdate = "UPDATE appointments SET patientName = ?, patientAge = ?, reason = ?, contactNo = ?, dateTime = ? WHERE id = ?";
    $stmtUpdate = $pdo->prepare($sqlUpdate);
    $stmtUpdate->execute([$patientName, $patientAge, $reason, $contactNo, $dateTime, $id]);

    if ($stmtUpdate) {
        header('Location: index.php');
        exit;
    } else {
        echo "Failed to update appointment.";
    }
}
?>

<?php include '../layout/header.php'; ?>

<div class="container mx-auto mt-8">
    <h2 class="text-2xl font-bold mb-4">Edit Appointment</h2>
    <form id="editForm" action="" method="POST" class="space-y-4">
        <input type="hidden" name="id" value="<?= $appointment['id'] ?>">
        <div>
            <label for="patientName" class="block text-sm font-medium text-gray-700">Patient Name</label>
            <input type="text" id="patientName" name="patientName" value="<?= htmlspecialchars($appointment['patientName']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>
        <div>
            <label for="patientAge" class="block text-sm font-medium text-gray-700">Patient Age</label>
            <input type="number" id="patientAge" name="patientAge" value="<?= $appointment['patientAge'] ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>
        <div>
            <label for="reason" class="block text-sm font-medium text-gray-700">Reason for Consultation</label>
            <textarea id="reason" name="reason" rows="3" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50"><?= htmlspecialchars($appointment['reason']) ?></textarea>
        </div>
        <div>
            <label for="contactNo" class="block text-sm font-medium text-gray-700">Contact Number</label>
            <input type="text" id="contactNo" name="contactNo" value="<?= htmlspecialchars($appointment['contactNo']) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>
        <div>
            <label for="dateTime" class="block text-sm font-medium text-gray-700">Date & Time</label>
            <input type="datetime-local" id="dateTime" name="dateTime" value="<?= date('Y-m-d\TH:i', strtotime($appointment['dateTime'])) ?>" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50">
        </div>
        <div class="text-right">
            <button type="submit" class="bg-blue-500 text-white py-2 px-6 rounded-lg inline-block hover:bg-blue-600">Update</button>
        </div>
    </form>
</div>

<script src="../../public/js/script.js"></script>

<?php include '../layout/footer.php'; ?>
