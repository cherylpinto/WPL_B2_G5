<?php
include_once __DIR__ . '/connect.php';


$cancel_sql = "UPDATE reservations 
               SET status = 'cancelled' 
               WHERE status = 'pending' 
                AND TIMESTAMP(date, time) < NOW() - INTERVAL 1 HOUR";
$conn->query($cancel_sql);


$free_table_sql = "UPDATE tables t
                   JOIN reservations r on t.table_id = r.table_id
                   SET t.status = 'available' 
                   WHERE r.status = 'cancelled'";
$conn->query($free_table_sql);


header('Content-Type: application/json');

$date = $_GET["date"] ?? NULL;
$time = $_GET["time"] ?? NULL;

if (!$date || !$time) {
    echo json_encode(["error" => "Missing date or time"]);
    exit;
}

$reservationDateTime = new DateTime("$date $time");
$selectedStart = clone $reservationDateTime;
$selectedEnd = clone $reservationDateTime;
$selectedEnd->modify('+1 hour');

$sql = $sql = "SELECT table_id, date, time FROM reservations 
WHERE status IN ('pending', 'approved') AND date = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

$reservedTableIds = [];

while ($row = $result->fetch_assoc()) {
    $resTime = new DateTime($row['date'] . ' ' . $row['time']);
    $resEnd = clone $resTime;
    $resEnd->modify('+1 hour');

    if ($selectedStart < $resEnd && $selectedEnd > $resTime) {
        if (!in_array($row['table_id'], $reservedTableIds)) {
            $reservedTableIds[] = $row['table_id'];
        }
    }
}

$tablesResult = $conn->query("SELECT table_id, capacity FROM tables");

$tables = [];
while ($row = $tablesResult->fetch_assoc()) {
    $row['status'] = in_array($row['table_id'], $reservedTableIds) ? 'reserved' : 'available';
    $tables[] = $row;
}

echo json_encode($tables);
?>
