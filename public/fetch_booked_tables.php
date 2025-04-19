<?php
require '../app/config/database.php'; 

header('Content-Type: application/json');

$date = $_GET['date'] ?? '';
$time = $_GET['time'] ?? '';

$response = ['tables' => [], 'reservations' => []];

try {
    $db = new Database();
    $conn = $db->connect();

    $tablesQuery = "SELECT * FROM tables";
    $tablesResult = $conn->query($tablesQuery);

    if ($tablesResult) {
        while ($row = $tablesResult->fetch_assoc()) {
            $response['tables'][] = $row;
        }
    }

    $inputDateTime = new DateTime("$date $time");
    $startTime = $inputDateTime->modify('-1 hour')->format('H:i:s');
    $endTime = (new DateTime("$date $time"))->modify('+1 hour')->format('H:i:s');

    $stmt = $conn->prepare("SELECT r.table_id, r.name, r.email, r.phone 
                            FROM reservations r
                            WHERE r.date = ? AND r.time BETWEEN ? AND ?");
    $stmt->bind_param("sss", $date, $startTime, $endTime);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($res = $result->fetch_assoc()) {
        $response['reservations'][$res['table_id']] = [
            'name' => $res['name'],
            'email' => $res['email'],
            'phone' => $res['phone']
        ];
    }

    echo json_encode($response);

} catch (Exception $e) {
    echo json_encode(['error' => $e->getMessage()]);
}
