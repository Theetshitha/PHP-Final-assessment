<?php
include '../../config/config.php';
include '../../models/Appointment.php';

$appointmentModel = new Appointment($pdo);

// Initialize variables
$query = isset($_GET['search']) ? $_GET['search'] : ''; // Changed 'query' to 'search'
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 6;
$start = ($page - 1) * $limit;

// Search appointments based on query
$appointments = $appointmentModel->searchAppointments($query, $start, $limit);
$totalSearchResults = $appointmentModel->getTotalSearchResults($query);
$totalPages = ceil($totalSearchResults / $limit);
?>

<?php include '../layout/header.php'; ?>



<!-- Search and Sort Bar -->
<div class="flex mb-4 mt-1 justify-around items-center bg-blue-500 h-17 p-2 ">
    <!-- Search Bar -->
    <form action="" method="GET" class="flex items-center mr-4">
        <input type="text" name="search" value="<?= htmlspecialchars($query) ?>"  placeholder="Search by Patient Name or Reason" class="border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm block w-48 p-2">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-blue-600">Search</button>
    </form>

    <!-- Sorting Dropdown -->
    <form action="" method="GET" class="flex items-center">
        <label for="sort" class="block text-sm font-medium text-gray-700 mr-2">Sort by Date & Time:</label>
        <select name="sort" id="sort" class="border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm block w-52">
            <option value="DESC" <?= isset($_GET['sort']) && $_GET['sort'] === 'DESC' ? 'selected' : '' ?>>Newest First</option>
            <option value="ASC" <?= isset($_GET['sort']) && $_GET['sort'] === 'ASC' ? 'selected' : '' ?>>Oldest First</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-blue-600">Sort</button>
    </form>
</div>

<div class="container mx-auto mt-8 " style="text-align: center;">
   
<h2 class="text-2xl font-bold mb-4" >Patient Appointment Slots</h2>
    <!-- Grid View for Appointment List -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 justify-center">
        <?php foreach ($appointments as $appointment): ?>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold"><?= htmlspecialchars($appointment['patientName']) ?></h3>
                <p><strong>Age:</strong> <?= $appointment['patientAge'] ?></p>
                <p><strong>Reason:</strong> <?= htmlspecialchars($appointment['reason']) ?></p>
                <p><strong>Contact No:</strong> <?= htmlspecialchars($appointment['contactNo']) ?></p>
                <p><strong>Date & Time:</strong> <?= date('Y-m-d H:i', strtotime($appointment['appointment_date'])) ?></p>
                <div class="mt-4">
                    <a href="edit.php?id=<?= $appointment['id'] ?>" class="bg-blue-500 text-white py-2 px-4 rounded-md inline-block hover:bg-blue-600">Edit</a>
                    <button onclick="deleteAppointment(<?= $appointment['id'] ?>)" class="bg-red-500 text-white py-2 px-4 rounded-md inline-block hover:bg-red-600">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination Links -->
    <div class="flex justify-center items-center mt-4">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($query) ?>&sort=<?= isset($_GET['sort']) ? urlencode($_GET['sort']) : '' ?>" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-full hover:bg-gray-400 <?= $page === $i ? 'font-bold' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<?php include '../layout/footer.php'; ?>


<?php
include '../../config/config.php';

// Pagination
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$limit = 4;
$offset = ($page - 1) * $limit;

// Search
$search = isset($_GET['search']) ? $_GET['search'] : '';

// Sorting
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'dateTime DESC';
$allowedSorts = ['dateTime ASC', 'dateTime DESC'];

if (!in_array($sort, $allowedSorts)) {
    $sort = 'dateTime DESC';
}

// Fetch appointments with search, sort, and pagination
$sqlCount = "SELECT COUNT(*) AS count FROM appointments WHERE patientName LIKE ? OR reason LIKE ?";
$sqlAppointments = "SELECT * FROM appointments WHERE patientName LIKE ? OR reason LIKE ? ORDER BY $sort LIMIT $limit OFFSET $offset";

