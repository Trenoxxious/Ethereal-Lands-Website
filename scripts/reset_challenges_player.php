<?php
require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID'];
    // Fetch all daily challenge cache keys
    $query = "SELECT cache_key FROM daily_challenges";
    $result = mysqli_query($conn, $query);
    if (!$result) {
        $response = ['status' => 'error', 'message' => "Error fetching daily challenge cache keys: " . mysqli_error($conn)];
        echo json_encode($response);
        return;
    }
    $challenge_keys = mysqli_fetch_all($result, MYSQLI_ASSOC);

    foreach ($challenge_keys as $challenge) {
        $cache_key = $challenge['cache_key'];
        $query = "DELETE FROM player_cache WHERE `key` = ? AND `type` = 4 AND `playerID` = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("si", $cache_key, $playerID);
        $stmt->execute();
        if ($stmt->error) {
            $response = ['status' => 'error', 'message' => "Error deleting player cache: " . $stmt->error];
            echo json_encode($response);
            $stmt->close();
            return;
        }
        $stmt->close();
    }

    // Reset has_accepted_daily_challenges flag for all players
    $query = "UPDATE etherealsouls SET has_accepted_daily_challenges = 0 WHERE `id` = $playerID";
    if (!mysqli_query($conn, $query)) {
        $response = ['status' => 'error', 'message' => "Error updating etherealsouls table: " . mysqli_error($conn)];
        echo json_encode($response);
        return;
    }

    // Clear player_daily_challenges table
    $query = "DELETE FROM player_daily_challenges WHERE `user_id` = $playerID";
    if (!mysqli_query($conn, $query)) {
        $response = ['status' => 'error', 'message' => "Error deleting from player_daily_challenges table: " . mysqli_error($conn)];
        echo json_encode($response);
        return;
    }

    $response = ['status' => 'success', 'message' => "The daily challenges for playerID $playerID have been reset."];
    echo json_encode($response);
}

$conn->close();
