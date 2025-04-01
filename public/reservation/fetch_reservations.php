<?php
include 'connect.php';

$sql = "SELECT table_id FROM reservations";
$result = $conn->query($sql);

$reservedTables = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $reservedTables[] = $row['table_id'];
    }
}

echo json_encode($reservedTables);
$conn->close();
?>
