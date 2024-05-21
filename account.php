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
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <title>Ethereal Lands - My Account</title>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <style>
                #toplogo::after {
                    content: "<?php echo $username; ?>";
                    color: white;
                    font-size: 2em;
                    text-align: left;
                    margin-left: 30px;
                }
            </style>
            <div id="navlinks">
                <?php if ($isAdmin): ?>
                    <a href="#">Admin Dashboard</a>
                <?php endif; ?>
                <a href="account">My Account</a>
                <a href="#">Store</a>
            </div>
            <div class="button-div">
            </div>
            <div id="menuexpand">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenu">
            <?php if ($isAdmin): ?>
                <a href="#">Admin Dashboard</a>
            <?php endif; ?>
            <a href="account">My Account</a>
            <a href="#">Store</a>
        </div>
    </div>
    <div id="intro">
        <div class="blanktop"></div>
        <p>Your username: <?php echo htmlspecialchars($username); ?></p>
        <p>Your Player ID: <?php echo htmlspecialchars($user_id); ?></p>
        <p>Your Current Ethereal Souls: <?php echo htmlspecialchars($formatted_esouls); ?></p>
        <a href="logout.php">Logout</a>
        <a href="index">Home</a>
        <div class="slide-fade"></div>
    </div>
</body>

</html>