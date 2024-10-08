<?php
session_start();

$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Updates</title>
    <link rel="stylesheet" href="../main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="../account.css?ver=<?= time(); ?>">
    <script defer src="../script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css"
        integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js"
        integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+"
        crossorigin="anonymous"></script>
</head>

<body>
    <style>
        body {
            background: black;
            background-position: center;
            background-size: cover;
            background-repeat: no-repeat;
            background-image: url(../images/pic1.png);
        }

        .carousel-inner {
            border-top-left-radius: 0.5em;
            border-top-right-radius: 0.5em;
            box-shadow: 0px 0px 10px black;
        }
    </style>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo" style="height: 100px;">
            </div>
            <div id="navlinks">
                <a href="https://playethereallands.com">Home</a>
                <a href="recent_updates">Game Updates</a>
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
            <a class="button-main" href="https://playethereallands.com">Home</a>
            <a class="button-main" href="recent_updates">Game Updates</a>
            <a class="button-main" href="https://discord.gg/d6RtsDyRZX">Discord</a>
        </div>
    </div>
    <div class="mainupdateintro">
        <h1>Explore the NEW Kani'ani Island!</h1>
        <p>
            Kani'ani Island's design was to get players right into the new changes we've made to the
            Runescape Classic experience.</p>
        <p>
            Not only will you be embarking on a quest right from character creation, you'll be utilizing all
            skills in a similar fashion that you would in the open world. Use agility to navigate through various parts
            of the island. Mine and smith a full set of bronze armor and weapons to use on your foes while completing
            new, on-island Huntsman bounties.
        </p>
        <p>
            Kani'ani Island is just the first step we've taken to reshape the world of Gielinor, and hopefully you'll
            find yourself pleasantly immersed in this new, sundered world...
            Don't be sad when you leave, though! You can always
            come back to Kani'ani Island, and you may find yourself doing so in the later Huntsman leveling experience
            to visit dungeons that have more fearsome monsters than found on the surface dungeon.
        </p>
        <p class="important"><i>Note: New players will be restricted from trading, dueling and using World chat until
                the tutorial has been completed.</i>
        </p>
    </div>
    <div class="center-slide">
        <div class="slide-content-mainupdate">
            <h1>Utilize Most Skills</h1>
            <p>On the island, you'll find yourself using the following skills to complete your quest: Agility, Thieving, Huntsman,
                Combat, Woodcutting, Herblore, Fletching, Fishing,
                Cooking and Crafting! The usage of these skills isn't implemented in an "introductory" way; you'll
                actually use these skills to complete your quest, and give some background on how they may be used once
                you reach the mainland!
            </p>
            <p>
                The tutorial, or introductory quest, is also new-player friendly. We know that most players will be
                versed in navigating Gielinor and its many skills, but we want to make sure that if you bring your
                friends, they can jump in and immediately learn the vast amount of skills the game has to offer.
            </p>
        </div>
    </div>
    <div class="container d-flex justify-content-md-center w-100">
        <div id="carouselIndicators" class="carousel slide" data-ride="carousel">
            <ol class="carousel-indicators">
                <li data-target="#carouselIndicators" data-slide-to="0" class="active"></li>
                <li data-target="#carouselIndicators" data-slide-to="1"></li>
                <!-- Add more indicators for additional slides -->
            </ol>
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../images/graveyards.png" class="d-block w-100" alt="Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../images/pic8.png" class="d-block w-100" alt="Image 2">
                </div>
                <!-- Add more carousel items for additional slides -->
            </div>
            <a class="carousel-control-prev" href="#carouselIndicators" role="button" data-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselIndicators" role="button" data-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="sr-only">Next</span>
            </a>
        </div>
    </div>
    <div class="center-slide">
        <div class="slide-content-mainupdate">
            <h1>Two Connected Islands</h1>
            <p>Kani'ani Island is actually two islands, connected by an underground network of dungeons. Over time, this
                network will expand, creating a massive tutorial island with new things to try and learn before you
                leave to the mainland, and create new reasons to return and explore! <i>The lava has been settling on
                    the island lately...</i>
            </p>
        </div>
    </div>
    <div class="center-slide">
        <div class="slide-content-mainupdate">
            <h1>Reputation Rewards</h1>
            <p>Upon finishing the Kani'ani Island quest, you'll likely run into tasks and reputation. Kani'ani Island
                has some tasks you can complete to earn reputation before you leave the island, unlocking powerful
                rewards you can take with you and use forever! Below are the rewards you can earn.
            </p>
            <br>
            <b class="important">Double Bonus Huntsman XP on Kills (250 Reputation)</b>
            <b class="important">Iron Smelting Success Chance Increase (500 Reputation)</b>
            <b class="important">Pick'n'axe Blueprint (1000 Reputation)</b>
        </div>
    </div>
    <div class="center-slide">
        <div class="slide-content-mainupdate">
            <h1>Endless Adventure</h1>
            <p>We're taking a new approach to tutorial areas. New Gielinor evolves, and that won't stop at Kani'ani
                Island. We'll be constantly adding new content and dungeons, with some being accessible via Kani'ani
                Island at low and high levels of gameplay.</p>
            <p>It is also entirely possible to level all skills to maximum without leaving the island. It would take an
                eternity, but it's possible! Doing so may net you a special reward or two...
            </p>
        </div>
    </div>
    <div class="slide-fade"></div>
    <script>
        $(document).ready(function () {
            $('.carousel').carousel();
        });
    </script>
    <?php include 'footer.php'; ?>
</body>

</html>