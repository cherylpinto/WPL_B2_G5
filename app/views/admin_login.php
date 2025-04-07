<form method="POST" action="../controllers/adminController.php">
    <h2>Admin Login</h2>
    <input type="hidden" name="action" value="login">
    <input type="text" name="username" required placeholder="Username"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <button type="submit">Login</button>
    <p>Don't have an admin account? <a href="admin_signup.php">Create Admin</a></p>
</form>
