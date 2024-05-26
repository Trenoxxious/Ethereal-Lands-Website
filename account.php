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

$sql = "SELECT attack, defense, hits, strength, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman FROM maxstats WHERE playerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stats = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stats = [
        'Attack level' => $row['attack'],
        'Defense level' => $row['defense'],
        'Hits level' => $row['hits'],
        'Strength level' => $row['strength'],
        'Ranged level' => $row['ranged'],
        'Prayer level' => $row['prayer'],
        'Magic level' => $row['magic'],
        'Cooking level' => $row['cooking'],
        'Woodcutting level' => $row['woodcut'],
        'Fletching level' => $row['fletching'],
        'Fishing level' => $row['fishing'],
        'Firemaking level' => $row['firemaking'],
        'Crafting level' => $row['crafting'],
        'Smithing level' => $row['smithing'],
        'Mining level' => $row['mining'],
        'Herblaw level' => $row['herblaw'],
        'Agility level' => $row['agility'],
        'Thieving level' => $row['thieving'],
        'Huntsman level' => $row['huntsman']
    ];
}

$amount_stmt->close();
$conn->close();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - My Account</title>
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
        <div class="main-account-front">
            <h1 class="page-header">Character Stats (<?php echo $username; ?>)</h1>
            <div class="account-stats">
                <?php foreach ($stats as $statName => $statValue): ?>
                    <p><?php echo htmlspecialchars($statName . ': ' . $statValue); ?></p>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</body>

</html>