<?php
require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID'];
    // Fetch all daily challenge cache keys
    $query = "SELECT cache_key FROM daily_challenges";
    $result = mysqli_query($conn, $query);
    $challenge_keys = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($challenge_keys as $challenge) {
        $cache_key = $challenge['cache_key'];
        $query = "DELETE FROM player_cache WHERE `key` = ? AND `type` = 4 AND `playerID` = $playerID";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("s", $cache_key);
        $stmt->execute();
        $stmt->close();
    }

    // Reset has_accepted_daily_challenges flag for all players
    $query = "UPDATE etherealsouls SET has_accepted_daily_challenges = 0 WHERE `id` = $playerID";
    mysqli_query($conn, $query);

    // Clear player_daily_challenges table
    $query = "DELETE FROM player_daily_challenges WHERE `user_id` = $playerID";
    mysqli_query($conn, $query);

    $response = ['status' => 'success', 'message' => "The daily challenges for playerID $playerID have been reset."];
    echo json_encode($response);
}
$conn->close();
