<?php
session_start();
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Retrieve user from the database
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($user_id, $hashed_password);
    $stmt->fetch();

    if ($stmt->num_rows > 0 && password_verify($password, $hashed_password)) {
        // Password matches, set session
        $_SESSION['user'] = $username;
        $_SESSION['user_id'] = $user_id;

        // Redirect to Home2.html after successful login
        header("Location: Home2.html");
        exit();
    } else {
        // Redirect back to login page with an error message
        echo "<script>alert('Invalid username or password.'); window.location.href = 'login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
