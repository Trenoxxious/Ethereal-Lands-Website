<?php
session_start();

require 'globals.php'; // Your database connection script

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (!isset($_SESSION['user_id'])) {
    header('Location: index'); // Redirect to login page if not logged in
    exit;
}

$user_id = $_SESSION['user_id'];

// Check if the user is 'online' in the players table
$query = "SELECT online FROM players WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user_status = mysqli_fetch_assoc($result);

if ($user_status && $user_status['online'] == 1) {
    echo "You cannot make purchases while online. Please log off your character first.";
    exit;
}

$item_id = intval($_POST['item_id']);

// Fetch item details
$query = "SELECT price, type, secondary_attr FROM etherealitems WHERE item_id = $item_id";
$result = mysqli_query($conn, $query);
$item = mysqli_fetch_assoc($result);

if (!$item) {
    echo "Item not found.";
    exit;
}

$item_price = intval($item['price']);
$item_type = $item['type'];
$secondary_attr = $item['secondary_attr'];

// Fetch user's ethereal souls
$query = "SELECT amount FROM etherealsouls WHERE id = $user_id";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

if (!$user || $user['amount'] < $item_price) {
    echo "Not enough Ethereal Souls.";
    exit;
}

// Deduct item price from user's ethereal souls
$new_amount = $user['amount'] - $item_price;
$query = "UPDATE etherealsouls SET amount = $new_amount WHERE id = $user_id";
mysqli_query($conn, $query);

// Search for the item in itemstatuses by catalogID
$query = "SELECT itemID, amount FROM itemstatuses WHERE catalogID = $item_id";
$result = mysqli_query($conn, $query);
$item_status = mysqli_fetch_assoc($result);

if ($item_status && $item_type == 'bank') {
    $existing_item_id = $item_status['itemID'];

    // Check if this itemID exists in the bank for this user
    $query = "SELECT * FROM bank WHERE playerID = $user_id AND itemID = $existing_item_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Update the amount in itemstatuses
        $new_amount = $item_status['amount'] + 1;
        $query = "UPDATE itemstatuses SET amount = $new_amount WHERE itemID = $existing_item_id";
        mysqli_query($conn, $query);
    } else {
        // Find the next available slot
        $query = "SELECT MAX(slot) as max_slot FROM bank WHERE playerID = $user_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $next_slot = isset($row['max_slot']) ? $row['max_slot'] + 1 : 1;

        // Insert item into bank
        $query = "INSERT INTO bank (playerID, itemID, slot) VALUES ($user_id, $existing_item_id, $next_slot)";
        mysqli_query($conn, $query);

        // Update the amount in itemstatuses
        $new_amount = $item_status['amount'] + 1;
        $query = "UPDATE itemstatuses SET amount = $new_amount WHERE itemID = $existing_item_id";
        mysqli_query($conn, $query);
    }
} else {
    // Find the highest itemID in the itemstatuses table
    $query = "SELECT MAX(itemID) as max_item_id FROM itemstatuses";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);
    $new_item_id = isset($row['max_item_id']) ? $row['max_item_id'] + 1 : 1;

    // Insert data into itemstatuses table
    $query = "INSERT INTO itemstatuses (itemID, catalogID, amount, noted, wielded, durability) 
              VALUES ($new_item_id, $item_id, 1, 0, 0, 100)";
    mysqli_query($conn, $query);

    if ($item_type == 'equippable') {
        // Update player's secondary attribute
        $query = "UPDATE players SET $secondary_attr = $item_id WHERE id = $user_id";
        mysqli_query($conn, $query);
    } else if ($item_type == 'bank') {
        // Find the next available slot
        $query = "SELECT MAX(slot) as max_slot FROM bank WHERE playerID = $user_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $next_slot = isset($row['max_slot']) ? $row['max_slot'] + 1 : 1;

        // Insert item into bank
        $query = "INSERT INTO bank (playerID, itemID, slot) VALUES ($user_id, $new_item_id, $next_slot)";
        mysqli_query($conn, $query);
    }
}

echo "Purchase successful.";