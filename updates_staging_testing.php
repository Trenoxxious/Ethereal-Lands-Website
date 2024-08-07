<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Updates</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account/account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <div id="navlinks">
                <a href="https://playethereallands.com">Home</a>
                <a href="creators_corridor">Creator's Corridor</a>
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
            <a class="button-main" href="creators_corridor">Creator's Corridor</a>
            <a class="button-main" href="https://discord.gg/d6RtsDyRZX">Discord</a>
        </div>
    </div>
    <div class="blanktop"></div>
    <a href="/game_updates/kaniani_island">
        <div class="mainupdate">
            <img src="images/updates/mainupdate_tutisland.png" alt="Explore a new, packed tutorial island!"
                style="width: 100%; height: 100%; object-fit: contain;">
        </div>
    </a>
    <div class="updatelist">
        <div class="updatebox">
            <div class="updatecontent">
                <h2>General Changes</h2>
                <p>Melee accuracy has been altered slightly to make fighting without a shield a little more dangerous. Players are also slightly more likely to land an attack on monsters/bosses.</p>
                <p>Players are now able to block attacks as long as they are normal melee attacks. The block chance of the shield depends on a block chance factor built directly into the shield itself. This is notated on the shield in its examine box.</p>
                <p>The skill guide for Magic has been updated to include all of the new friendly spells.</p>
                <p>The spell interface has been updated to show correct information for friendly spells.</p>
                <p>Friendly spells will now show up at the bottom of the magic panel to allow for easier casting of friendly spells and to limit scrolling as much as possible when looking for a different friendly spell. This is just a temporary quality of life change we're implementing before entirely re-designing the magic and prayer interfaces sometime after launch.</p>
                <p>Dragon Sword and Dragon 2H Sword specials have been updated respectively: <span class="before">20%/25% Bonus Damage</span><span class="aft">40%/60% Bonus Damage</span></p>
                <h2>Website</h2>
                <p>Admins now have the ability to find the registered email of the user to address inquiries/tickets for support. This will eventually be worked into a full ticketing system accessible to character on the support page, which is expected to be done prior to launch.</p>
                <p>The player support form has been widened a bit and fixed on mobile displays.</p>
                <p>Images on my main page have been updated to not include a player character and be pixel-perfect upscales to 1080p resolution. These will be tweaked over time and ready before release.</p>
            </div>
        </div>
    </div>
    <?php include 'footer.php'; ?>
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