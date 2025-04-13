<?php
header('Content-Type: application/json');
include_once __DIR__ . '/reservation/connect.php';
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $table_id = $_POST['table_id'] ?? null;

    if (!$table_id) {
        echo "error: Missing table_id";
        exit;
    }

    $stmt = $conn->prepare("UPDATE tables SET status = 'reserved' WHERE table_id = ?");
    $stmt->bind_param("i", $table_id);

    if ($stmt->execute()) {
        echo "success";
    } else {
        echo "error: " . $stmt->error;
    }
    $stmt->close();
    $conn->close();
    exit;
}

$result = $conn->query("SELECT table_id AS id, capacity AS size, status FROM tables");
$tables = [];

while ($row = $result->fetch_assoc()) {
    $tables[] = $row;
}
echo json_encode($tables);      
?>
