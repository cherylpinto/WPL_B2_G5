<?php
session_start();
include_once __DIR__ . '/connect.php';

if (!isset($_SESSION['verified_email']) || !isset($_SESSION['form_data'])) {
    echo "Error: Session expired or invalid access.";
    exit();
}

$form_data = $_SESSION['form_data'];

$name     = $form_data['name'];
$phone    = $form_data['phone'];
$email    = $_SESSION['verified_email']; 
$date     = $form_data['date'];
$time     = $form_data['time'];
$people   = $form_data['people'];
$table_id = $form_data['table_id'];
$requests = $form_data['requests'];
$status   = 'Pending';


$user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : null;

if (empty($table_id)) {
    echo "Error: No table selected.";
    exit();
}

$stmt = $conn->prepare("INSERT INTO reservations (user_id, name, phone, email, date, time, people, table_id, requests, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("issssssiss", $user_id, $name, $phone, $email, $date, $time, $people, $table_id, $requests, $status);

if ($stmt->execute()) {
    $update_table_sql = "UPDATE tables SET status = 'reserved' WHERE table_id = ?";
    $stmt_update = $conn->prepare($update_table_sql);
    $stmt_update->bind_param("i", $table_id);
    $stmt_update->execute();
    $stmt_update->close();

  

    unset($_SESSION['verified_email']);
    unset($_SESSION['form_data']);

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

?>