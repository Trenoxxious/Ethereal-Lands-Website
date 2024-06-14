<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
    exit;
}

// Include database connection details
require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

$user_id = $_SESSION['user_id']; // Assuming user ID is stored in session

$query = "
SELECT dc.id, dc.fulfillment_amount, pc.value 
FROM daily_challenges dc
JOIN player_cache pc ON dc.cache_key = pc.key
JOIN player_daily_challenges pdc ON dc.id = pdc.challenge_id
WHERE pdc.user_id = ? AND pc.playerID = ? AND pdc.completed = 0";

$stmt = $conn->prepare($query);
if ($stmt === false) {
    echo json_encode(['error' => 'Prepare statement failed: ' . $conn->error]);
    exit;
}

$stmt->bind_param("ii", $user_id, $user_id);

if (!$stmt->execute()) {
    echo json_encode(['error' => 'Execute statement failed: ' . $stmt->error]);
    exit;
}

$result = $stmt->get_result();
if ($result === false) {
    echo json_encode(['error' => 'Get result failed: ' . $stmt->error]);
    exit;
}

$progress = mysqli_fetch_all($result, MYSQLI_ASSOC);
$stmt->close();

echo json_encode($progress);
