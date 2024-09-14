<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Error 500</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account/account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo" style="height: 100px;">
            </div>
            <div id="navlinks">
                <a href="https://playethereallands.com">Home</a>
                <a href="recent_updates">Game Updates</a>
                <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
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
    <div class="creatorscorridorintro">
        <h1>Error: 500</h1>
        <p>You'll need to complete the "Becoming An Administrator" quest before accessing this page.</p>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>