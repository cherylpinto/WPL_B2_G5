<?php
session_start();
include_once __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name     = $_POST['name'];
    $phone    = $_POST['phone'];
    $email    = $_POST['email'];
    $date     = $_POST['date'];
    $time     = $_POST['time'];
    $people   = $_POST['people'];
    $table_id = $_POST['table_id'];
    $requests = $_POST['requests'];
    $status   = 'Pending';

    if (!isset($_SESSION['user_id'])) {
        echo "Error: User not logged in.";
        exit();
    }

    $user_id = $_SESSION['user_id'];

    if (empty($table_id)) {
        echo "Error: No table selected.";
        exit();
    }
    $stmt = $conn->prepare("INSERT INTO reservations (user_id, name, phone, email, date, time, people, table_id, requests, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("issssssiss", $user_id, $name, $phone, $email, $date, $time, $people, $table_id, $requests, $status);

    if ($stmt->execute()) {
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
