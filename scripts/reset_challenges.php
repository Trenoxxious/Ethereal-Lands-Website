<?php
require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Fetch all daily challenge cache keys
$query = "SELECT cache_key FROM daily_challenges";
$result = mysqli_query($conn, $query);
$challenge_keys = mysqli_fetch_all($result, MYSQLI_ASSOC);

// Remove corresponding entries from player_cache for each daily challenge
foreach ($challenge_keys as $challenge) {
    $cache_key = $challenge['cache_key'];
    $query = "DELETE FROM player_cache WHERE `key` = ? AND `type` = 4";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $cache_key);
    $stmt->execute();
    $stmt->close();
}

// Reset has_accepted_daily_challenges flag for all players
$query = "UPDATE etherealsouls SET has_accepted_daily_challenges = 0";
mysqli_query($conn, $query);

// Clear player_daily_challenges table
$query = "DELETE FROM player_daily_challenges";
mysqli_query($conn, $query);

$conn->close();
