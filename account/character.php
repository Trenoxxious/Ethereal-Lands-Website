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
$combat_level = $_SESSION['combat_level'];
$skill_total = $_SESSION['skill_total'];
$bounty_points = $_SESSION['bounty_points'];
$total_dailies_completed = $_SESSION['total_dailies_completed'];
$amount_of_souls = $_SESSION['amount_of_souls'];
$accstatus = $_SESSION['accstatus'];

// Fetch the latest amount of ethereal souls from the database
$amount_sql = "SELECT amount FROM etherealsouls WHERE id = ?";
$amount_stmt = $conn->prepare($amount_sql);
$amount_stmt->bind_param("i", $user_id);
$amount_stmt->execute();
$amount_result = $amount_stmt->get_result();

$formatted_souls = number_format($amount_of_souls);
$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;

$amount_stmt->close();

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

$sql = "SELECT attack, defense, hits, strength, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman FROM curstats WHERE playerID = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$curStats = [];

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $curStats = [
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
    'Total Completed Runs' => 0,
    'Normal Runs' => 0,
    'Heroic Runs' => 0,
    'Necrotic Runs' => 0,
    'Bosses Killed' => 0,
    'Monsters Killed' => 0,
    'Deaths' => 0
];

$dungeonCompleted = false;

while ($row = $result->fetch_assoc()) {
    switch ($row['key']) {
        case 'edcod_cyclestotal':
            $cryptStats['Total Completed Runs'] = $row['value'];
            break;
        case 'edcod_normalcycles':
            $cryptStats['Normal Runs'] = $row['value'];
            break;
        case 'edcod_heroiccycles':
            $cryptStats['Heroic Runs'] = $row['value'];
            break;
        case 'edcod_necroticcycles':
            $cryptStats['Necrotic Runs'] = $row['value'];
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
    <link rel="stylesheet" href="new_account.css?ver=<?= time(); ?>">
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
    <nav class="nav-bar">
        <div class="nav-start">
            <div class="logo"></div>
            <span class="greeting">Welcome, <?php echo htmlspecialchars($username); ?></span>
        </div>
        <div class="nav-end">
            <div class="nav-stats">
                <span class="stat-span">Total Level: <span class="stat-level"><?php echo htmlspecialchars($skill_total); ?></span></span>
                <span class="stat-span">Bounty Points: <span class="stat-level"><?php echo htmlspecialchars($bounty_points); ?></span></span>
                <span class="stat-span">Combat Level: <span class="stat-level"><?php echo htmlspecialchars($combat_level); ?></span></span>
                <span class="stat-span">Daily Challenges Completed: <span class="stat-level" id="total-dailies-completed"><?php echo htmlspecialchars($total_dailies_completed); ?></span></span>
                <span class="stat-span">Ethereal Souls: <span class="stat-level" id="ethereal-souls-amount"><?php echo htmlspecialchars($formatted_souls); ?></span></span>
            </div>
            <button id="logout-btn">Logout</button>
        </div>
    </nav>
    <div id="challenges-container" class="challenges-container">
        <form id="get-challenges-form" action="../scripts/get_daily_challenges.php" method="post">
            <h2>You've completed all your daily challenges! Check back soon for more!</h2>
        </form>
    </div>
    <!-- <div class="character-dialogue">
        <div class="selections">
            <span id="get-challenges" class="menu-selection">I need my daily challenges.</span>
            <span id="void-market" class="menu-selection">What's available in the Void Market?</span>
            <span id="support" class="menu-selection">I'm looking for character support.</span>
        </div>
    </div> -->
    <script>
        const logoutBtn = document.getElementById('logout-btn');

        if (logoutBtn) {
            logoutBtn.addEventListener("click", function () {
                window.open('../scripts/logout', '_self');
            });
        }
        
        $(document).ready(function() {
            function fetchChallenges() {
                $.ajax({
                    url: $('#get-challenges-form').attr('action'),
                    type: 'POST',
                    dataType: 'json',
                    success: function(response) {
                        if (response.success) {
                            displayChallenges(response.challenges);
                            if (response.message) {
                                alert(response.message);
                            }
                        } else {
                            alert(response.error || 'An error occurred while fetching challenges.');
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('AJAX error:', textStatus, errorThrown);
                        alert('An error occurred while fetching challenges. Please try again.');
                    }
                });
            }

            function displayChallenges(challenges) {
                let challengesHtml = '';
                if (challenges.length < 1) {
                    challengesHtml = '<h2>You\'ve completed all your daily challenges! Check back soon for more!</h2>';
                } else {
                    challenges.forEach(function(challenge) {
                        challengesHtml += `
                            <div class="challenge-box ${challenge.rarity.toLowerCase()}-border">
                                <h3 class="challenge-title ${challenge.rarity.toLowerCase()}">${challenge.title}</h3>
                                <p>${challenge.rarity} Challenge</p>
                                <p class="challenge-info">${challenge.mission}</p>
                                <p id="progress-${challenge.id}" class="challenge-stats">Loading progress...</p>
                                <p class="challenge-reward">Reward: ${challenge.reward_amount}<img src="../images/soul.png" alt="Souls"></p>
                                <form id="complete-challenge-form-${challenge.id}" class="complete-challenge-form" method="post">
                                    <input type="hidden" name="challenge_id" value="${challenge.id}">
                                    <button id="claim-button-${challenge.id}" type="submit" class="challenge-button" disabled>Complete Challenge</button>
                                </form>
                            </div>
                        `;
                    });

                    $('#challenges-container').html(challengesHtml);
                }
            }

            // Fetch challenges on page load
            fetchChallenges();

            // Handle form submission
            $('#get-challenges-form').on('submit', function(e) {
                e.preventDefault();
                fetchChallenges();
            });
        });
    </script>
</body>

</html>