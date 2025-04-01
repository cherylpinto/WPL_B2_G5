<?php
session_start();
include_once '../app/controllers/AuthController.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController = new AuthController();
    $message = $authController->signUp($_POST['first_name'], $_POST['last_name'], $_POST['email'], $_POST['password']);

    if ($message === "User registered successfully!") {
        $_SESSION['success'] = $message;
        header("Location: login.php"); // Redirect to login page
        exit();
    } else {
        $_SESSION['error'] = $message;
        header("Location: signup.php"); // Stay on signup page
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <link rel="stylesheet" href="/assets/styles.css">
</head>
<body>
    <?php if (isset($_SESSION['error'])): ?>
        <p style="color: red;"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
    <?php endif; ?>
    
    <form action="signup.php" method="POST">
        <h2>Signup</h2>
        <label>First Name:</label>
        <input type="text" name="first_name" required>
        
        <label>Last Name:</label>
        <input type="text" name="last_name" required>

        <label>Email:</label>
        <input type="email" name="email" required>

        <label>Password:</label>
        <input type="password" name="password" required>

        <button type="submit">Sign Up</button>
    </form>
</body>
</html>
