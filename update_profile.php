<?php
session_start();
include("db.php");

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$address = $_POST['address'];
$city = $_POST['city'];
$country = $_POST['country'];
$bio = $_POST['bio'];

// Handle file upload (Profile Picture)
$profile_picture = "";
if (!empty($_FILES['profile_picture']['name'])) {
    $target_dir = "uploads/";
    $profile_picture = $target_dir . basename($_FILES['profile_picture']['name']);
    move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $profile_picture);
}

// Check if user profile exists
$query = "SELECT * FROM user_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Update existing profile
    if (!empty($profile_picture)) {
        $query = "UPDATE user_profiles SET profile_picture=?, address=?, city=?, country=?, bio=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssssi", $profile_picture, $address, $city, $country, $bio, $user_id);
    } else {
        $query = "UPDATE user_profiles SET address=?, city=?, country=?, bio=? WHERE user_id=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ssssi", $address, $city, $country, $bio, $user_id);
    }
} else {
    // Insert new profile
    $query = "INSERT INTO user_profiles (user_id, profile_picture, address, city, country, bio) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("isssss", $user_id, $profile_picture, $address, $city, $country, $bio);
}

if ($stmt->execute()) {
    header("Location: Home2.html");  // Redirect after successful update
    exit();
} else {
    echo "Error updating profile: " . $conn->error;
}

$conn->close();
?>
