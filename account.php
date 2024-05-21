<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit;
}

// Include database connection details
require 'globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$accstatus = $_SESSION['accstatus'];

// Fetch the latest amount of ethereal souls from the database
$amount_sql = "SELECT amount FROM etherealsouls WHERE id = ?";
$amount_stmt = $conn->prepare($amount_sql);
$amount_stmt->bind_param("i", $user_id);
$amount_stmt->execute();
$amount_result = $amount_stmt->get_result();

if ($amount_result->num_rows > 0) {
    $amount_row = $amount_result->fetch_assoc();
    $esouls = $amount_row['amount'];
} else {
    $esouls = 0; // Default value if no record is found
}

$formatted_esouls = number_format($esouls);
$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;


$amount_stmt->close();
$conn->close();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - My Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="accountbar">
            <h1 class="accountname"><?php echo $username; ?></h1>
            <div id="navlinks">
                <a href="index">Home</a>
                <a href="account">My Account</a>
                <?php if ($isAdmin): ?>
                    <a href="#">Admin Dashboard</a>
                <?php endif; ?>
                <a href="#">Store</a>
                <a href="logout">Logout</a>
            </div>
            <div id="menuexpandaccount">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenuaccount">
            <a href="index">Home</a>
            <a href="account">My Account</a>
            <?php if ($isAdmin): ?>
                <a href="#">Admin Dashboard</a>
            <?php endif; ?>
            <a href="#">Store</a>
            <a href="logout">Logout</a>
        </div>
    </div>
    <div class="accountmain">
        <div class="blanktop"></div>
        <div class="souls">
            <div class="souls-display"><span class="color-white">Ethereal Souls:&nbsp;</span>
                <?php echo htmlspecialchars($formatted_esouls); ?></div>
            <span class="add-souls" id="buysouls">+</span>
        </div>
    </div>
</body>

</html>