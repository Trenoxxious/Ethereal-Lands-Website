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
    $playerUsername = $_POST['playerUsername'];
    $sql = "SELECT id as playerID FROM players WHERE `name` = '$playerUsername'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $playerUsername = $row['name'];
        $playerId = $row['id'];
        echo json_encode(['status' => 'success', 'message' => "The player ID for $playerUsername is: $playerId"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "No such player with that username."]);
    }
}

$conn->close();