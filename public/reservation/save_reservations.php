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

        // Show confirmation screen
?>
        <!DOCTYPE html>
        <html lang="en">

        <head>
            <meta charset="UTF-8">
            <title>Reservation Confirmed</title>
            <meta name="viewport" content="width=device-width, initial-scale=1.0" />
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
            <style>
                body {
                    background-color: #f8f9fa;
                    display: flex;
                    justify-content: center;
                    align-items: center;
                    height: 100vh;
                    margin: 0;
                    position: relative;
                    overflow: hidden;
                }

                body::before {
                    content: "";
                    position: absolute;
                    top: 0;
                    left: 0;
                    width: 100%;
                    height: 100%;
                    background: url('../../images/display.png') no-repeat center center/cover;
                    filter: blur(8px);
                    z-index: -1;
                }

                .confirmation-box {
                    background: white;
                    padding: 30px;
                    border-radius: 12px;
                    box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
                    text-align: center;
                    z-index: 1;
                }

                .confirmation-box h2 {
                    margin-bottom: 20px;
                    color: green;
                }

                .confirmation-box .btn {
                    margin: 10px;
                }
            </style>
        </head>

        <body>

            <div class="confirmation-box">
                <h2>🎉 Table Reserved Successfully!</h2>
                <p>Your reservation has been recorded.</p>
                <div>
                    <a href="../index.php" class="btn btn-danger">Go to Home</a>
                    <a href="fetch_reservations.php" class="btn btn-secondary">View My Reservations</a>
                </div>
            </div>

        </body>

        </html>
<?php
        exit();
    } else {
        echo "Error saving reservation: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>