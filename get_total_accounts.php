<?php
// Database credentials
$servername = "localhost";
$username = "playethe_root";
$password = "imthebestmany0";
$dbname = "playethe_ethereallands";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to count the number of accounts
$countSql = "SELECT COUNT(*) as total FROM players";
$countResult = $conn->query($countSql);
$countRow = $countResult->fetch_assoc();
$totalAccounts = $countRow['total'];

// Return the total number of accounts as JSON
echo json_encode(array('totalAccounts' => $totalAccounts));

// Close connection
$conn->close();
?>
