<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$esouls = $_SESSION['esouls'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ethereal Lands - Your Account</title>
</head>
<body>
    <p>Your username: <?php echo htmlspecialchars($username); ?></p>
    <p>Your Player ID: <?php echo htmlspecialchars($user_id); ?></p>
    <a href="logout.php">Logout</a>
    <a href="index">Home</a>
</body>
</html>