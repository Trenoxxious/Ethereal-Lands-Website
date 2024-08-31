<?php
session_start();
header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['error' => 'User not logged in']);
    exit;
}

require '../globals.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user is 'online' in the players table
$query = "SELECT online FROM players WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_status = $result->fetch_assoc();

if ($user_status && $user_status['online'] == 1) {
    echo json_encode(['error' => 'You cannot accept daily challenges while online. Please log off your character first.']);
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Ensure the player has not already accepted daily challenges
$query = "SELECT has_accepted_daily_challenges FROM etherealsouls WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

if ($player['has_accepted_daily_challenges'] == 1) {
    // Fetch existing challenges
    $query = "
        SELECT dc.id, dc.title, dc.mission, dc.rarity, dc.reward_amount, dc.fulfillment_amount, pc.value
        FROM daily_challenges dc
        JOIN player_cache pc ON dc.cache_key = pc.key
        JOIN player_daily_challenges pdc ON dc.id = pdc.challenge_id
        WHERE pdc.user_id = ? AND pc.playerID = ? AND pdc.completed = 0";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $challenges = mysqli_fetch_all($result, MYSQLI_ASSOC);
    
    echo json_encode(['success' => true, 'challenges' => $challenges, 'message' => 'Existing challenges fetched']);
} else {
    // Fetch 3 random daily challenges
    $query = "SELECT id, title, mission, rarity, reward_amount, fulfillment_amount, cache_key FROM daily_challenges ORDER BY RAND() LIMIT 3";
    $result = $conn->query($query);
    $challenges = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($challenges as $challenge) {
        // Insert the selected challenges into player_daily_challenges
        $query = "INSERT INTO player_daily_challenges (user_id, challenge_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $challenge['id']);
        $stmt->execute();

        // Insert into player_cache
        $query = "INSERT INTO player_cache (playerID, type, `key`, `value`) VALUES (?, 4, ?, '0') ON DUPLICATE KEY UPDATE `value` = '0'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $user_id, $challenge['cache_key']);
        $stmt->execute();
    }

    // Update the etherealsouls table
    $query = "UPDATE etherealsouls SET has_accepted_daily_challenges = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    echo json_encode(['success' => true, 'challenges' => $challenges]);
}

$conn->close();