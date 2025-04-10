<?php
include_once __DIR__ . '/connect.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    
    $get_table_sql = "SELECT table_id FROM reservations WHERE id=?";
    $stmt_get = $conn->prepare($get_table_sql);
    $stmt_get->bind_param("i", $id);
    $stmt_get->execute();
    $stmt_get->bind_result($table_id);
    $stmt_get->fetch();
    $stmt_get->close();

    if (!$table_id) {
        header("Location: fetch_reservations.php?error=not_found");
        exit();
    }

    $sql = "DELETE FROM reservations WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);


    if ($stmt->execute()) {
       
        $update_table_sql = "UPDATE tables SET status='available' WHERE table_id=?";
        $stmt_update = $conn->prepare($update_table_sql);
        $stmt_update->bind_param("i", $table_id);
        $stmt_update->execute();
        $stmt_update->close();

        
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
