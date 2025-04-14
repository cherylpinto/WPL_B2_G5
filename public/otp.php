<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';  
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "", "restaurant_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');
$success = 0;
$error_message = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_booking'])) {
    $_SESSION['form_data'] = $_POST;
    $_SESSION['email'] = $_POST['email'];
    unset($_SESSION['otp_sent']); 
}

if (isset($_SESSION['email'])&& !isset($_SESSION['otp_sent'])) {
    $email = $_SESSION["email"];
    $otp = rand(100000, 999999);


    $stmt = $conn->prepare("INSERT INTO otp_expiry (email, otp, is_expired, create_at) VALUES (?, ?, 0, NOW())");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = 2; // Shows verbose debug info in browser
    //$mail->Debugoutput = 'html'; // Output format
    //$mail->Timeout = 10; // Prevent infinite wait

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'aurelias.management@gmail.com'; 
        $mail->Password = 'qsbb ewob tvgs vnhk'; 
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('aurelias.management@gmail.com', 'Aurelias');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "<p>Your OTP is <strong>$otp</strong>. It is valid for 24 hours.</p>";

        $mail->send();
        $_SESSION['otp_sent'] = true;
        $success = 1; 
    } catch (Exception $e) {
        $error_message = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}
else if (isset($_SESSION['otp_sent'])) {
    $success = 1; 
}

if (isset($_POST["submit_otp"])) {
    $otp = $_POST["otp"];

    $query = "SELECT * FROM otp_expiry WHERE otp = ? AND is_expired != 1 AND NOW() <= DATE_ADD(create_at, INTERVAL 24 HOUR)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['verified_email'] = $row['email'];

        $expireStmt = $conn->prepare("UPDATE otp_expiry SET is_expired = 1 WHERE otp = ?");
        $expireStmt->bind_param("s", $otp);
        $expireStmt->execute();

        header("Location: reservation/save_reservations.php");
        exit();
    } else {
        $success = 1;
        $error_message = "Invalid or expired OTP!";
    }
}
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <style>
        body, html {
            height: 100%;
            margin: 0;
            font-family: Arial, sans-serif;
        }

        .background-image {
            background-image: url('../images/display.png'); 
            background-size: cover;
            background-position: center;
            position: fixed;
            height: 100%;
            width: 100%;
            filter: blur(8px);
            z-index: -1;
        }
        .otp-container {
            background: rgba(255, 255, 255, 0.85);
            border-radius: 10px;
            padding: 2rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.2);

        }
    </style>
</head>
<body class="bg-light">
<div class="background-image"></div>
    <div class="container mt-5" style="align-items: center">
        <div class="col-md-6 offset-md-3 bg-white p-4 rounded shadow otp-container">
            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>

            <?php if ($success == 1) { ?>
                <h4 class="mb-3">Enter OTP</h4>
                <form method="post" action="">
                    <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>
                    <button type="submit" name="submit_otp" class="btn btn-success">Verify</button>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
