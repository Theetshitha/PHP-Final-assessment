<?php
include '../../config/config.php';
include '../../models/Appointment.php';

$appointmentModel = new Appointment($pdo);

$query = isset($_GET['query']) ? $_GET['query'] : '';
$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 4;
$start = ($page - 1) * $limit;

$appointments = $appointmentModel->searchAppointments($query, $start, $limit);
$totalSearchResults = $appointmentModel->getTotalSearchResults($query);
$totalPages = ceil($totalSearchResults / $limit);
?>
