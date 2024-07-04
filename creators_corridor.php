<?php
session_start();

$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Creator's Corridor</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <div id="navlinks">
                <a href="index">Home</a>
                <a href="updates">Game Updates</a>
                <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
            </div>
            <div class="button-div">
                <?php if ($loggedIn): ?>
                    <button class="button-main" id="accountbutton">
                        My Account
                    </button>
                <?php else: ?>
                    <button class="button-main" id="accountbutton">
                        Login
                    </button>
                <?php endif; ?>
            </div>
            <div id="menuexpand">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenu">
            <div id="menuclose">
                <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px"
                    fill="#FFFFFF">
                    <path d="M673-446.67H160v-66.66h513l-240-240L480-800l320 320-320 320-47-46.67 240-240Z" />
                </svg>
            </div>
            <a class="button-main" href="index.php">Home</a>
            <a class="button-main" href="updates.php">Game Updates</a>
            <a class="button-main" href="https://discord.gg/d6RtsDyRZX">Discord</a>
        </div>
    </div>
    <div class="creatorscorridorintro">
        <h1>Introducing Creator's Corridor</h1>
        <p>The Creator's Corridor focuses on providing resources for our community to create awesome items to be
            implemented into Ethereal Lands. Not only will your name be forever-ingrained into the examine text of the
            item (for cosmetics), but you'll be rewarded for your creation!</p>
        <div class="creation-section">
            <p>We'll be looking for (<i>but not requiring</i>) many creations from the community. We expect the interest
                in this program to be fairly low, so we'll continue creating to cover any gaps regardless.
            </p>
            <p>Rewards can be distributed in various forms, and the reward will be determined based on the current
                economy of paid or in-game cosmetics, depending on the type of creation you make and where it ends up.
                There may be months, or even longer, where we don't choose or approve a creation to be implemented. Your
                creation is yours until it's chosen.
            </p>
        </div>
        <div class="qabox">
            <p class="question">Where will my creation end up?</p>
            <p class="answer">There are several things to create, from monsters to inventory icons. For instance, if
                you create an inventory icon only, it may be used in a quest. If you create a piece of equipment, it
                could end up in the Cosmetic Crate for the next year. Monsters may be used in an Ethereal Dungeon or be
                a permanent addition.</p>
        </div>
        <div class="qabox">
            <p class="question">Do I choose the rarity of my creation?</p>
            <p class="answer">In short, no. You can suggest a rarity for your creation, but it's not a guarantee
                that it will land in that category. If you want a high chance for your item to land in a rarer category,
                higher effort, quality and creativity will increase your chances. Also, making your creation stand out
                among the crowd will increase your chances as well.</p>
        </div>
        <div class="qabox">
            <p class="question">Can I create multiple things? Equipment, monsters, etc.?</p>
            <p class="answer">Absolutely! We recommend creating as many items as you can! The more you create, the
                higher
                your chances of being accepted are!</p>
        </div>
        <div class="qabox">
            <p class="question">Where do I submit my creation?</p>
            <p class="answer">We'll cover this in another section, but all creations will be submitted on Discord under
                the
                Creation Corridor channel.</p>
        </div>
        <div class="qabox">
            <p class="question">Will I be notified if my creation is chosen?</p>
            <p class="answer">Yes, you will be notified via Discord if your creation is chosen to be implemented. You
                will
                need to respond to this notification before your creation is implemented.</p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>