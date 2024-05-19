<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ethereal Lands - Your Account</title>
</head>
<body>
    <p>Your username: <?php echo htmlspecialchars($username); ?></p>
    <p>Your Player ID: <?php echo htmlspecialchars($user_id); ?></p>
    <h1>Welcome to the protected page!</h1>
    <p>This page is only accessible to logged-in users.</p>
    <a href="logout.php">Logout</a>
</body>
</html>