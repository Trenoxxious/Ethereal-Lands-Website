<?php
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

// Check if the player has accepted daily challenges
$query = "SELECT has_accepted_daily_challenges FROM etherealsouls WHERE id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$player = $result->fetch_assoc();

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
?>

<!DOCTYPE html>
<html>

<head>
    <title>Ethereal Lands - Daily Challenges</title>
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
    <div class="challenge-message" id="message"></div>
    <div class="main-account-front">
        <div class="account-top">
            <h1 class="page-header">Daily Challenges</h1>
            <p class="page-info">Complete up to three random daily challenges per day to earn Ethereal Souls.</p>
            <?php
            // Get the server's time zone
            $serverTimeZone = date_default_timezone_get();

            // Set the time zone for the script
            date_default_timezone_set($serverTimeZone);

            $currentTime = time();
            $todayMidnight = strtotime('today', $currentTime) + 86400; // Add 86400 seconds (1 day) to get tomorrow's midnight
            $remainingTime = $todayMidnight - $currentTime;
            ?>
            <div id="countdown">
                <h2 id="countdown-label" id="countdown-label">Resets in: <span
                        id="countdown-timer"><?php echo gmdate("H:i:s", $remainingTime); ?></span>
                </h2>
            </div>
        </div>
        <script>
            var countdownTimer;
            var countdownElement = document.getElementById("countdown-timer");
            var remainingTime = <?php echo $remainingTime; ?>;

            function updateCountdown() {
                if (remainingTime <= 0) {
                    clearInterval(countdownTimer);
                    countdownElement.innerHTML = "00:00:00";
                    window.location.reload();
                } else {
                    var hours = Math.floor(remainingTime / 3600);
                    var minutes = Math.floor((remainingTime % 3600) / 60);
                    var seconds = remainingTime % 60;
                    countdownElement.innerHTML = (hours < 10 ? "0" + hours : hours) + ":" + (minutes < 10 ? "0" + minutes : minutes) + ":" + (seconds < 10 ? "0" + seconds : seconds);
                    requestAnimationFrame(updateCountdown);
                }
            }

            function startCountdown() {
                countdownTimer = setInterval(function () {
                    remainingTime--;
                }, 1000);
                requestAnimationFrame(updateCountdown);
            }

            startCountdown();
        </script>
    </div>
    <div class="account-store">
        <?php if ($player['has_accepted_daily_challenges'] == 0): ?>
            <form method="post" action="scripts/get_daily_challenges.php">
                <button type="submit" class="button-main button-main-green">Get Daily Challenges</button>
            </form>
        <?php else: ?>
            <?php
            // Fetch player's accepted challenges
            $query = "
                SELECT dc.id, dc.title, dc.mission, dc.rarity, dc.reward_amount, dc.fulfillment_amount, pc.value 
                FROM daily_challenges dc
                JOIN player_cache pc ON dc.cache_key = pc.key
                JOIN player_daily_challenges pdc ON dc.id = pdc.challenge_id
                WHERE pdc.user_id = ? AND pc.playerID = ? AND pdc.completed = 0";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ii", $user_id, $user_id);
            $stmt->execute();
            $accepted_result = $stmt->get_result();
            $accepted_challenges = mysqli_fetch_all($accepted_result, MYSQLI_ASSOC);
            $stmt->close();
            ?>

            <?php foreach ($accepted_challenges as $accepted): ?>
                <div class="store-item <?php echo strtolower($accepted['rarity']); ?>-border">
                    <h3><?php echo htmlspecialchars($accepted['title']); ?></h3>
                    <p class="<?php echo strtolower($accepted['rarity']); ?>-background">
                        <?php echo htmlspecialchars($accepted['rarity']); ?> Challenge
                    </p>
                    <p class="challenge-info"><?php echo htmlspecialchars($accepted['mission']); ?></p>
                    <p id="progress-<?php echo $accepted['id']; ?>" class="challenge-stats">Progress:
                        <?php echo htmlspecialchars($accepted['value']); ?> /
                        <?php echo htmlspecialchars($accepted['fulfillment_amount']); ?>
                    </p>
                    <form id="complete-challenge-form-<?php echo $accepted['id']; ?>" class="complete-challenge-form"
                        method="post">
                        <input type="hidden" name="challenge_id" value="<?php echo $accepted['id']; ?>">
                        <button id="claim-button-<?php echo $accepted['id']; ?>" type="submit" class="button-main" <?php echo ($accepted['value'] < $accepted['fulfillment_amount']) ? 'disabled' : ''; ?>>Claim Souls</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>

</html>