<!DOCTYPE html>
<html lang="en">

<head>
    <title>Ethereal Lands - My Account</title>
    <meta charset="UTF-8" name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="new_account.css">
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
            <span class="greeting">Welcome, Noxxious</span>
        </div>
        <div class="nav-end">
            <div class="nav-stats">
                <span class="stat-span">Total Level: <span class="stat-level">944</span></span>
                <span class="stat-span">Bounty Points: <span class="stat-level">38</span></span>
                <span class="stat-span">Quests Completed: <span class="stat-level">4</span></span>
                <span class="stat-span">Daily Challenges Completed: <span class="stat-level">20</span></span>
            </div>
            <button id="logout-btn">Logout</button>
        </div>
    </nav>
    <div class="daily-challenges-container" id="daily-challenges-container">
        <?php if ($player['has_accepted_daily_challenges'] == 0): ?>
            <form method="post" action="../scripts/get_daily_challenges.php">
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
                    <p id="progress-<?php echo $accepted['id']; ?>" class="challenge-stats">
                        <?php echo htmlspecialchars($accepted['value']); ?> /
                        <?php echo htmlspecialchars($accepted['fulfillment_amount']); ?>
                    </p>
                    <p class="challenge-stats-reward">Reward: <?php echo htmlspecialchars($accepted['reward_amount']); ?><img src="../images/soul.png" alt="Souls"></p>
                    <form id="complete-challenge-form-<?php echo $accepted['id']; ?>" class="complete-challenge-form"
                        method="post">
                        <input type="hidden" name="challenge_id" value="<?php echo $accepted['id']; ?>">
                        <button id="claim-button-<?php echo $accepted['id']; ?>" type="submit" class="button-main" <?php echo ($accepted['value'] < $accepted['fulfillment_amount']) ? 'disabled' : ''; ?>>Claim Souls</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
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
    </script>
    <script>
    $(document).ready(function() {
        $('#get-challenges').on('click', function(e) {
            e.preventDefault();
            $.ajax({
                url: '../scripts/get_daily_challenges.php',
                type: 'POST',
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        let challengesHtml = '';
                        response.challenges.forEach(function(challenge) {
                            challengesHtml += `
                                <div class="store-item ${challenge.rarity.toLowerCase()}-border">
                                    <h3>${challenge.title}</h3>
                                    <p class="${challenge.rarity.toLowerCase()}-background">
                                        ${challenge.rarity} Challenge
                                    </p>
                                    <p class="challenge-info">${challenge.mission}</p>
                                    <p id="progress-${challenge.id}" class="challenge-stats">
                                        0 / ${challenge.fulfillment_amount}
                                    </p>
                                    <p class="challenge-stats-reward">Reward: ${challenge.reward_amount}<img src="../images/soul.png" alt="Souls"></p>
                                    <form id="complete-challenge-form-${challenge.id}" class="complete-challenge-form" method="post">
                                        <input type="hidden" name="challenge_id" value="${challenge.id}">
                                        <button id="claim-button-${challenge.id}" type="submit" class="button-main" disabled>Claim Souls</button>
                                    </form>
                                </div>
                            `;
                        });
                        $('#daily-challenges-container').html(challengesHtml);
                    } else {
                        alert(response.error);
                    }
                },
                error: function() {
                    alert('An error occurred while fetching challenges.');
                }
            });
        });
    });
    </script>
</body>

</html>