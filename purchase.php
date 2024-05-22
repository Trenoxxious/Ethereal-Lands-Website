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

if ($item_type == 'equippable') {
    // Update player's secondary attribute
    $query = "UPDATE players SET $secondary_attr = $item_id WHERE id = $user_id";
    mysqli_query($conn, $query);
} else if ($item_type == 'bank') {
    // Check if the item already exists in the bank
    $query = "SELECT * FROM bank WHERE playerID = $user_id AND itemID = $item_id";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        // Item already exists in the bank, increase quantity by 1
        $query = "UPDATE bank SET quantity = quantity + 1 WHERE playerID = $user_id AND itemID = $item_id";
        mysqli_query($conn, $query);
    } else {
        // Find the next available slot
        $query = "SELECT MAX(slot) as max_slot FROM bank WHERE playerID = $user_id";
        $result = mysqli_query($conn, $query);
        $row = mysqli_fetch_assoc($result);
        $next_slot = isset($row['max_slot']) ? $row['max_slot'] + 1 : 1;

        // Insert item into bank
        $query = "INSERT INTO bank (playerID, itemID, slot, quantity) VALUES ($user_id, $item_id, $next_slot, 1)";
        mysqli_query($conn, $query);
    }
}

echo "Purchase successful.";
?>