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
                <p class="norm">This is the first Ethereal Lands Dev Blog! I'm super excited to share with you some of the things that have been brewing behind the scenes. First, I just want to make everyone aware that work is still being done behind the scenes to get the game ready for launch. In fact, there hasn't been a proper update in a while. I want to think the largest changes and work done up to this point has happened in the past two weeks.</p>
                <p class="norm">Tons of combat changes are being implemented, both for visual appeal and combat mechanics. To start, many different damage types have been implemented. This will allow players to feel as though they're fighting different monsters not just through how the monster looks, but what they're doing. For example, fighting a Noxious Demon will net the typical damage sprite, which has also seen an update, but you'll notice new Void Damage as well. At the current moment, there's plans to put these new damage types to work with resistances, etc., but that's a job for the near future. We've also introduced <b>Holy Shield</b>, a new type of friendly spell that shields a player from damage. This has been introduced with the healing update to Magic, which allows you to only heal friendly players and not yourself. There's some really cool spells in that update alone, but I won't dive into that too deep just yet.</p>
                <div class="img-container">
                    <img src="images/devblogs/hitsplats.png" alt="Hit Splats">
                    <b class="img-cap">Hitsplats showing: Water, Fire, Void, Air & Heal, Shielded</b>
                </div>
                <p class="norm">As you can see above, there's about 5 different damage types showcased, with a total of 13 so far and counting. We haven't shown Critical Strikes, Dragonfire, Poison, Earth, etc., but they are implemented and functional. And yes, the air damage type is going to be tweaked so the damage number can be read easier, but that's coming in a future update. You can also see a heal splat any time you heal with food or a spell or weapon mechanic! This doesn't show a splat when your character regenerates health naturally or from prayers. There's also another mechanic and damage type that isn't showcased here, and that's blocking!</p>
                <p class="norm">In a future update, your character will be able to block attacks while having a shield equipped, negating damage entirely! The block chance will be determined by the shield you are wearing, with a higher quality shield netting a higher block chance. This is going to come with a combat formula update that will increase the chances of being hit by a regular attack to offset shield blocking probability, but it should feel generally good to fight with a shield versus a two-handed weapon for survivability. Trust me, some of the two-handed weapons you can get your hands on will more than offset the survivability perk if you want to just smash.</p>
                <p class="norm">In other combat-related news, we've increased the amount of rounds you need to stay in combat before running to four rounds. This is a small jump from the previously needed three rounds, but makes the game more dangerous in some aspects. With the changes made to eating while fighting, this won't be much noticable, but will be important in future boss mechanics. Also, the eating and fighting isn't a thing in the Wilderness. However, the four round combat timeout <i>IS</i> sticking around for the Wilderness. We want to see how it plays out! We can make these changes to the wilderness combat only if players find it necessary.</p>
                <p class="norm">For visual feedback, when a prayer is active that is important, such as Protect from Melee or Missiles, a new overhead prayer sprite will be drawn for all players to see. While outside of combat, this sprite will be dimmed so you know it isn't taking away your prayer points. Also, while outside of combat, your prayer will no longer drain! This however does not affect players in the Wilderness, and prayer points will still drain outside of combat.</p>
                <div class="img-container">
                    <img src="images/devblogs/overheadprayers.png" alt="Protect from Melee Overhead Prayer">
                    <b class="img-cap">A player using Protect from Melee fighting a Giant. The lower right-hand corner shows the prayer disabled.</b>
                </div>
                <p class="norm"></p>
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