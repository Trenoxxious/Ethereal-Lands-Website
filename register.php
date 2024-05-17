<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/home/playethe/public_html/error.log');

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
    if (!preg_match("/^[A-Za-z0-9 ]{2,12}$/", $username)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username. It should only contain letters, numbers, or spaces, and be between 2 and 12 characters long.']);
        exit;
    }

    // Check if username contains "Mod" or "Admin" (case-insensitive)
    if (stripos($username, 'mod') !== false || stripos($username, 'admin') !== false) {
        echo json_encode(['status' => 'error', 'message' => 'Username should not contain "Mod" or "Admin".']);
        exit;
    }

    // Validate password length
    if (strlen($password) > 20) {
        echo json_encode(['status' => 'error', 'message' => 'Password should not be more than 20 characters in length.']);
        exit;
    }

    if (strlen($password) < 4) {
        echo json_encode(['status' => 'error', 'message' => 'Password needs to be at least 4 characters in length.']);
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address.']);
        exit;
    }

    // Check if username already exists (non-case-sensitive)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM players WHERE LOWER(username) = LOWER(?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => "Prepare failed (SELECT): " . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => "Execute failed (SELECT): " . $stmt->error]);
        exit;
    }
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username is already taken.']);
        exit;
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Start a transaction
    $conn->begin_transaction();

try {
    // Insert into players table
    $stmt = $conn->prepare("INSERT INTO players (username, group_id, email, pass, salt, combat, skill_total, x, y, fatigue, combatstyle, block_chat, block_private, block_trade, block_duel, cameraauto, onemouse, soundoff, haircolour, topcolour, trousercolour, skincolour, headsprite, bodysprite, male, creation_date, creation_ip, banned, offences, muted, kills, npc_kills, deaths, online, quest_points, lastRecoveryTryId, transfer, bounty_set_amount, bounty_kill_count, bounty_item_id, bounty_points, current_bounty) VALUES (?, 10, ?, ?, '', 3, 27, 311, 902, 0, 0, 0, 0, 0, 0, 1, 0, 0, 2, 8, 14, 0, 1, 2, 1, UNIX_TIMESTAMP(), ?, 0, '0.0.0.0', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0)");
    if (!$stmt) {
        throw new Exception("Prepare failed (INSERT into players): " . $conn->error);
    }
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $_SERVER['REMOTE_ADDR']);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed (INSERT into players): " . $stmt->error);
    }
    $playerID = $stmt->insert_id;
    $stmt->close();

    // Insert into curstats table
    $stmt = $conn->prepare("INSERT INTO curstats (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 1, 1, 1, 10, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)");
    if (!$stmt) {
        throw new Exception("Prepare failed (INSERT into curstats): " . $conn->error);
    }
    $stmt->bind_param("i", $playerID);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed (INSERT into curstats): " . $stmt->error);
    }
    $stmt->close();

    // Insert into experience table
    $stmt = $conn->prepare("INSERT INTO experience (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 0, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
    if (!$stmt) {
        throw new Exception("Prepare failed (INSERT into experience): " . $conn->error);
    }
    $stmt->bind_param("i", $playerID);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed (INSERT into experience): " . $stmt->error);
    }
    $stmt->close();

    // Insert into maxstats table
    $stmt = $conn->prepare("INSERT INTO maxstats (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 1, 1, 1, 10, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)");
    if (!$stmt) {
        throw new Exception("Prepare failed (INSERT into maxstats): " . $conn->error);
    }
    $stmt->bind_param("i", $playerID);
    if (!$stmt->execute()) {
        throw new Exception("Execute failed (INSERT into maxstats): " . $stmt->error);
    }
    $stmt->close();

    // Commit transaction
    $conn->commit();
    echo json_encode(['status' => 'success', 'message' => "New character created successfully"]);
} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
}

$conn->close();
?>