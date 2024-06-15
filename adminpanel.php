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

if ($isAdmin == false) {
    header("Location: account");
    exit;
}

$amount_stmt->close();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <?php include 'topbar.php'; ?>
    <div class="accountmain">
        <div class="blanktop"></div>
        <div class="souls">
            <div class="souls-display">
                <?php echo htmlspecialchars($formatted_esouls); ?>
            </div>
            <span class="add-souls" id="buysouls">Buy Souls</span>
        </div>
    </div>
    <div class="main-account-front">
        <div class="account-top">
            <h1 class="page-header">Admin Dashboard</h1>
            <p class="page-info">Use the Admin Dashboard to address character or account issues.</p>
            <p class="page-info">You are unable to
                grant items through the website. If a player is missing an item that is restricted to grant via
                `::item`, please reach out to Senior Support Staff for assistance.
            </p>
            <p class="important-message">Admin Dashboard is under construction and not all tools are available at
                this time.
            </p>
        </div>
    </div>
    <div class="account-store">
        <div class="form-sec">
            <h2>Player Lookup (Username to ID)</h2>
            <form method="post" action="scripts/lookup_player_id.php" id="player-lookup">
                <label for="playerUsername">Player Username:</label>
                <input type="text" id="playerUsername" name="playerUsername" required><br>
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Lookup Player ID">
            </form>
            <div class="results" id="playerIDResults">Look up a username to find the player's ID.</div>
        </div>
        <div class="form-sec">
            <h2>Player Cache Adjustment (player_cache db table)</h2>
            <form method="post" action="scripts/insert_player_cache.php">
                <label for="playerID">Player ID (num)</label>
                <input type="number" id="playerID" name="playerID" required><br>
                <label for="key">Key (eg. tutorial_island)</label>
                <input type="text" id="key" name="key" required><br>
                <label for="value">Value (num)</label>
                <input type="number" id="value" name="value" required><br>
                <input type="hidden" name="type" value="0">
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Insert player_cache Data">
            </form>
            <div class="button-main" href="help/player_cache_submission">Wiki Help</div>
        </div>
        <script>
            $(document).ready(function () {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'scripts/lookup_player_id.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#playerIDResults').html(response.message);
                    }
                });
                $('input, textarea').blur();
            });
        </script>
</body>

</html>