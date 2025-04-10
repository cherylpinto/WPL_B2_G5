<?php
session_start();
require __DIR__ . '/../vendor/autoload.php';   // PHPMailer autoloader
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$conn = new mysqli("localhost", "root", "cherylpinto", "restaurant_db");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

date_default_timezone_set('Asia/Kolkata');
$success = 0;
$error_message = "";

// Handle form submission and save reservation details in session
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit_booking'])) {
    $_SESSION['form_data'] = $_POST;
}

// Send OTP
if (isset($_POST["submit_email"])) {
    $email = $_POST["email"];
    $otp = rand(100000, 999999);

    // Store OTP in database
    $stmt = $conn->prepare("INSERT INTO otp_expiry (email, otp, is_expired, create_at) VALUES (?, ?, 0, NOW())");
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();

    // Send OTP via PHPMailer
    $mail = new PHPMailer(true);
    //$mail->SMTPDebug = 2; // Shows verbose debug info in browser
    //$mail->Debugoutput = 'html'; // Output format
    //$mail->Timeout = 10; // Prevent infinite wait

    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; // or your SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = 'aurelias.management@gmail.com'; // your email
        $mail->Password = 'qsbb ewob tvgs vnhk'; // app password
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        // Recipients
        $mail->setFrom('aurelias.management@gmail.com', 'Aurelias');
        $mail->addAddress($email);

        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Your OTP Code';
        $mail->Body    = "<p>Your OTP is <strong>$otp</strong>. It is valid for 24 hours.</p>";

        $mail->send();
        $success = 1; // show OTP input
    } catch (Exception $e) {
        $error_message = "OTP could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
}

// Verify OTP
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

        // Expire OTP
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

<!-- HTML -->
<!DOCTYPE html>
<html>
<head>
    <title>OTP Verification</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="col-md-6 offset-md-3 bg-white p-4 rounded shadow">
            <?php if (!empty($error_message)) { ?>
                <div class="alert alert-danger"><?php echo $error_message; ?></div>
            <?php } ?>

            <?php if ($success == 1) { ?>
                <h4 class="mb-3">Enter OTP</h4>
                <form method="post" action="">
                    <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP" required>
                    <button type="submit" name="submit_otp" class="btn btn-success">Verify</button>
                </form>
            <?php } else { ?>
                <h4 class="mb-3">Verify Your Email</h4>
                <form method="post" action="">
                    <input type="email" name="email" class="form-control mb-3" placeholder="Enter Email" required>
                    <button type="submit" name="submit_email" class="btn btn-primary">Send OTP</button>
                </form>
            <?php } ?>
        </div>
    </div>
</body>
</html>
