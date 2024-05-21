<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit;
}

// Include database connection details
require 'globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];

// Fetch the latest amount of ethereal souls from the database
$amount_sql = "SELECT amount FROM etherealsouls WHERE id = ?";
$amount_stmt = $conn->prepare($amount_sql);
$amount_stmt->bind_param("i", $user_id);
$amount_stmt->execute();
$amount_result = $amount_stmt->get_result();

if ($amount_result->num_rows > 0) {
    $amount_row = $amount_result->fetch_assoc();
    $esouls = $amount_row['amount'];
} else {
    $esouls = 0; // Default value if no record is found
}

$formatted_esouls = number_format($esouls);

$amount_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Ethereal Lands - Your Account</title>
</head>
<body>
    <p>Your username: <?php echo htmlspecialchars($username); ?></p>
    <p>Your Player ID: <?php echo htmlspecialchars($user_id); ?></p>
    <p>Your Current Ethereal Souls: <?php echo htmlspecialchars($formatted_esouls); ?></p>
    <a href="logout.php">Logout</a>
    <a href="index">Home</a>
</body>
</html>