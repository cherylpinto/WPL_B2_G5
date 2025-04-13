<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Signup</title>
    <style>
    body {
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        position: relative;
        overflow: hidden;
        background-color: #000; 
    }

    body::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url('../../images/admin.png') no-repeat center center/cover;
        filter: blur(10px);
        z-index: -1;
    }

    form {
        background-color: rgba(255, 255, 255, 0.85);
        padding: 35px 45px;
        border-radius: 12px;
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.25);
        width: 340px;
        text-align: center;
        z-index: 1;
        backdrop-filter: blur(5px);
    }

    h2 {
        margin-bottom: 25px;
        color: #b30000;
        font-size: 24px;
        font-weight: bold;
    }

    input[type="text"],
    input[type="password"] {
        width: 90%;
        padding: 12px 14px;
        margin-bottom: 18px;
        border: 1px solid #ccc;
        border-radius: 8px;
        font-size: 15px;
        transition: border-color 0.3s, box-shadow 0.3s;
    }

    input[type="text"]:focus,
    input[type="password"]:focus {
        border-color: #b30000;
        box-shadow: 0 0 0 2px rgba(179, 0, 0, 0.3);
        outline: none;
    }

    button[type="submit"] {
        background-color: #b30000;
        color: #fff;
        padding: 12px 18px;
        border: none;
        border-radius: 8px;
        font-size: 16px;
        cursor: pointer;
        width: 45%;
        transition: background-color 0.3s ease;
    }

    button[type="submit"]:hover {
        background-color: #990000;
    }
    a{
        text-decoration: none;
        color:#b30000;
        font-weight: 600;
    }
    a:hover{
        text-decoration: underline;
    }
</style>

</head>
<body>
<form method="POST" action="../controllers/adminController.php">
    <h2>Admin Login</h2>
    <input type="hidden" name="action" value="login">
    <input type="text" name="username" required placeholder="Username"><br>
    <input type="password" name="password" required placeholder="Password"><br>
    <button type="submit">Login</button>
    <p>Don't have an admin account? <a href="admin_signup.php">Create Admin</a></p>
</form>
</body>
</html>




