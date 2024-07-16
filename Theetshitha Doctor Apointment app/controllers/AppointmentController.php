<?php
include '../config/config.php';
include '../models/Appointment.php';

$appointmentModel = new Appointment($pdo);

$page = isset($_GET['page']) ? (int) $_GET['page'] : 1;
$limit = 4;
$start = ($page - 1) * $limit;

$appointments = $appointmentModel->getAllAppointments($start, $limit);
$totalAppointments = $appointmentModel->getTotalAppointments();
$totalPages = ceil($totalAppointments / $limit);
?>