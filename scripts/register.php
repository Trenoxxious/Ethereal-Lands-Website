<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/home/playethe/public_html/error.log');

header('Content-Type: application/json');

require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    $email = $_POST['email'];

    // Validate username
    if (!preg_match("/^[A-Za-z0-9 ]{2,12}$/", $username)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid username. It should only contain letters, numbers, or spaces, and be between 2 and 12 characters long.']);
        exit;
    }

    // Check if username contains "Mod" or "Admin" (case-insensitive)
    if (stripos($username, 'mod') !== false || stripos($username, 'admin') !== false) {
        echo json_encode(['status' => 'error', 'message' => 'Username cannot contain "Mod" or "Admin".']);
        exit;
    }

    // Validate password length
    if (strlen($password) > 20) {
        echo json_encode(['status' => 'error', 'message' => 'Password should not be more than 20 characters in length.']);
        exit;
    }

    if (strlen($password) < 4) {
        echo json_encode(['status' => 'error', 'message' => 'Password needs to be at least 4 characters in length.']);
        exit;
    }

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email address entered.']);
        exit;
    }

    // Check if username already exists (non-case-sensitive)
    $stmt = $conn->prepare("SELECT COUNT(*) FROM players WHERE LOWER(username) = LOWER(?)");
    if (!$stmt) {
        echo json_encode(['status' => 'error', 'message' => "Prepare failed (SELECT): " . $conn->error]);
        exit;
    }
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()) {
        echo json_encode(['status' => 'error', 'message' => "Execute failed (SELECT): " . $stmt->error]);
        exit;
    }
    $stmt->bind_result($count);
    $stmt->fetch();
    $stmt->close();

    if ($count > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Username is already taken.']);
        exit;
    }

    // Hash the password using bcrypt
    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

    // Start a transaction
    $conn->begin_transaction();

    try {
        // Insert into players table
        $stmt = $conn->prepare("INSERT INTO players (username, group_id, email, pass, salt, combat, skill_total, x, y, fatigue, combatstyle, block_chat, block_private, block_trade, block_duel, cameraauto, onemouse, soundoff, haircolour, topcolour, trousercolour, skincolour, headsprite, bodysprite, male, creation_date, creation_ip, login_date, login_ip, banned, offences, muted, kills, npc_kills, deaths, online, quest_points, lastRecoveryTryId, transfer, bounty_set_amount, bounty_kill_count, bounty_item_id, bounty_points, current_bounty) VALUES (?, 10, ?, ?, '', 3, 27, 311, 902, 0, 0, 0, 0, 0, 0, 1, 0, 0, 2, 8, 14, 0, 1, 2, 1, UNIX_TIMESTAMP(), ?, 0, '0.0.0.0', 0, 0, 0, 0, 0, 0, 0, NULL, NULL, NULL, 0, 0, 0, 0, 0)");
        if (!$stmt) {
            throw new Exception("Prepare failed (INSERT into players): " . $conn->error);
        }
        $stmt->bind_param("ssss", $username, $email, $hashedPassword, $_SERVER['REMOTE_ADDR']);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (INSERT into players): " . $stmt->error);
        }
        $playerID = $stmt->insert_id;
        $stmt->close();

        // Insert into curstats table
        $stmt = $conn->prepare("INSERT INTO curstats (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 1, 1, 1, 10, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)");
        if (!$stmt) {
            throw new Exception("Prepare failed (INSERT into curstats): " . $conn->error);
        }
        $stmt->bind_param("i", $playerID);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (INSERT into curstats): " . $stmt->error);
        }
        $stmt->close();

        // Insert into experience table
        $stmt = $conn->prepare("INSERT INTO experience (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 0, 0, 0, 4000, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0, 0)");
        if (!$stmt) {
            throw new Exception("Prepare failed (INSERT into experience): " . $conn->error);
        }
        $stmt->bind_param("i", $playerID);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (INSERT into experience): " . $stmt->error);
        }
        $stmt->close();

        // Insert into maxstats table
        $stmt = $conn->prepare("INSERT INTO maxstats (playerID, attack, defense, strength, hits, ranged, prayer, magic, cooking, woodcut, fletching, fishing, firemaking, crafting, smithing, mining, herblaw, agility, thieving, huntsman) VALUES (?, 1, 1, 1, 10, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1, 1)");
        if (!$stmt) {
            throw new Exception("Prepare failed (INSERT into maxstats): " . $conn->error);
        }
        $stmt->bind_param("i", $playerID);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (INSERT into maxstats): " . $stmt->error);
        }
        $stmt->close();

        // Insert into etherealsouls table
        $stmt = $conn->prepare("INSERT INTO etherealsouls (id, amount) VALUES (?, 0)");
        if (!$stmt) {
            throw new Exception("Prepare failed (INSERT into etherealsouls): " . $conn->error);
        }
        $stmt->bind_param("i", $playerID);
        if (!$stmt->execute()) {
            throw new Exception("Execute failed (INSERT into etherealsouls): " . $stmt->error);
        }
        $stmt->close();

        // Commit transaction
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => "New character created successfully! We'll see you soon!"]);
        // Send an email to the player using their email
        $to = $email;
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: noreply@playethereallands.com' . "\r\n" .
            'Reply-To: support@playethereallands.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $subject = 'Welcome to Ethereal Lands, ' . $username . '!';
        $message = "
        <html>

        <head>
            <title>Welcome to Ethereal Lands!</title>
            <style>
                @import url('https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap');

                /* CSS styles go here */
                body {
                    font-family: Roboto, sans-serif;
                    background-color: #303030;
                    background-size: 1920px;
                    background-position: center;
                }

                .container {
                    flex-direction: column;
                    max-width: 600px;
                    margin: 0 auto;
                    background-color: rgba(0, 0, 0, 0.5);
                    padding: 20px;
                    border-radius: 5px;
                    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.5);
                    overflow: hidden;
                }

                h1 {
                    color: #ffffff;
                    font-size: 1.75em;
                    text-align: center !important;
                }

                h2 {
                    color: rgb(255, 205, 98);
                    font-size: 1.5em;
                }

                span {
                    color: rgb(255, 205, 98);
                }

                .container img {
                    display: block;
                    margin-left: auto;
                    margin-right: auto;
                    max-width: 75%;
                    min-width: 45%;
                    max-height: 75%;
                    min-height: 45%;
                    margin-top: -100px;
                    margin-bottom: -125px;
                }

                p {
                    color: #f8f8f8;
                    line-height: 1.5;
                    font-size: 0.9em;
                }

                a {
                    text-decoration: none;
                    color: rgb(255, 205, 98);
                }
            </style>
        </head>

        <body>
            <div class='container'>
                <img src=\"https://playethereallands.com/images/LogoTransparent1000Plain.png\" alt=\"Ethereal Lands Logo\">
                <h1>Welcome to Ethereal Lands!</h1>
                <p>Thank you for registering for Ethereal Lands, <span>$username</span>! We are excited to get you in-game as
                    soon as
                    possible. Check back consistently for game updates and news on a release date!</p>
                <p>We also recommend joining us on <a href=\"https://discord.gg/d6RtsDyRZX\">Discord</a>! Find information on our
                    website for our Discord server.</p>
                <h2>Tutorial Island Testing Schedule</h2>
                <p>We plan to open up Ethereal Lands for Tutorial Island testing soon. Oh yeah, it's not the normal tutorial
                    island. It's a brand new tutorial island, built from the ground up, called <b>Kani'ani Island</b>! Kani'ani
                    Island features a big quest
                    utilizing almost every skill, including the new <b>Huntsman</b> skill. There's a lot to uncover and learn
                    during this upcoming test. We'll let you know when it's ready!</p>
                <p>See below for some features you may have missed about Ethereal Lands.</p>
                <h2>Daily Challenge System</h2>
                <p>Feel free to log into the website and have a poke around! We have a daily challenge system and cosmetic store
                    that sees constant updates. You are able to claim 3 random daily challenges each day, with random rarities
                    and Ethereal Soul reward amounts. Are you lucky enough to receive 3 Artifact challenges on the same day?</p>
                <p>Don't worry though, all paid cosmetics can be earned at a reasonable rate through the
                    daily challenge system, allowing anyone to enjoy the cosmetics created by the team and the community.
                    Speaking of community...</p>
                <h2>Creator's Corridor</h2>
                <p>Check out Creator's Corridor, where our community creates and submits creations for Ethereal Lands. If you're
                    a creator, consider submitting for rewards! <a href=\"https://playethereallands.com/creatorscorridor\">Learn
                        more about Creator's Corridor here.</a>
                </p>
            </div>
        </body>

        </html>
        ";
        mail($to, $subject, $message, $headers);
    } catch (Exception $e) {
        $conn->rollback();
        error_log($e->getMessage());
        echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
    }
}

$conn->close();