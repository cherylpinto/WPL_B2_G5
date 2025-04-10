<?php
include_once __DIR__ . '/connect.php';

// Delete 'approved' reservations older than 1 hour
$sql_approved = "
    DELETE FROM reservations
    WHERE status = 'approved'
    AND TIMESTAMPDIFF(MINUTE, STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s'), NOW()) > 60
";
$stmt_approved = $conn->prepare($sql_approved);
$stmt_approved->execute();
$stmt_approved->close();

// Delete 'cancelled' reservations older than 1 hour
$sql_cancelled = "
    DELETE FROM reservations
    WHERE status = 'cancelled'
    AND TIMESTAMPDIFF(MINUTE, STR_TO_DATE(CONCAT(date, ' ', time), '%Y-%m-%d %H:%i:%s'), NOW()) > 60
";
$stmt_cancelled = $conn->prepare($sql_cancelled);
$stmt_cancelled->execute();
$stmt_cancelled->close();

$conn->close();

echo "Old approved and cancelled reservations deleted.";
?>