$stmtCount = $pdo->prepare($sqlCount);
$stmtAppointments = $pdo->prepare($sqlAppointments);

$searchTerm = "%$search%";
$stmtCount->execute([$searchTerm, $searchTerm]);
$totalResults = $stmtCount->fetchColumn();

$stmtAppointments->execute([$searchTerm, $searchTerm]);
$appointments = $stmtAppointments->fetchAll(PDO::FETCH_ASSOC);

// Pagination links
$totalPages = ceil($totalResults / $limit);
?>

<?php include '../layout/header.php'; ?>


<!-- Search and Sort Bar -->
<div class="flex mb-4 mt-1 justify-around items-center bg-blue-500 h-17 p-2 ">
    <!-- Search Bar -->
    <form action="" method="GET" class="flex items-center mr-4">
        <input type="text" name="search" value="<?= htmlspecialchars($query) ?>"  placeholder="Search by Patient Name or Reason" class="border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm block w-48 p-2">
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-blue-600">Search</button>
    </form>

    <!-- Sorting Dropdown -->
    <form action="" method="GET" class="flex items-center">
        <label for="sort" class="block text-sm font-medium text-gray-700 mr-2">Sort by Date & Time:</label>
        <select name="sort" id="sort" class="border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-500 focus:ring-opacity-50 rounded-md shadow-sm block w-52">
            <option value="DESC" <?= isset($_GET['sort']) && $_GET['sort'] === 'DESC' ? 'selected' : '' ?>>Newest First</option>
            <option value="ASC" <?= isset($_GET['sort']) && $_GET['sort'] === 'ASC' ? 'selected' : '' ?>>Oldest First</option>
        </select>
        <button type="submit" class="bg-blue-500 text-white py-2 px-4 rounded-md ml-2 hover:bg-blue-600">Sort</button>
    </form>
</div>

<div class="container mx-auto mt-8 " style="text-align: center;">
   
<h2 class="text-2xl font-bold mb-4" >Patient Appointment Slots</h2>
    <!-- Appointment List -->
    <div class="space-y-4">
        <?php foreach ($appointments as $appointment): ?>
            <div class="bg-white p-4 rounded-lg shadow-md">
                <h3 class="text-lg font-bold"><?= htmlspecialchars($appointment['patientName']) ?></h3>
                <p><strong>Age:</strong> <?= $appointment['patientAge'] ?></p>
                <p><strong>Reason:</strong> <?= htmlspecialchars($appointment['reason']) ?></p>
                <p><strong>Contact No:</strong> <?= htmlspecialchars($appointment['contactNo']) ?></p>
                <p><strong>Date & Time:</strong> <?= date('Y-m-d H:i', strtotime($appointment['dateTime'])) ?></p>
                <div class="mt-4">
                    <a href="edit.php?id=<?= $appointment['id'] ?>" class="bg-blue-500 text-white py-2 px-4 rounded-md inline-block hover:bg-blue-600">Edit</a>
                    <button onclick="deleteAppointment(<?= $appointment['id'] ?>)" class="bg-red-500 text-white py-2 px-4 rounded-md inline-block hover:bg-red-600">Delete</button>
                </div>
            </div>
        <?php endforeach; ?>
    </div>

    <!-- Pagination Links -->
    <div class="flex justify-center items-center mt-4">
        <?php for ($i = 1; $i <= $totalPages; $i++): ?>
            <a href="?page=<?= $i ?>&search=<?= urlencode($search) ?>&sort=<?= urlencode($sort) ?>" class="bg-gray-300 text-gray-800 py-2 px-4 rounded-full hover:bg-gray-400 <?= $page === $i ? 'font-bold' : '' ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</div>

<script src="../../public/js/script.js"></script>

<?php include '../layout/footer.php'; ?>