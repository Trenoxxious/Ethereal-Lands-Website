<?php
header('Content-Type: application/json');

$servername = "localhost";
$username = "playethe_root";
$password = "imthebestmany0";
$dbname = "playethe_ethereallands";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validate username
    if (!preg_match("/^[A-Za-z0-9 ]{1,12}$/", $username)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username. It should only contain letters, numbers, or spaces, and be up to 12 characters long.']);
        exit;
    }

    // Validate password length
    if (strlen($password) > 20) {
        echo json_encode(['status' => 'error', 'message' => 'Password should not be more than 20 characters in length.']);
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
        exit;
    }

    // Generate salt and hash the password
    $salt = bin2hex(random_bytes(16));
    $hashedPassword = hash('sha512', $password . $salt);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO players (username, group_id, email, pass, salt, combat, skill_total, x, y, fatigue, combatstyle, block_chat, block_private, block_trade, block_duel, cameraauto, onemouse, soundoff, haircolour, topcolour, trousercolour, skincolour, headsprite, bodysprite, male, creation_date, creation_ip, login_date, login_ip, banned, offences, muted, kills, npc_kills, deaths, online, quest_points, lastRecoveryTryId, transfer, bounty_set_amount, bounty_kill_count, bounty_item_id, bounty_points, current_bounty) VALUES (?, 10, ?, ?, ?, 3, 27, 216, 451, 0, 0, 0, 0, 0, 0, 1, 0, 0, 2, 8, 14, 0, 1, 2, 1, UNIX_TIMESTAMP(), ?, 0, '0.0.0.0', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, 0, 0, 0, 0, 0)");
    $stmt->bind_param("ssssss", $username, $email, $hashedPassword, $salt, $_SERVER['REMOTE_ADDR']);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => "New character created successfully"]);
    } else {
        echo json_encode(['status' => 'error', 'message' => "Error: " . $stmt->error]);
    }

    $stmt->close();
}

$conn->close();
?>
