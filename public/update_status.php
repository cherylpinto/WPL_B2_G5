<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require __DIR__ . '/../vendor/autoload.php'; 

include_once __DIR__ . '/../app/config/database.php';
$db = new Database();
$conn = $db->connect();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $id = $_POST['id'] ?? null;
    $new_status = $_POST['new_status'] ?? null;

    if ($id && $new_status) {
        $stmt = $conn->prepare("UPDATE reservations SET status = ? WHERE id = ?");
        $stmt->bind_param("si", $new_status, $id);

        if ($stmt->execute()) {

            $fetchStmt = $conn->prepare("SELECT name, email, date, time, people, table_id FROM reservations WHERE id = ?");
            $fetchStmt->bind_param("i", $id);
            $fetchStmt->execute();
            $result = $fetchStmt->get_result();

            if ($result->num_rows === 1 && strtolower($new_status) === 'approved') {
                $reservation = $result->fetch_assoc();

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'aurelias.management@gmail.com';        
                    $mail->Password = '';            
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;

                    $mail->setFrom('aurelias.management@gmail.com', 'Aurelias Restaurant Team');
                    $mail->addAddress($reservation['email'], $reservation['name']);
                    $mail->isHTML(true);
                    $mail->Subject = 'Your Table Reservation is Approved';
                    $mail->Body = "
                        <h3>Hello {$reservation['name']},</h3>
                        <p>Your table reservation has been <strong>approved ✅</strong>.</p>
                        <p><strong>Date:</strong> {$reservation['date']}</p>
                        <p><strong>Time:</strong> {$reservation['time']}</p>
                        <p><strong>People:</strong> {$reservation['people']}</p>
                        <p><strong>Table:</strong> {$reservation['table_id']}</p>
                        <p>We look forward to serving you!</p>
                        <p><strong>- The Restaurant Team</strong></p>
                    ";

                    $mail->send();
                } catch (Exception $e) {
                    error_log("Mail Error: " . $mail->ErrorInfo);
                }
            }

            $fetchStmt->close();
            header("Location: admin_dashboard.php");
            exit();
        } else {
            echo "Error updating status: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "Missing data.";
    }

    $conn->close();
}
