<?php
$servername = "localhost";
$username = "root"; // Default MySQL user
$password = ""; // Default is empty in XAMPP
$dbname = "userdb";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
