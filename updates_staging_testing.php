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
            <div class="logo" id="toplogo" style="height: 100px;">
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
            <h2>Systems & Other</h2>
            <p>A game launcher has been developed as a distributible file for installing and maintaining version updates at the client level. This is an early rendition of our game launcher and more features are planned for future versions.</p>
            <p>We're currently implementing and testing instanced areas on the DTE (developer test environment), which would allow us to create more robust experiences for players in dungeon and raid environments. This is a massive upgrade that will take time to properly test and implement, but I can confirm we do have working instancing, allowing players to run dungeons or raids without being impacted by other players in the same dungeon or raid. Players within an instanced area are only able to see their own party members and NPCs assigned to that instance ID. Over the coming weeks, the developer team will be testing these instancing features in Crypt of Dread and our first raid that is yet to be announced. We look forward to the feedback from the community on these systems once they're implemented and used.</p>
            <p>Pre-release Fixes: Players who are in a party can no longer create an instance unless they are the party leader. When joining an instance, it will first check for the party leaders created instances.</p>
            <h2>General Updates</h2>
            <p>When attacking creatures in Crypt of Dread (or any Ethereal Dungeon) the player who initiated the attack will now correctly be the one to attack.
            <p>A new daily challenge has been added for cremating remains.</p>
            <p>A new design is being made for the normal account dashboard for characters. Daily challenges, character stats, etc. will all be displayed on this single page. The admin panel will remain the same, and the account/character support page will be receiving an update as well in the near future.</p>
            <p>Prayer experience has been increased for burying regular bones and bat bones.</p>
            <p>Prayer experience has been increased for scattering regular ashes.</p>
            <p>Firemaking experience has been doubled when cremating remains. We want cremation to be a great way to train prayer outside of burying bones, scattering ashes or shattering souls.</p>
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
            <p>Holy Shield now dissolves after a short amount of time. <span class="before">Infinite</span><span class="aft">~30 seconds</span></p>
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