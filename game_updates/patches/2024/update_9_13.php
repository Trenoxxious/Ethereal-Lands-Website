<?php
session_start();

$loggedIn = isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'];

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands</title>
    <link rel="stylesheet" href="../../../main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="../../../account/account.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="../../updatesstyles.css?ver=<?= time(); ?>">
    <script defer src="/script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"
        integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj"
        crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"
        integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN"
        crossorigin="anonymous"></script>
    <style>
        :root {
            --update-image: url('../../../images/CoD1080.png');
        }

        .update-window {
            background-image: 
                linear-gradient(to bottom, 
                rgba(0, 0, 0, 0) 0%,
                rgba(0, 0, 0, 0) 18%,
                rgba(0, 0, 0, 1) 25%),
                var(--update-image);
        }
    </style>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo" style="height: 100px;"></div>
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
    <div class="blanktop"></div>
    <div class="update-window">
        <div class="updatecontent" style="display: block;">
            <div class="title-area">
                <h1>Introducing: The Game Launcher, Instancing Systems, Raid Queue System</h1>
                <p class="update-info">09/13/2024 - Pre-release Update</p>
            </div>
            <p class="update-summary">We have implemented a system into Ethereal Lands that allows us to instance certain areas of the map so you can play solo or with a group of players through a dungeon or a raid without being impacted by other players and groups. We're also working on a "queueing" system, allowing you to queue up to complete a dungeon or raid with random players. We're super excited with how it's going so far, and during testing we found a few bugs which we've squashed with swift justice. In the coming weeks we'll be making improvements and sweeps over the system to make sure it won't negatively impact other gameplay areas, although in its current iteration, it doesn't seem to be affecting anything else at all, which is great news. We also have other updates coming this week, like remastering of quests and bringing back previous requirements that were stripped out until we've done this.</p>
            <h2>Systems & Other</h2>
            <p>A game launcher has been developed as a distributable file for installing and maintaining version updates at the client level. This is an early rendition of our game launcher and more features are planned for future versions. This will become available to install shortly before our Tutorial Island/Kani'ani Island testing phase.</p>
            <p>We're currently implementing and testing instanced areas on the DTE (developer test environment), which would allow us to create more robust experiences for players in dungeon and raid environments. This is a massive upgrade that will take time to properly test and implement, but I can confirm we do have working instancing, allowing players to run dungeons or raids without being impacted by other players in the same dungeon or raid. Players within an instanced area are only able to see their own party members and NPCs assigned to that instance ID. Over the coming weeks, the developer team will be testing these instancing features in Crypt of Dread and our first raid. We look forward to the feedback from the community on these systems once they're implemented and used.</p>
            <p>Pre-release Fixes: Players who are in a party can no longer create an instance unless they are the party leader. When joining an instance, it will first check for the party leaders created instances.</p>
            <p>We've designed a queue system for raids. When looking for a raid, if you don't have enough people in your current party, you can join the queue for a raid. When queueing, you will be prompted to select a role: Tank, Ranged DPS or Healer. Raids joined through the random queue requires 3 players, one of each role, and will have mechanics for all roles to fulfill during the encounter. Although not explicitly required, your raid will want to try and fill these roles for varying reasons if you are joining a raid with a pre-made party. Each raid boss will drop plenty of loot, with many drops enhancing your ability to perform well whilst inside a raid. The first raid you'll be able to join and queue for is the "King Black Dragon: The Eternal" raid, where we've redesigned the King Black Dragon into a fully-fledged raid boss that will drop epic raid-oriented loot.</p>
            <p>Queue System Notes: Currently, we're in the testing phase and ironing out any issues we find with the queueing system. We're also in the process of working out the finer details, such as entering the Wilderness whilst queued for a raid. Raids will be instanced content, allowing the queueing system to join all players in the queue into a party, teleport them into an instanced raid, and spawn the raid boss specifically for that instance of players and no one else. It is not currently possible to join a queue as a party of two players. This is on our list to be implemented in a future patch that should allow two players to queue together and be put into the same random group. Declining an invite for a raid will put you on a 2.5 minute cooldown from queueing for that specific raid again.</p>
            <p>Work has begun on an official debuff system, a visual look into the things affecting your character. This allows you to see your poisons, bleeds and other stat-affecting events on your character with additional information in the form of an icon that shows on the screen. When hovered, this icon should display information such as the debuff name and what the debuff does. This is very early in development and will take time to get fully implemented, but we currently have working debuffs for poisons, dragonfire burn and melee bleed events.</p>
            <p>With the above system implementations mentioned, we do plan on putting permanent dungeons in the game that require 3 players to complete. We should have an early implementation of such a dungeon once we have our first raid completed and released. We plan on making these similar to Ethereal Dungeons, but require specific levels to join and complete instead of being a scaled experience.</p>
            <h2>General Updates</h2>
            <p>We've begun production on loot and the landscape for the first raid.</p>
            <p>A missing reward from Crypt of Dread has been added to Thessalia's Clothes Shop recovery.</p>
            <p>Fixes have been applied to Wizard's Hat server-side.</p>
            <p>When cooking, fish that are considered "like-fish" are now grouped. We are currently grouping fish based on the pools they are fished from. For example, cooking Trout will now also check for any Salmon in the inventory and add that to your batch cooking and vice versa. This has been implemented for Trout/Salmon, Pike/Herring and Swordfish/Tuna. This is a QoL feature and also paves the way for planned systems we will implement in the future.</p>
            <p>When attacking creatures in Crypt of Dread (or any Ethereal Dungeon) the player who initiated the attack will now correctly be the one to attack. During internal testing we found an issue that caused the last player of a "party loop" to attack the monster during the mob scaling process, and not the player that initiated the attack. This has been fixed.</p>
            <p>The idle timer for logging players out after a period of inactivity has been adjusted. <span class="before">5 Minutes</span><span class="after">15 Minutes</span></p>
            <p>There are no longer griefing checks in Ethereal Dungeons as they are instanced content now and griefing is no longer an issue.</p>
            <p>To improve performance, monsters in Ethereal Dungeons will no longer check the party ID of a player for scaling as its use has been deprecated.</p>
            <p>Players will no longer continue to bleed when visiting bankers or after they die, as originally intended.</p>
            <p>The damage sprite for Air Damage has been adjusted.</p>
            <p>Players will now be prompted with a warning if they attempt to alchemize an item with a value of over 250,000 coins.</p>
            <p>A new daily challenge has been added for cremating remains.</p>
            <p>A new design is being made for the normal account dashboard for characters. Daily challenges, character stats, etc. will all be displayed on this single page. The admin panel will remain the same, and the account/character support page will be receiving an update as well in the near future.</p>
            <p>Prayer experience has been increased for burying regular bones and bat bones.</p>
            <p>Prayer experience has been increased for scattering regular ashes.</p>
            <p>Firemaking experience has been doubled when cremating remains. We want cremation to be a great way to train both firemaking and prayer outside of burying bones or burning logs. The amount of firemaking experience granted is based on the bone cremated.</p>
            <p>Quests that are not able to be started or completed in Ethereal Lands have been disabled and now reflect as such in the quest log.</p>
            <p>The overhead prayer icon for one of our newly introduced prayers has been designed and implemented. This new prayer also respects overhead bubbles.</p>
            <p>Players making wine now have a chance to instantly ferment the wine if it's considered perfect wine.</p>
            <p>Fermented wine makes a return, but will not rely on zone changes as previously implemented, and instead gametick events to ferment.</p>
            <p>Fermenting wine can now take place whilst deposited into the bank but now takes slightly longer to ferment than initially implemented.</p>
            <p>New sprites have been added for fire, water, earth and air magic. Spells will now respectively use these new sprites instead of the general blue star for magic attacks unless the magic attack is undefined. Ranged sprites are next on the to-do list, but will take much longer.</p>
            <p>The size of projectile sprites has been increased to 150% of their normal size.</p>
            <p>Damage types have been given to magic attacks and will now show fire, water, earth or air damage splats based on their respective spell type. This also means that these damage types are now categorized as these schools of damage.</p>
            <p>Clams have been added to the game and are a common-to-rare chance to gain when fishing. There are 'Clams', 'Hardened Clams' and 'Golden Clams' which provide rewards when opened. The rewards granted are based on the rarity of the clam. Opening a clam also gives a small amount of Fishing experience. These clams cannot be fished while on Kani'ani Island.</p>
            <p>Some items have been given a grammatical clarity sweep during the adjustments to wine mentioned above.</p>
            <p>Mine carts will now display a "Nothing interesting happens." message if attempting to use ore/gems on random mine carts in the world that isn't Frank's Mine Cart.</p>
            <p>Holy Shield will now correctly show it has been broken if the remaining shield amount is 0. A new sprite will be introduced for this specific niche-case scenario indicating that you have not taken damage, but the shield has been removed from damage.</p>
            <p>Holy Shield now dissolves after a short amount of time. <span class="before">Infinite</span><span class="after">~30 seconds</span></p>
            <p>When Holy Shield is applied to a player, it will now show the remaining shield amount on the player inside of a shield sprite. This is an entry-level implementation and will be improved in a future patch.</p>
            <p>Holy Shield was feeling very powerful, so it needed some adjustments. Holy Shield now dissipates after about 30 seconds. Also, players who have been shielded are not able to be shielded again for 15 seconds.</p>
            <p>The rune pane on the Magic interface now shortens runes over 1,000 to show 1K, 1M, 1B, etc.</p>
            <p>Additional sprites have been created and added to the game for consistency-sake.</p>
            <p>Server-sided rune names have been adjusted to remove the '-'s between them. Eg. <span class="before">Air-Rune</span><span class="after">Air Rune</span></p>
            <p>A lot of work has been done on a semi-secret game objective that must be discovered.</p>
            <p>The healing granted by foods has been reduced almost entirely across the board by a small margin of around 20-30% at the upper-end of the cooked fish range.</p>
            <p>The Lost City quest has been remastered.</p>
            <p>It is again a requirement to complete Lost City in order to equip the Dragon Sword.</p>
            <p>A new requirement has been introduced for Dragon (Battle) Axes that now requires the completion of Lost City in order to be equipped. The requirement for Hero's Quest has been lifted.</p>
            <p>The Dragon Slayer quest has been remastered.</p>
            <p>It is again a requirement to complete the Dragon Slayer quest in order to equip all Rune Platebody variants.</p>
            <p>A new requirement has been introduced for Dragon Square Shields that now requires the completion of the Dragon Slayer quest in order to be equipped. The requirement for Legend's Quest has been lifted.</p>
            <p>Grammatical sweeps have been made to the equipment/stat check messages sent to players on failed equip checks.</p>
        </div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>