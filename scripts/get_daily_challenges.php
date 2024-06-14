<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
    exit;
}

// Include database connection details
require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    echo "You cannot accept daily challenges while online. Please log off your character first.";
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

if ($player['has_accepted_daily_challenges'] == 0) {
    // Fetch 3 random daily challenges
    $query = "SELECT id FROM daily_challenges ORDER BY RAND() LIMIT 3";
    $result = $conn->query($query);
    $challenge_ids = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($challenge_ids as $challenge) {
        $challenge_id = $challenge['id'];

        // Insert the selected challenges into player_daily_challenges
        $query = "INSERT INTO player_daily_challenges (user_id, challenge_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $user_id, $challenge_id);
        if (!$stmt->execute()) {
            error_log("Error inserting into player_daily_challenges: " . $stmt->error);
        }

        // Fetch the cache_key for the selected challenge
        $query = "SELECT cache_key FROM daily_challenges WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $challenge_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $challenge_data = $result->fetch_assoc();
        $cache_key = $challenge_data['cache_key'];

        // Insert into player_cache
        $query = "INSERT INTO player_cache (playerID, type, `key`, `value`) VALUES (?, 4, ?, '0') ON DUPLICATE KEY UPDATE `value` = '0'";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("is", $user_id, $cache_key);
        $stmt->execute();

        if ($stmt->affected_rows > 0) {
            // Row was inserted successfully - Do nothing
        } else {
            // Row was not inserted, possibly due to a unique constraint violation
            $error = $stmt->error;
            error_log("Error updating player_cache: " . $stmt->error);
        }
    }

    // Update the etherealsouls table to indicate the player has accepted daily challenges
    $query = "UPDATE etherealsouls SET has_accepted_daily_challenges = 1 WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    if (!$stmt->execute()) {
        error_log("Error updating etherealsouls: " . $stmt->error);
    }
}

// Redirect back to daily challenges page
header("Location: ../challenges");