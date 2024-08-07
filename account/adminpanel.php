<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit;
}

// Include database connection details
require '../globals.php';

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
    header("Location: character");
    exit;
}

$amount_stmt->close();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="../script.js?ver=<?= time(); ?>"></script>
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
    <div class="account-support">
        <div class="form-sec">
            <h2>Player ID Lookup</h2>
            <form method="post" action="scripts/lookup_player_id.php" id="player-lookup">
                <label for="playerUsername">Player Username (str)</label>
                <input type="text" maxlength="12" id="playerUsername" name="playerUsername" required><br>
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Lookup Player ID">
            </form>
            <div class="results" style="margin-top: 10px;" id="playerIDResults">Awaiting username lookup...</div>
            <div class="button-main" style="margin-top: 10px;" id="player_id_lookup">Wiki Help</div>
        </div>
        <div class="form-sec">
            <h2>Reset Player Daily Challenges</h2>
            <form method="post" action="scripts/reset_challenges_player.php" id="reset-player-challenges">
                <label for="playerID">Player ID (num)</label>
                <input type="number" id="playerID" name="playerID" required><br>
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Reset Challenges">
            </form>
            <div class="results" style="margin-top: 10px;" id="resetPlayerChallengesResults">Awaiting action...</div>
            <div class="button-main" style="margin-top: 10px;" id="reset_player_challenges">Wiki Help</div>
        </div>
        <div class="form-sec">
            <h2>Player Cache Insertion</h2>
            <form method="post" action="../scripts/insert_player_cache.php">
                <label for="playerID">Player ID (num)</label>
                <input type="number" id="playerID" name="playerID" required><br>
                <label for="key">Key (eg. tutorial_island)</label>
                <input type="text" id="key" name="key" required><br>
                <label for="value">Value (num)</label>
                <input type="number" id="value" name="value" required><br>
                <label for="type">Type (tinyint num)</label>
                <input type="number" id="type" name="type" required><br>
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Insert player_cache Data">
            </form>
            <div class="button-main" style="margin-top: 10px;" id="player_cache_insertion">Wiki Help</div>
        </div>
        <div class="form-sec">
            <h2>Add/Remove Ethereal Souls</h2>
            <form method="post" action="scripts/adjust_ethereal_souls.php" id="adjust-ethereal-souls">
                <label for="playerID">Player ID (num)</label>
                <input type="number" id="playerID" name="playerID" required><br>
                <label for="soulsAmount">Souls (num/-num)</label>
                <input type="number" id="soulsAmount" name="soulsAmount" required><br>
                <input class="button-main button-main-green" style="width: auto;" type="submit"
                    value="Adjust Ethereal Souls">
            </form>
            <div class="results" style="margin-top: 10px;" id="adjustEtherealSoulsResults">Awaiting action...</div>
            <div class="button-main" style="margin-top: 10px;" id="adjust_ethereal_souls">Wiki Help</div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#player-lookup').on('submit', function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../scripts/lookup_player_id.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#playerIDResults').html(response.message);
                    }
                });
                $('input, textarea').blur();
            });
            $('#reset-player-challenges').on('submit', function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../scripts/reset_challenges_player.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#resetPlayerChallengesResults').html(response.message);
                        setTimeout(() => {
                            $('#resetPlayerChallengesResults').html('Awaiting action...');
                        }, 5000);
                    }
                });
                $('input, textarea').blur();
            });
            $('#adjust-ethereal-souls').on('submit', function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: '../scripts/adjust_ethereal_souls.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#adjustEtherealSoulsResults').html(response.message);
                    }
                });
                $('input, textarea').blur();
            });
            $('#player_cache_insertion, #player_id_lookup, #reset_player_challenges, #adjust_ethereal_souls').on('click', function (event) {
                window.location.href = 'help/' + this.id.replace('_', '_');
            });
        });
    </script>
</body>

</html>