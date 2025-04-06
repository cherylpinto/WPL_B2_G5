<?php
session_start();
include_once __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $phone    = $_POST['phone']; // this was missing!
    $email    = $_POST['email'];
    $date     = $_POST['date'];
    $time     = $_POST['time'];
    $people   = $_POST['people'];
    $table_id = $_POST['table_id'];
    $requests = $_POST['requests'];
    $status   = 'Pending';

    if (empty($table_id)) {
        echo "Error: No table selected.";
        exit();
    }

    //  Use the correct variable name here
    $stmt = $conn->prepare("INSERT INTO reservations (name, phone, email, date, time, people, table_id, requests, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssiss", $name, $phone, $email, $date, $time, $people, $table_id, $requests, $status);

    if ($stmt->execute()) {
        //  Update table status AFTER successful reservation
        $update_table_sql = "UPDATE tables SET status = 'reserved' WHERE table_id = ?";
        $stmt_update_table = $conn->prepare($update_table_sql);
        $stmt_update_table->bind_param("i", $table_id);
        $stmt_update_table->execute();
        $stmt_update_table->close();

        echo "<script>
            localStorage.removeItem('reservedTables');
            window.location.href = 'fetch_reservations.php';
        </script>";
        exit();
    } else {
        echo "Error saving reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
