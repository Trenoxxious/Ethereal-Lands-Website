<?php
require '../globals.php';
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$accstatus = $_SESSION['accstatus'];
$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;

if ($isAdmin == false) {
    header("Location: account");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $playerID = $_POST['playerID'];
    $key = $_POST['key'];
    $value = $_POST['value'];
    $type = $_POST['type'];

    $check_sql = "SELECT * FROM player_cache WHERE playerID = '$playerID' AND key = '$key'";
    $check_result = $conn->query($check_sql);

    if ($check_result->num_rows > 0) {
        echo "Key already exists. Do you want to override the value? (y/n)";
        $override = trim(fgets(STDIN));
        if ($override == 'y') {
            $update_sql = "UPDATE player_cache SET value = '$value', type = '$type' WHERE playerID = '$playerID' AND key = '$key'";
            if ($conn->query($update_sql) === TRUE) {
                echo "Value updated successfully";
            } else {
                echo "Error updating value: " . $conn->error;
            }
        } else {
            echo "Value not updated";
        }
    } else {
        $sql = "INSERT INTO player_cache (playerID, key, value, type) VALUES ('$playerID', '$key', '$value', '$type')";

        if ($conn->query($sql) === TRUE) {
            echo "New record created successfully";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}

$conn->close();