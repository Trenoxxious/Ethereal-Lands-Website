<?php
session_start();

require '../globals.php';

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$accstatus = $_SESSION['accstatus'];
$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;

if ($isAdmin == false) {
    header("Location: ../account");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID'];
    $key = $_POST['key'];
    $value = $_POST['value'];
    $type = $_POST['type'];

    // Check if the user is 'online' in the players table
    $query = "SELECT online FROM players WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $playerID);
    $stmt->execute();
    $result = $stmt->get_result();
    $user_status = $result->fetch_assoc();

    if ($user_status && $user_status['online'] == 1) {
        echo "You can not modify this user's cache while they are logged in. Please have them log out.";
        $stmt->close();
        $conn->close();
        exit;
    }

    $check_sql = "SELECT * FROM player_cache WHERE playerID = '$playerID' AND `key` = '$key'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        // Automatically update the value if the key exists
        $update_sql = "UPDATE player_cache SET value = '$value', type = '$type' WHERE playerID = '$playerID' AND `key` = '$key'";
        if ($conn->query($update_sql) === TRUE) {
            echo "The player already had the cache key specified. The value has been updated successfully.";
        } else {
            echo "Error updating value: " . $conn->error;
        }
    } else {
        $sql = "INSERT INTO player_cache (playerID, `key`, value, type) VALUES ('$playerID', '$key', '$value', '$type')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully. The cache key has been successfully inserted.";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();