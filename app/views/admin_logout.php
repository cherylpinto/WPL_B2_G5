<?php
session_start();
session_unset();
session_destroy();

// Redirect to homepage after logout
header("Location: ../../public/index.php"); // Adjust path as per your file location
exit();
