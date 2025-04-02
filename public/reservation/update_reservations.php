<?php
include_once __DIR__ . '/connect.php';

if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET['id'])) {
    // Fetch reservation details based on the passed reservation ID
    $id = $_GET['id'];
    $sql = "SELECT * FROM reservations WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    // Check if a reservation is found
    if ($result->num_rows > 0) {
        $reservation = $result->fetch_assoc();
    } else {
        echo "Reservation not found.";
        exit();
    }
    $stmt->close();
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Update reservation details when the form is submitted

    // Get the form values
    $id = $_POST['id'] ?? null;
    $name = $_POST['name'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $email = $_POST['email'] ?? '';
    $date = $_POST['date'] ?? '';
    $time = $_POST['time'] ?? '';
    $people = $_POST['people'] ?? 1;
    $requests = $_POST['requests'] ?? '';
    $status = $_POST['status'] ?? 'pending';

    // Check if the ID is provided
    if (!$id) {
        die("No reservation ID provided.");
    }

    // Prepare SQL query to update the reservation
    $sql = "UPDATE reservations SET 
            name=?, phone=?, email=?, date=?, time=?, people=?, requests=?, status=? 
            WHERE id=?";

    // Prepare and bind the parameters
    $stmt = $conn->prepare($sql);
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }

    $stmt->bind_param("ssssisssi", $name, $phone, $email, $date, $time, $people, $requests, $status, $id);

    // Execute the query
    if ($stmt->execute()) {
        echo "Reservation updated successfully!";
        header("Location: fetch_reservations.php"); // Redirect to the reservations page after updating
        exit();
    } else {
        echo "Error updating reservation: " . $stmt->error;
    }

    // Close statement and connection
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

    <!-- Form to update reservation -->
    <form method="POST" action="update_reservations.php">
        <!-- Hidden input for ID -->
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
            <input type="date" id="date" name="date" value="<?php echo htmlspecialchars($reservation['date']); ?>" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="time">Time:</label>
            <input type="time" id="time" name="time" value="<?php echo htmlspecialchars($reservation['time']); ?>" class="form-control" required>
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
            <label for="status">Status:</label>
            <select id="status" name="status" class="form-control">
                <option value="pending" <?php echo ($reservation['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
                <option value="confirmed" <?php echo ($reservation['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="cancelled" <?php echo ($reservation['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>
        </div>

        <div class="form-group">
            <button type="submit" class="btn btn-primary">Update Reservation</button>
        </div>
    </form>

</div>

</body>
</html>
