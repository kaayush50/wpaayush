<?php
session_start();
session_destroy(); // Destroy session
session_unset();  // Unset all session variables

// Redirect to login page
header("Location: login.html");
exit();
?>
