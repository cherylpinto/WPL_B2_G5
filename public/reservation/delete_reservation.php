<?php
include_once __DIR__ . '/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $sql = "DELETE FROM reservations WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Reservation deleted successfully!";
   
        header("Location: fetch_reservations.php?deleted=true&id=$id");
        exit();
    } else {
        
        header("Location: fetch_reservations.php?error=true");
        exit();
    }

    $stmt->close();
    $conn->close();
} else {
    echo "Reservation ID is required.";
}
?>
