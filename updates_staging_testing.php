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
                <h2>General Updates</h2>
                <p>Melee accuracy has been altered very slightly to make fighting without a shield a little more dangerous.</p>
                <p>Players are now able to block attacks as long as they are normal melee attacks. The block chance of the shield depends on a block chance factor built directly into the shield itself. This is notated on the shield in its examine box. You are only able to block attacks that would have otherwise dealt damage.</p>
                <p>The skill guide for Magic has been updated to include all of the new friendly spells.</p>
                <p>The spell interface has been updated to show correct information for friendly spells.</p>
                <p>Friendly spells will now show up at the bottom of the magic panel to allow for easier casting of friendly spells and to limit scrolling as much as possible when looking for a different friendly spell. This is just a temporary quality of life change we're implementing before entirely re-designing the magic and prayer interfaces sometime after launch.</p>
                <p>Dragon Sword and Dragon 2H Sword specials have been updated respectively: <span class="before">20%/25% Bonus Damage</span><span class="aft">40%/60% Bonus Damage</span></p>
                <p>Fixes to "Helping the Winchesters" have been applied.</p>
                <p>Sam W. and Dean W. have had their looks adjusted to best suit them.</p>
                <p>Lumbridge has been given a slight modification in landscape to account for Del'araz's siege on New Gielinor.</p>
                <p>Zombies have been added to the Lumbridge courtyard for the "Helping the Winchesters" quest.</p>
                <p>The new "Cook's Wares" quest now requires The Restless Ghost to be completed and the Amulet of Ghostspeak.</p>
                <p>Quest names across the board have been adjusted for grammatical clarity.</p>
                <p>A weapon special attack is being tested for the Dragon Battle Axe and a newly added Bleed Event. The bleed damage dealt by Dragon Battle Axe will depend on the damage dealt to initiate the rend. This bleed event is a newly added and more customizable gametick event that should allow us to set variables for damage type, etc. Eg. a player being set ablaze from a Dragon to take dragonfire damage over time.</p>
                <p>The main game UI, Magic, Prayer, Quest Guide, Inventory and Equipment panels have undergone dark-mode adjustments to closely match the right-click menu style.</p>
                <p>Large stackable items in the inventory (and runes in the Magic pane) will now have their large numbers formatted. Instead of showing 124000 coins, you will now see 124K in green. If over a million, it will be denoted with an "M" in blue, and B in purple if over a billion. Max cash will show as 2.147B. Coins over this amount create a new entry in the bank for coins, allowing you to carry multiple stacks of coins.</p>
                <p>Weapon Special Attack rolls have been altered to be more efficient performance-wise on the server.</p>
                <p>The "Dragonfire" and "Bleed" damage types have been added.</p>
                <p>A new potion, Dragonfire Resistance Potion, has been added to the game.</p>
                <p>A new potion, Void Resistance Potion, has been added to the game.</p>
                <p>These new potions have been given herblaw recipes that will be hidden on game release. A new third potion is being developed that will not have any more mentions or hints as to what it is, what the recipe is, etc.</p>
                <p>A new potion protection/resistance event has been implemented to check for resistances against certain damage types.</p>
                <p>A few monsters have been given new special attacks that these potions will help protect against. This will be expanded in the future after this initial testing phase is completed. So far everything is feeling great.</p>
                <p>The bank now uses the new formatting of all large numbers and is consistent across various UI types.</p>
                <p>The inital breath of a dragon's fire is now appropriately handled based on the potion used and the dragon's breath strength.</p>
                <p>Arnold P. Almer now has an icon over his head denoting that he is a helpful NPC to answer questions.</p>
                <p>Arnold P. Almer has been spawned in more locations to help new players.</p>
                <p>The icon for "Iron Flour" has been adjusted.</p>
                <p>The item ID for "Iron Flour" has been corrected and now works correctly with its respective quest.</p>
                <p>Prayer drain has been adjusted slightly for a few prayers.</p>
                <p>The Auction House has been updated to handle amounts over 99,999,999 (99.99m) gold. It can now handle listings correctly up to 2.147B gold.</p>
                <p>The Auction House posting and pricing has been improved to detect max cash stacks.</p>
                <p>Platinum Tokens have been added. You may talk to a banker to exchange 1 billion Coins for 1 Platinum Token. You can swap the Platinum Tokens back to Coins by using the tokens on any banker or auctioneer.</p>
                <p>Items that have a base sell price of 0 (0gp) are no longer able to be sold to general stores. The UI for shops has been updated to reflect this change.</p>
                <p>The start-up client size and minimum client size has been doubled in height and lengthened in width.</p>
                <p>The welcome screen of the client has been adjusted to show the world in fullscreen instead of a half-faded screen.</p>
                <p>Fixed an issue that prevented the creation of Eye of Glory and Rune 2H Lazer cosmetic overrides.</p>
                <p>A certain coal rock ID no longer gives Rune Long Swords when mined and now correctly gives coal. I have no idea how this even happened in the first place...</p>
                <p>Frank's Mine Cart now correctly ships uncut emeralds to the bank.</p>
                <p>An additional requirement/item to gather has been added to Frank's Hard Task.</p>
                <p>The item reward from the "Cook's Wares" quest is now retrievable from the cook if it has been destroyed.</p>
                <p>Blooded Barbarian Helmets from Barbarian Huntsman acquisitions can no longer be dropped, but are instead a destroyable item.</p>
                <p>Players are no longer allowed to eat during a duel. This follows the same mentality of keeping PVP/PK combat fairly true to the original experience.</p>
                <h2>Website</h2>
                <p>Admins now have the ability to find the registered email of the user to address inquiries/tickets for support. This will eventually be worked into a full ticketing system accessible to character on the support page, which is expected to be done prior to launch or shortly post launch.</p>
                <p>The player support form has been widened a bit and fixed on mobile displays.</p>
                <p>Images on the index page have been updated to not include a player character and be pixel-perfect upscales to 1080p resolution. These will be tweaked over time and ready before release for an optimal experience.</p>
                <p>A placeholder video has been insterted onto the website background of the intro for testing (2012 RuneScape Cinematic Trailer). This will be replaced with a shortened version of our trailer when it's completed.</p>
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