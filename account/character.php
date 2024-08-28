<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
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

$sql = "SELECT attack, defense, hits, strength, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman FROM maxstats WHERE playerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$stats = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $stats = [
        'attack' => $row['attack'],
        'defense' => $row['defense'],
        'hits' => $row['hits'],
        'strength' => $row['strength'],
        'ranged' => $row['ranged'],
        'prayer' => $row['prayer'],
        'magic' => $row['magic'],
        'cooking' => $row['cooking'],
        'woodcut' => $row['woodcut'],
        'fletching' => $row['fletching'],
        'fishing' => $row['fishing'],
        'firemaking' => $row['firemaking'],
        'crafting' => $row['crafting'],
        'smithing' => $row['smithing'],
        'mining' => $row['mining'],
        'herblaw' => $row['herblaw'],
        'agility' => $row['agility'],
        'thieving' => $row['thieving'],
        'huntsman' => $row['huntsman']
    ];
}

$amount_stmt->close();

// Prepare the SQL statement to fetch all relevant cache keys at once
$sql = "SELECT `key`, `value` FROM player_cache WHERE playerID = ? AND `key` IN (
    'edcod_cyclestotal', 'edcod_normalcycles', 'edcod_heroiccycles', 'edcod_necroticcycles',
    'edcod_bosseskilled', 'edcod_monsterskilled', 'edcod_completedonce', 'edcod_deaths'
)";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Create an associative array to store the fetched values
$cryptStats = [
    'Total Cycles Completed' => 0,
    'Normal Cycles' => 0,
    'Heroic Cycles' => 0,
    'Necrotic Cycles' => 0,
    'Bosses Killed' => 0,
    'Monsters Killed' => 0,
    'Deaths' => 0
];

$dungeonCompleted = false;

while ($row = $result->fetch_assoc()) {
    switch ($row['key']) {
        case 'edcod_cyclestotal':
            $cryptStats['Total Cycles Completed'] = $row['value'];
            break;
        case 'edcod_normalcycles':
            $cryptStats['Normal Cycles'] = $row['value'];
            break;
        case 'edcod_heroiccycles':
            $cryptStats['Heroic Cycles'] = $row['value'];
            break;
        case 'edcod_necroticcycles':
            $cryptStats['Necrotic Cycles'] = $row['value'];
            break;
        case 'edcod_bosseskilled':
            $cryptStats['Bosses Killed'] = $row['value'];
            break;
        case 'edcod_monsterskilled':
            $cryptStats['Monsters Killed'] = $row['value'];
            break;
        case 'edcod_deaths':
            $cryptStats['Deaths'] = $row['value'];
            break;
        case 'edcod_completedonce':
            $dungeonCompleted = ($row['value'] == 1);
            break;
    }
}

$stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ethereal Lands - My Account</title>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="../script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        .account-stats {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            gap: 10px;
        }

        .stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .stat img {
            max-width: 50px;
            margin-bottom: 5px;
        }
    </style>
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
            <h1 class="page-header">Character Stats (<?php echo htmlspecialchars($username); ?>)</h1>
            <p class="page-info">View stats about your character below.</p>
        </div>
        <div class="account-stats">
            <?php foreach ($stats as $statName => $statValue): ?>
                <div class="stat">
                    <picture>
                        <source srcset="../icons/<?php echo htmlspecialchars($statName); ?>.webp" type="image/webp">
                        <source srcset="../icons/<?php echo htmlspecialchars($statName); ?>.png" type="image/png">
                        <img src="../icons/<?php echo htmlspecialchars($statName); ?>.png"
                            alt="<?php echo htmlspecialchars($statName); ?>">
                    </picture>
                    <p><?php echo htmlspecialchars($statValue); ?></p>
                </div>
            <?php endforeach; ?>
        </div>
        <div class="encounter-stats crypt-of-dread-box" id="crypt-of-dread">
            <div class="encounter-frame">
                <h2 class="dungeon-name crypt-of-dread">Crypt of Dread</h2>
                <div class="crypt-stats">
                    <?php foreach ($cryptStats as $label => $value): ?>
                        <div class="encounter-stat">
                            <span class="stat-label"><?php echo htmlspecialchars($label); ?>:</span>
                            <span class="stat-value"><?php echo htmlspecialchars($value); ?></span>
                        </div>
                    <?php endforeach; ?>

                    <?php if ($dungeonCompleted): ?>
                        <div class="encounter-stat">
                            <span class="stat-label">Dungeon Completed:</span>
                            <span class="stat-value">Yes</span>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>

</html>