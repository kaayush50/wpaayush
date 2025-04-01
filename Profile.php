<?php 
session_start();
include("db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.html");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch existing profile details
$query = "SELECT * FROM user_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

// Handle case where user has no profile yet
if (!$profile) {
    $profile = [
        "profile_picture" => "",
        "address" => "",
        "city" => "",
        "country" => "",
        "bio" => ""
    ];
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Profile</title>
    <link rel="stylesheet" href="Profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>Edit Your Profile</h2>

        <!-- Display Profile Picture -->
        <?php if (!empty($profile['profile_picture'])): ?>
            <img src="<?php echo $profile['profile_picture']; ?>" alt="Profile Picture" width="150">
        <?php endif; ?>

        <form action="update_profile.php" method="POST" enctype="multipart/form-data">
            <label>Profile Picture:</label>
            <input type="file" name="profile_picture"><br><br>

            <label>Address:</label>
            <input type="text" name="address" value="<?php echo htmlspecialchars($profile['address']); ?>"><br><br>

            <label>City:</label>
            <input type="text" name="city" value="<?php echo htmlspecialchars($profile['city']); ?>"><br><br>

            <label>Country:</label>
            <input type="text" name="country" value="<?php echo htmlspecialchars($profile['country']); ?>"><br><br>

            <label>Bio:</label>
            <textarea name="bio"><?php echo htmlspecialchars($profile['bio']); ?></textarea><br><br>

            <button type="submit">Update Profile</button>
            <button onclick="logout()" class="btn btn-danger">Logout</button>
        </form>

        <br>
        <a href="view_profile.php">View My Profile</a> <!-- Link to view updated profile -->
    </div>

    <script>
        function logout() {
            alert("You have been logged out successfully!"); // Show alert message
            window.location.href = "login.html"; // Redirect to logout.php
        }
    </script>
</body>
</html>
