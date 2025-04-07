<?php
include_once __DIR__ . '/../models/adminModel.php';
include_once __DIR__ . '/../config/database.php';

session_start();
$db = new Database();
$conn = $db->connect();
$adminModel = new AdminModel($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    if ($action === 'signup') {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        if ($adminModel->create($username, $hashed)) {
            $_SESSION['success'] = "Admin account created successfully!";
            header("Location: ../../app/views/admin_login.php");
            exit();
        } else {
            $_SESSION['error'] = "Signup failed. Username may already exist.";
            header("Location: ../../app/views/admin_signup.php");
            exit();
        }

    } elseif ($action === 'login') {
        $admin = $adminModel->findByUsername($username);
        if ($admin && password_verify($password, $admin['password'])) {
            $_SESSION['admin_logged_in'] = true;
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header("Location: ../../public/admin_dashboard.php");
            exit();
        } else {
            $_SESSION['error'] = "Invalid username or password.";
            header("Location: ../../app/views/admin_login.php");
            exit();
        }
    }
}
