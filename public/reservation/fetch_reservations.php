<?php
session_start();
include_once __DIR__ . '/connect.php';

if (!isset($_SESSION['user_id'])) {
    echo "<p>You must be logged in to view your reservations.</p>";
    exit;
}

$userId = $_SESSION['user_id'];

$sql = "SELECT * FROM reservations WHERE user_id = ? ORDER BY date, time";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservation Database</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.0/css/bootstrap.min.css">
    <link rel='stylesheet' href="../../assets/display.css">
    <style>
        .confirmation{
            margin-bottom:10px ;
        }
    </style>
</head>
<body>

<div class="container">
    <h2>Reservation Details</h2>
    <div class="text-left confirmation">
        <a href="../index.php" class="btn btn-success">🏠 Go to Home</a>
    </div>
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Phone Number</th>
                <th>Email</th>
                <th>Date</th>
                <th>Time</th>
                <th>People</th>
                <th>Table No.</th>
                <th>Requests</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
            ?>
            <tr>
                <td><?php echo htmlspecialchars($row['name']); ?></td>
                <td><?php echo htmlspecialchars($row['phone']); ?></td>
                <td><?php echo htmlspecialchars($row['email']); ?></td>
                <td><?php echo htmlspecialchars($row['date']); ?></td>
                <td><?php echo htmlspecialchars($row['time']); ?></td>
                <td><?php echo htmlspecialchars($row['people']); ?></td>
                <td><?php echo htmlspecialchars($row['table_id']); ?></td>
                <td><?php echo htmlspecialchars($row['requests']); ?></td>
                <td><?php echo htmlspecialchars($row['status']); ?></td>
                <td>
                    <a class="btn btn-danger btn-sm" href="delete_reservation.php?id=<?php echo $row['id']; ?>">Delete</a>
                    <a class="btn btn-primary btn-sm" href="update_reservations.php?id=<?php echo $row['id']; ?>">Edit</a>
                </td>
            </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='11' class='text-center'>No reservations found</td></tr>";
            }
            $stmt->close();
            $conn->close();
            ?>
        </tbody>
    </table>
</div>

</body>
</html>
