<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: app/views/admin_login.php");
    exit();
}

include_once __DIR__ . '/../app/config/database.php';
$db = new Database();
$conn = $db->connect();

$query = "SELECT id, name, email, date, time, people, table_id, status FROM reservations";
$result = $conn->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="../assets/admin.css">
</head>

<body>
    <div class="admin-header">
        <h1 class="dashboard-title">Admin Dashboard</h1>
        <a href="../app/views/admin_logout.php" class="logout-btn">Logout</a>
    </div>


    <table border="1" cellpadding="10" cellspacing="0">
        <tr>
            <th>Reservation ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Date</th>
            <th>Time</th>
            <th>People</th>
            <th>Table</th>
            <th>Status</th>
            <th>Action</th>
        </tr>

        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['id'] ?></td>
                <td><?= $row['name'] ?></td>
                <td><?= $row['email'] ?></td>
                <td><?= $row['date'] ?></td>
                <td><?= $row['time'] ?></td>
                <td><?= $row['people'] ?></td>
                <td><?= $row['table_id'] ?></td>
                <td><?= $row['status'] ?></td>
                <td>
                    <?php if (strtolower($row['status']) === 'pending'): ?>
                        <form method="POST" action="update_status.php" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="new_status" value="approved">
                            <button type="submit">Approve</button>
                        </form>
                        <form method="POST" action="update_status.php" style="display:inline-block;">
                            <input type="hidden" name="id" value="<?= $row['id'] ?>">
                            <input type="hidden" name="new_status" value="cancelled">
                            <button type="submit" style="background-color: #e74c3c; color: white;">Disapprove</button>
                        </form>
                    <?php else: ?>
                        <?= ucfirst($row['status']) ?>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>
</body>

</html>