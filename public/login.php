<?php
session_start();
include_once '../app/controllers/AuthController.php';
include_once '../app/controllers/GoogleAuthController.php';
if (isset($_GET['code'])) {
    $googleAuth = new GoogleAuthController();
    $googleAuth->handleCallback();
    exit();
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    $user = $authController->getUserDetails($_POST['email'], $_POST['password']);

    if ($user) {
        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['email'] = $user['email'];
        header("Location: index.php");
        exit();
    } else {
        $_SESSION['error'] = "Invalid email or password!";
        header("Location: login.php");
        exit();
    }
}
$googleAuth = new GoogleAuthController();
$google_login_url = $googleAuth->getAuthUrl();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="../assets/login.css">
</head>

<body>

    <form action="login.php" method="POST">
        <div class="login-container">
            <img src="../images/logo.png">
            <h2>Login</h2>
            <label>Email:</label>
            <input type="email" name="email" required>
            <label>Password:</label>
            <input type="password" name="password" required>
            <?php if (isset($_SESSION['error'])): ?>
                <div class="error-message">
                    <?php echo $_SESSION['error'];
                    unset($_SESSION['error']); ?>
                </div>
            <?php endif; ?>
            <button type="submit">Login</button>
            <div style="text-align:center; margin-top: 10px;">
                <a href="<?php echo $google_login_url; ?>">
                    <img src="https://developers.google.com/identity/images/btn_google_signin_dark_normal_web.png"
                        alt="Google Login" style="height: 50px;width:200px;margin-top: 10px"; />
                </a>
            </div>
            <p>Don't have an account?<a href="signup.php"> Signup</a></p>
            <p><a href="../app/views/admin_login.php">Admin Login</a></p>
        </div>
        </div>
    </form>
</body>

</html>