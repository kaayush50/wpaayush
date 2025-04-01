<?php
include 'db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Hash the password securely
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Check if username exists
    $check_query = $conn->prepare("SELECT id FROM users WHERE username = ?");
    $check_query->bind_param("s", $username);
    $check_query->execute();
    $check_query->store_result();

    if ($check_query->num_rows > 0) {
        echo "<script>alert('Username already taken!'); window.location.href = 'signup.html';</script>";
    } else {
        // Insert new user into database
        $stmt = $conn->prepare("INSERT INTO users (username, password) VALUES (?, ?)");
        $stmt->bind_param("ss", $username, $hashed_password);

        if ($stmt->execute()) {
            echo "<script>alert('Registration successful! Please login.'); window.location.href = 'login.html';</script>";
        } else {
            echo "<script>alert('Error occurred. Try again.'); window.location.href = 'signup.html';</script>";
        }
        $stmt->close();
    }
    $check_query->close();
}

$conn->close();
?>
