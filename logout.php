<?php
session_start();
session_destroy(); // Destroy the session

// Redirect to the login page
header("Location: login.php");
exit();
?>
