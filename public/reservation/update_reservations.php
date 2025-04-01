<?php
include 'connect.php'; 
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id']; 
    $name = $_POST['name'];
    $phone = $_POST['phone'];
    $email = $_POST['email'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $people = $_POST['people'];
    $requests = $_POST['requests'];
    $status = $_POST['status']; 
    $sql = "UPDATE reservations SET 
            name=?, phone=?, email=?, date=?, time=?, people=?, requests=?, status=? 
            WHERE id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssisssi", $name, $phone, $email, $date, $time, $people, $requests, $status, $id);

    if ($stmt->execute()) {
        echo "Reservation updated successfully!";
    } else {
        echo "Error updating reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
