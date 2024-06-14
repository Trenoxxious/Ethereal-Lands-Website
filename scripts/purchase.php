<?php
session_start();

require '../globals.php';
require '../siteglobals.php';

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: ../index'); // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user is 'online' in the players table
$query = "SELECT online FROM players WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_status = $result->fetch_assoc();

if ($user_status && $user_status['online'] == 1) {
    echo "You cannot make purchases while online. Please log off your character first.";
    $stmt->close();
    $conn->close();
    exit;
}

$stmt->close();

if ($store_is_active == false) {
    echo "The store is not enabled right now. Check back soon!";
    $conn->close();
    exit;
}

$item_id = intval($_POST['item_id']);

// Check if the item has already been purchased by the player
$query = "SELECT * FROM user_purchases WHERE user_id = ? AND item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$result = $stmt->get_result();
if ($result->num_rows > 0) {
    echo "You have already purchased this item. Equip it from your inventory!";
    $stmt->close();
    $conn->close();
    exit;
}
$stmt->close();

// Fetch item details
$query = "SELECT price, type, secondary_attr FROM etherealitems WHERE item_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$item = $result->fetch_assoc();

if (!$item) {
    echo "Item not found.";
    $stmt->close();
    $conn->close();
    exit;
}

$item_price = intval($item['price']);
$item_type = $item['type'];
$secondary_attr = $item['secondary_attr'];

$stmt->close();

// Fetch user's ethereal souls
$query = "SELECT amount FROM etherealsouls WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

if (!$user || $user['amount'] < $item_price) {
    echo "Not enough Ethereal Souls.";
    $stmt->close();
    $conn->close();
    exit;
}

$user_amount = $user['amount'];
$stmt->close();

// Deduct item price from user's ethereal souls
$new_amount = $user_amount - $item_price;
$query = "UPDATE etherealsouls SET amount = ? WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $new_amount, $user_id);
$stmt->execute();
$stmt->close();

// Search for the item in itemstatuses by catalogID
$query = "SELECT itemID, amount FROM itemstatuses WHERE catalogID = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $item_id);
$stmt->execute();
$result = $stmt->get_result();
$item_status = $result->fetch_assoc();
$stmt->close();

if ($item_status && $item_type == 'bank') {
    $existing_item_id = $item_status['itemID'];

    // Check if this itemID exists in the bank for this user
    $query = "SELECT * FROM bank WHERE playerID = ? AND itemID = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $user_id, $existing_item_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Update the amount in itemstatuses
        $new_amount = $item_status['amount'] + 1;
        $query = "UPDATE itemstatuses SET amount = ? WHERE itemID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $new_amount, $existing_item_id);
        $stmt->execute();
    } else {
        // Find the next available slot
        $query = "SELECT MAX(slot) as max_slot FROM bank WHERE playerID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $next_slot = isset($row['max_slot']) ? $row['max_slot'] + 1 : 1;
        $stmt->close();

        // Insert item into bank
        $query = "INSERT INTO bank (playerID, itemID, slot) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $user_id, $existing_item_id, $next_slot);
        $stmt->execute();
        $stmt->close();

        // Update the amount in itemstatuses
        $new_amount = $item_status['amount'] + 1;
        $query = "UPDATE itemstatuses SET amount = ? WHERE itemID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $new_amount, $existing_item_id);
        $stmt->execute();
    }
    $stmt->close();
} else {
    // Find the highest itemID in the itemstatuses table
    $query = "SELECT MAX(itemID) as max_item_id FROM itemstatuses";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $new_item_id = isset($row['max_item_id']) ? $row['max_item_id'] + 1 : 1;
    $stmt->close();

    // Insert data into itemstatuses table
    $query = "INSERT INTO itemstatuses (itemID, catalogID, amount, noted, wielded, durability) 
              VALUES (?, ?, 1, 0, 0, 100)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ii", $new_item_id, $item_id);
    $stmt->execute();
    $stmt->close();

    if ($item_type == 'equippable') {
        // Update player's secondary attribute
        $query = "UPDATE players SET $secondary_attr = ? WHERE id = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $item_id, $user_id);
        $stmt->execute();
        $stmt->close();
    } else if ($item_type == 'bank') {
        // Find the next available slot
        $query = "SELECT MAX(slot) as max_slot FROM bank WHERE playerID = ?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $row = $result->fetch_assoc();
        $next_slot = isset($row['max_slot']) ? $row['max_slot'] + 1 : 1;
        $stmt->close();

        // Insert item into bank
        $query = "INSERT INTO bank (playerID, itemID, slot) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iii", $user_id, $new_item_id, $next_slot);
        $stmt->execute();
        $stmt->close();
    }
}

// Log the purchase in the user_purchases table
$query = "INSERT INTO user_purchases (user_id, item_id) VALUES (?, ?)";
$stmt = $conn->prepare($query);
$stmt->bind_param("ii", $user_id, $item_id);
$stmt->execute();
$stmt->close();

$conn->close();

echo "Purchase successful. Equip the item from your inventory!";