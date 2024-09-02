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
$challenge_id = $_POST['challenge_id'];

// Fetch the challenge details
$query = "SELECT * FROM daily_challenges WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $challenge_id);
$stmt->execute();
$result = $stmt->get_result();
$challenge = $result->fetch_assoc();

if ($challenge) {
    // Check player's progress
    $query = "SELECT `value` FROM player_cache WHERE playerID = ? AND `key` = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("is", $user_id, $challenge['cache_key']);
    $stmt->execute();
    $result = $stmt->get_result();
    $player_cache = $result->fetch_assoc();

    if ($player_cache && $player_cache['value'] >= $challenge['fulfillment_amount']) {
        $delete_query = "DELETE FROM player_cache WHERE playerID = ? AND `key` = ?";
        $delete_stmt = $conn->prepare($delete_query);
        $delete_stmt->bind_param("is", $user_id, $challenge['cache_key']);
        $delete_stmt->execute();

        if ($delete_stmt->affected_rows > 0) {
            // Update etherealsouls
            $query = "UPDATE etherealsouls SET amount = amount + ?, total_dailies_completed = total_dailies_completed + 1 WHERE id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $challenge['reward_amount'], $user_id);
            $stmt->execute();

            // Mark challenge as completed
            $query = "UPDATE player_daily_challenges SET completed = 1 WHERE user_id = ? AND challenge_id = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $challenge_id);
            $stmt->execute();

            if (isset($_SESSION['total_dailies_completed'])) {
                $_SESSION['total_dailies_completed']++;
            } else {
                $_SESSION['total_dailies_completed'] = 1;
            }

            if (isset($_SESSION['amount_of_souls'])) {
                $_SESSION['amount_of_souls'] += $challenge['reward_amount'];
            } else {
                $_SESSION['amount_of_souls'] = $challenge['reward_amount'];
            }

            echo json_encode([
                'success' => true, 
                'message' => 'Challenge completed!', 
                'reward' => $challenge['reward_amount'],
                'total_dailies_completed' => $_SESSION['total_dailies_completed'],
                'formatted_souls' => number_format($_SESSION['amount_of_souls'])
            ]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Unable to alter player cache. Challenge not completed!']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Challenge not completed!']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Challenge not found. Contact support for assistance.']);
}

$stmt->close();
$conn->close();