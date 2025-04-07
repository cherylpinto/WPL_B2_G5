<?php
include_once __DIR__ . '/../config/database.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $_POST['action'] === 'approve') {
    $reservationId = $_POST['id'];

    $db = new Database();
    $conn = $db->connect();

    $stmt = $conn->prepare("UPDATE reservations SET status = 'Approved' WHERE id = ?");
    $stmt->bind_param("i", $reservationId);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Reservation approved.";
    } else {
        $_SESSION['error'] = "Failed to approve reservation.";
    }

    $stmt->close();
    $conn->close();

    header("Location: ../../admin_dashboard.php");
    exit();
}
?>
<?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
<?php endif; ?>
<?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
<?php endif; ?>
