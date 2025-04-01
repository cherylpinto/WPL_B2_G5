<?php
include 'connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; 

    $sql = "DELETE FROM reservations WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Reservation deleted successfully!";
    } else {
        echo "Error deleting reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
