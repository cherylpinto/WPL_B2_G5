<?php


include_once __DIR__ . '/connect.php';


if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
} else {
    echo "Connected successfully!";
}


session_start();
include_once __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = $_SESSION["user_id"] ?? null;  
   $name = $_POST["name"] ?? "";
    $phone = $_POST["phone"] ?? "";
    $email = $_POST["email"] ?? "";
    $date = $_POST["date"] ?? "";
    $time = $_POST["time"] ?? "";
    $people = (int)($_POST["people"] ?? 1);
    $requests = $_POST["requests"] ?? "";
    $table_id = (int)($_POST["table_id"] ?? 0);


    if (!$user_id) {
        die("Error: You must be logged in to make a reservation.");
    }
    $sql = "INSERT INTO reservations (user_id, table_id, name, phone, email, date, time, people, requests, status) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')";

$stmt = $conn->prepare($sql);
if ($stmt === false) {
die("Error preparing statement: " . $conn->error);
}

$stmt->bind_param("iisssssis", $user_id, $table_id, $name, $phone, $email, $date, $time, $people, $requests);

if ($stmt->execute()) {

echo "<script>
    let reservedTables = JSON.parse(localStorage.getItem('reservedTables')) || [];
    reservedTables.push(" . $table_id . ");
    localStorage.setItem('reservedTables', JSON.stringify(reservedTables));
   window.location.href = '/WPL_B2_G5/public/reservation/fetch_reservations.php';

</script>";
exit();
} else {
die("Error executing statement: " . $stmt->error);
}

$stmt->close();
$conn->close();
}
?>