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
    $soulsAmount = $_POST['soulsAmount'];

    $sql = "SELECT amount FROM etherealsouls WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $playerID);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $currentSouls = $row['amount'];

        if ($soulsAmount < 0) {
            $newSouls = max(0, $currentSouls + $soulsAmount);
        } else if ($soulsAmount == 0) {
            $newSouls = $currentSouls;
        } else {
            $newSouls = $currentSouls + $soulsAmount;
        }

        $updateSql = "UPDATE etherealsouls SET amount = ? WHERE id = ?";
        $updateStmt = $conn->prepare($updateSql);
        $updateStmt->bind_param("ii", $newSouls, $playerID);

        $formatted_newSouls = number_format($newSouls);
        if ($updateStmt->execute()) {
            $response = ['status' => 'success', 'message' => "Souls adjusted. The new amount of Ethereal Souls for Player ID $playerID is $formatted_newSouls."];
        } else {
            $response = ['status' => 'error', 'message' => "Error updating ethereal souls: " . $conn->error];
        }
    } else {
        $response = ['status' => 'error', 'message' => "Error: Player ID $playerID not found in the database."];
    }
    echo json_encode($response);
    $stmt->close();
    $updateStmt->close();
}

$conn->close();