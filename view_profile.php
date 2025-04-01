<?php
session_start();
include("db.php");

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

// Fetch user profile details
$query = "SELECT * FROM user_profiles WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$profile = $result->fetch_assoc();

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>My Profile</title>
    <link rel="stylesheet" href="Profile.css">
</head>
<body>
    <div class="profile-container">
        <h2>My Profile</h2>

        <!-- Display Profile Picture -->
        <?php if (!empty($profile['profile_picture'])): ?>
            <img src="<?php echo $profile['profile_picture']; ?>" alt="Profile Picture" width="150">
        <?php else: ?>
            <p>No profile picture uploaded</p>
        <?php endif; ?>

        <p><strong>Address:</strong> <?php echo htmlspecialchars($profile['address']); ?></p>
        <p><strong>City:</strong> <?php echo htmlspecialchars($profile['city']); ?></p>
        <p><strong>Country:</strong> <?php echo htmlspecialchars($profile['country']); ?></p>
        <p><strong>Bio:</strong> <?php echo htmlspecialchars($profile['bio']); ?></p>

        <br>
        <a href="Profile.php">Edit Profile</a>
    </div>
</body>
</html>
