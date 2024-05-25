<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Updates</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <div id="navlinks">
                <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
                <a href="index">Home</a>
            </div>
            <div id="menuexpand">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenu">
            <a href="index">Home</a>
            <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
        </div>
    </div>
    <div class="blanktop"></div>
    <div class="updatelist">
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/LumbridgeBG.png" alt="update image"></div>
                <div class="updatebartop">
                    <div class="updatetitle">Website & Database Upgrades</div>
                    <div class="patchnumber">Website Update | Database Update</div>
                    <p class="updatesummary">This update focuses on website and database upgrades in order to prepare
                        for the release of the game.</p>
                </div>
            </div>
            <div class="updatecontent">
                <h2>Website Updates</h2>
                <p>This updates page has been heavily redesigned to meet the same quality as the other pages.</p>
                <p>Website has been visually redesigned.</p>
                <p>The website has been updated to support player logins.</p>
                <p>The cosmetics store has been designed and is ready for when the game releases. Cosmetics will be able
                    to be earned entirely in-game by utilizing the website's daily task system to earn Ethereal Souls or
                    by purchasing Ethereal Souls directly.
                    The tasks are completed in-game by the character you login with. Currently, the store is disabled
                    but fully functional. Next, we're working on adding an inventory system to manage your purchases
                    and, eventually, purchasing Ethereal Souls using real currency.
                </p>
                <h2>Database Updates</h2>
                <p>Database has been upgraded/migrated to MySQL to support web-server database hosting, player logins
                    and server hosting.</p>
                <p>Several database upgrades have been made to support cosmetic item purchases and equipping.</p>
                <h2>Server Updates</h2>
                <p>The server has been updated to check for duplicate item_id's before processing and saving player
                    data. This has been updated to support cosmetic item delivery.</p>
                <p>We've made some adjustments to logging that will disable logging .txt files for WARN and INFO
                    messages while the game server is running.</p>
            </div>
        </div>
    </div>
    <script>
        document.querySelectorAll('.updatebox').forEach((updatebox) => {
            updatebox.addEventListener('click', () => {
                const updatecontent = updatebox.querySelector('.updatecontent');
                if (updatecontent.style.display === 'block') {
                    updatecontent.style.display = 'none';
                } else {
                    updatecontent.style.display = 'block';
                }
            });
        });
    </script>
</body>

</html>