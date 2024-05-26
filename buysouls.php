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
        <h1 class="page-header">Buy Ethereal Souls</h1>
        <div class="souls-packages-list">
            <div class="container">
                <div class="card_box rare">
                    <img src="images/199souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">1 Rare Cosmetic</b>!</p>
                    <p class="soulamount">200</p>
                    <div class="button-main" id="buy-200">$1.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box rare">
                    <img src="images/349souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">2 Rare Cosmetics</b>!</p>
                    <p class="soulamount">400</p>
                    <div class="button-main" id="buy-400">$3.49</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box epic">
                    <img src="images/599souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">2 Rare Cosmetics</b> or <b class="epic">1 Epic Cosmetic</b>!
                    </p>
                    <p class="soulamount">800</p>
                    <div class="button-main" id="buy-800">$5.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box epic">
                    <img src="images/999souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">4 Rare Cosmetics</b> or <b class="epic">2 Epic Cosmetics</b>!
                    </p>
                    <p class="soulamount">1,600</p>
                    <div class="button-main" id="buy-1600">$9.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box artifact">
                    <img src="images/1999souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="epic">4 Epic Cosmetics</b> or <b class="artifact">1 Artifact
                            Cosmetic</b>!
                    </p>
                    <p class="soulamount">3,600</p>
                    <div class="button-main" id="buy-3600">$19.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box artifact">
                    <span></span>
                    <img src="images/4999souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="epic">13 Epic Cosmetics</b> or <b class="artifact">3 Artifact
                            Cosmetics</b>!
                    </p>
                    <p class="soulamount">10,200</p>
                    <div class="button-main" id="buy-10200">$49.99</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>