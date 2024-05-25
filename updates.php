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
                <div class="updateimage"><img src="images/pic4.png" alt="update image"></div>
                <div class="updatebartop">
                    <div class="updatetitle">Cosmetic Crates & Crypt of Dread</div>
                    <div class="patchnumber">Patch 1.0.3</div>
                    <p class="updatesummary">We've made some updates to cosmetic crates and progress on our first
                        Ethereal Dungeon, Crypt of Dread.</p>
                </div>
            </div>
            <div class="updatecontent">
                <h2>General</h2>
                <p>We've adjusted cosmetic crates so they can be sent to the bank by using the "Send to Bank" option on
                    them.</p>
                <p>We've added batch-opening of cosmetic crates to our to-do list. We expect this to take a little bit
                    of time as it's not a primary focus at this time.</p>
                <p>Frank's Mine Medium and Hard tasks have been completed and implemented with their respective rewards.
                </p>
                <p>The King Black Dragon spawn has been removed and is awaiting a complete redesign and relocation.
                    Along with its redesign, it will have a rare chance to drop a new, powerful artifact item! Stay
                    tuned for further information!</p>
                <h2>Adjustments</h2>
                <p>Cremation experience rates for Prayer and Firemaking have been reduced. We thought the experience
                    rates were a little <i>too</i> good, so we've brought them down. This is still a very viable
                    training method as you'll earn more prayer experience than simply buryig a bone.</p>
                <p>Shattering a bounty soul now gives 1 bounty point as well as Prayer experience.</p>
                <p>The Raptor now assigns bounties correctly. Previously, he only assigned Demon Pirate bounties.</p>
                <h2>Ethereal Dungeons: Crypt of Dread</h2>
                <p>Crypt of Dread has been started visually, leveraging the current landscape for the entrance
                    portal with slight modifications to the map.</p>
                <p>Several milestones have been met implementing scaling monsters. They will scale based on combat
                    level when engaged.</p>
                <p>Anti-griefing measures have been implemented so mobs do not get repeatedly stolen or reset. The
                    information around how this works will be kept secret for obvious reasons.</p>
                <p>The rewards that are obtainable from Crypt of Dread have been fully designed, are functional and
                    ready for release.</p>
            </div>
        </div>
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
                <p>The server has been updated to check for duplicate itemID's before processing and saving player
                    data. This has been updated to support cosmetic item delivery from the website inventory.</p>
                <p>We've made some adjustments to logging that will disable logging .txt files for WARN and INFO
                    messages while the game server is running. While these events are pretty rare, we only need to log
                    error and debug events.</p>
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