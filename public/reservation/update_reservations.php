<?php
include_once __DIR__ . '/connect.php';
date_default_timezone_set('Asia/Kolkata');

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();

    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
    } else {
        echo "Reservation not found.";
        exit();
    }
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['date'] ?? '';
    $input_time = $_POST['time'] ?? '00:00';
    $time_parts = explode(':', $input_time);
    $time = sprintf('%02d:%02d:00', (int)$time_parts[0], (int)$time_parts[1]);

    $people = $_POST['people'] ?? 1;
    $requests = $_POST['requests'] ?? '';
    $status = $_POST['status'] ?? 'Pending';

    if (!$id) {
        die("No reservation ID provided.");
    }

    // 🔒 Conflict Check Before Update
    $requestedDateTime = new DateTime("$date $time");
    $oneHourBefore = $requestedDateTime->modify('-1 hour')->format('H:i:s');
    $requestedDateTime->modify('+2 hour'); // move 2 hours forward from the -1 point
    $oneHourAfter = $requestedDateTime->format('H:i:s');

    $conflictSQL = "SELECT * FROM reservations 
                        WHERE date = ? 
                        AND time BETWEEN ? AND ? 
                        AND id != ?";

    $conflictStmt = $conn->prepare($conflictSQL);
    $conflictStmt->bind_param("sssi", $date, $oneHourBefore, $oneHourAfter, $id);
    $conflictStmt->execute();
    $conflictResult = $conflictStmt->get_result();

    if ($conflictResult->num_rows > 0) {
        echo "<script>alert('⚠️ A reservation already exists within 1 hour of this time. Please choose a different time.'); window.history.back();</script>";
        exit();
    }

    // ✅ Now proceed to update
    $sql = "UPDATE reservations SET 
                name=?, phone=?, email=?, date=?, time=?, people=?, requests=?, status=? 
                WHERE id=?";

    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("sssssissi", $name, $phone, $email, $date, $time, $people, $requests, $status, $id);


    if ($stmt->execute()) {
        //echo "<p>DEBUG: Time being saved → <strong>$time</strong></p>";
        //echo "Reservation updated successfully!";
        header("Location: fetch_reservations.php");
        exit();
    } else {
        echo "Error updating reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Reservation</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
</head>

<body>

    <div class="container">
        <h2>Update Reservation</h2>
        <form method="POST" action="update_reservations.php">
            <input type="hidden" name="id" value="<?php echo $reservation['id']; ?>">

            <div class="form-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($reservation['name']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="phone">Phone Number:</label>
                <input type="text" id="phone" name="phone" value="<?php echo htmlspecialchars($reservation['phone']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($reservation['email']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="date">Date:</label>
                <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($reservation['date']); ?>" min="<?php echo date('Y-m-d'); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="time">Time:</label>
                <input type="time" id="time" name="time" value="<?php echo htmlspecialchars(substr($reservation['time'], 0, 5)); ?>" class="form-control" required>

            </div>

            <div class="form-group">
                <label for="people">People:</label>
                <input type="number" id="people" name="people" value="<?php echo htmlspecialchars($reservation['people']); ?>" class="form-control" required>
            </div>

            <div class="form-group">
                <label for="requests">Special Requests:</label>
                <textarea id="requests" name="requests" class="form-control"><?php echo htmlspecialchars($reservation['requests']); ?></textarea>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Update Reservation</button>
            </div>
        </form>

    </div>

</body>

</html>