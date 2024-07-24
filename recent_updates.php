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
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">07/24/2024</p>
                    <div class="updatetitle">Crypt of Dread & Various Updates</div>
                    <div class="patchnumber">Pre-release Patch</div>
                    <p class="updatesummary">More updates to Ethereal Dungeons and other game areas.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>
                    We're still hard at work to get our first Ethereal Dungeon live and ready. We've been spending the
                    last week implementing systems that will make introducing more Ethereal Dungeons more
                    streamlined in the future. We've also introduced many new systems that give us the ability to offer
                    more visual feedback, like heal splats, into fights. Noted monster drops also make their debut to
                    official monster drop tables! A new Fishing Guild surfaces near Port Sarim...
                </p>
                <h2>Ethereal Dungeons</h2>
                <p>Scaling to dungeons has been tuned in various sectors. We've also introduced our dungeon difficulty
                    scaling feature. Setting your dungeon difficulty higher gives your character a better chance at the
                    loot in the dungeon, although increasing your dungeon difficulty also has a few other notable
                    impacts.</p>
                <p><b>Normal Difficulty</b> is the intended dungeon difficulty, providing good drop rates on the loot
                    within.
                    NPCs will scale with normal health and feel like a normal encounter, although the bosses
                    still have mechanics to watch out for. The mechanics in Normal Difficulty aren't extremely
                    punishing.</p>
                <p><b>Heroic Difficulty</b> is the harder dungeon difficulty, providing slightly better chances at
                    obtaining loot from bosses. NPCs still scale with combat level but are given more health, attack and
                    strength stats. Some monsters will now use special attacks. Boss mechanics do not change.</p>
                <p><b>Necrotic Difficulty</b> is the hardest dungeon difficulty, providing the best chance at obtaining
                    loot. NPCs will still scale with combat level, but have significantly increased health, attack,
                    strength and defense stats. Monsters will have some punishing special attacks. Bosses will have a
                    higher health pool and very punishing mechanics. Bosses will also have more mechanics than their
                    Normal and Heroic difficulty variants.</p>
                <p>A Font of the Ether has been added to Crypt of Dread allowing players to set their difficulty level
                    whilst inside the dungeon. Doing so resets progress.</p>
                <p>The Font of the Ether includes an option to show all of your dungeon-related stats where the font is
                    used.</p>
                <p>When an Ethereal Dungeon is active, a message will be displayed to the player upon login.</p>
                <p>Systems have been implemented to allow for further Ethereal Dungeon production with ease. Simplified
                    methods and functions to handle dungeons have been implemented to allow for more efficient
                    code-flow and future modifications.</p>
                <p>To reset dungeon progress, a new reset option has been added to dungeon entrance portals.</p>
                <p>Huntsman XP now scales with dungeon difficulty, with the most experience coming from defeating
                    bosses.</p>
                <p>Diaphante is now slightly ghostly, as initially intended.</p>
                <p>Bosses now produce less to no messages in the chat box when using special attacks.</p>
                <p>When dying in Ethereal Dungeons, a custom message is displayed instead of the normal death message
                    (chatbox) to make it apparent no items have been lost.</p>
                <p>Player deaths are now tracked in Ethereal Dungeons and is a viewable stat. We will be implementing
                    these stats to your character page on the website shortly!</p>
                <p>Crypt of Dread has been completed fully up to the final boss, where we're currently working to bring
                    an epic ending experience to Crypt of Dread!</p>
                <h2>General</h2>
                <p>Noxious Scythe pieces no longer drop from Noxious Demons, but Noxious Demons now have access to the
                    super rare drop table.</p>
                <p>We've implemented healing spells, allowing players to heal other players. This is a feature that is
                    being introduced for a reason we haven't decided to announce yet. You are unable to heal players
                    while you are in a duel or if the player being healed is in a duel. There are several other checks
                    implemented as well.</p>
                <p>A new rune has been introduced for healing spells, Void Rune.</p>
                <p>Void Rune has been added to several shops and 63 NPC drop tables.</p>
                <p>Work has been started on greyboxing the new Wilderness PvP areas. More information to come on this
                    upon finishing. This should be completed by the end of the week.</p>
                <p>Teleportation stones that are usable on the mainland after the tutorial have been added and enabled.
                </p>
                <p>The quest that is replacing Cook's Assistant has been completed.</p>
                <p>A 3rd option has been implemented to work with clickable objects. This gives us a total of 3
                    possible customizable options for all objects.</p>
                <p>A new fishing guild has been designed and the entrance is now located at Port Sarim. The old
                    fishing guild will be decommissioned in the next expansion when that area goes live.</p>
                <p>Healing (heal splats) have now been completed for players. Any healing outside of normal restoration
                    will now show as a heal splat on the player. NPCs in Crypt of Dread have had the same treatment
                    applied as a testing feature and will soon be implemented for all NPC healing once testing is
                    completed.</p>
                <p>The testing phase of eating during combat has been completed and will remain a feature of
                    Ethereal Lands outside of The Wilderness.</p>
                <p>Players attempting to eat whilst in the wilderness and in combat will be given a specific message
                    saying they can't eat in combat whilst in the wilderness.</p>
                <p>Noted drops have been implemented into monster drops and drop tables.</p>
                <p>All monster drops that included certs/certificates (logs, ore, etc.) have been altered to drop their
                    noted counterparts in the same quantity.</p>
                <p>Adjustments have been made to various objects/items for grammatical clarity.</p>
                <p>The healing amount of Lava Shark has been reduced. <span class="before">Heals 18</span><span
                        class="after">Heals 17</span></p>
                <p>Enchanting dragonstone jewelry is now possible once again. Previously, the needed level was 67
                    because of an oversight.</p>
                <p>The healing power of the Noxious Scythe has been adjusted. <span class="before">Heals 3-13
                        HP</span><span class="after">Heals 3-11 HP</span></p>
                <p>The healing chance of the Noxious Scythe has been adjusted. <span class="before">17%/10% Chance to
                        Trigger</span><span class="after">15%/8% Chance to Trigger</span>
                </p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">07/12/2024</p>
                    <div class="updatetitle">Ethereal Dungeons & Fixes</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">Lots of updates and fixes to the game and Ethereal Dungeons.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>
                    We've made some changes, additions and fixes to current systems for Ethereal Dungeons, dungeons that
                    scale to player combat levels. Many more fixes come in today's update as well!
                </p>
                <h2>Trailer</h2>
                <p>The Ethereal Lands cinematic trailer is still a work in progress, and we've rendered out our first
                    scene completely. The second scene is being put together now, and we expect the rest of the scenes
                    to flow quicker now that we have a proper workflow for creating them.</p>
                <h2>Ethereal Dungeons</h2>
                <p>Monster and Boss HP now correctly updates to the client when the NPC is scaled.</p>
                <p>Monster and Boss scaling has been adjusted/tuned at various combat levels.</p>
                <p>Crypt of Dread has been completed in terms of layout, design and dungeon functionality.</p>
                <p>Experience now scales correctly to a player's combat level when killing a monster or boss.</p>
                <p>Dungeon reset database information has been introduced when the last boss of a dungeon is killed to
                    clear all boss and NPC cache information, allowing the dungeon to be re-run multiple times.</p>
                <p>Ethereal Dungeon dungeon-wide drop tables have been made for monsters and bosses.</p>
                <p>Exit portals for Crypt of Dread have been enabled and will remain enabled even if the dungeon is not
                    active.</p>
                <p>Design and mechanics have been finalized for all bosses.</p>
                <p>Character stats for the dungeon has been implemented so you can view your dungeon stats
                    on the website character stats page. This is a work in progress.</p>
                <p>All Ethereal Dungeon item drops are in place and correctly tracking for collection logs.</p>
                <p>The Ethereal Dungeon "Dungeon Info" command has been enabled and will now show you relevant
                    information about the dungeon.</p>
                <p>Plans have been started for the second Ethereal Dungeon and we may have multiple dungeons active at a
                    time, instead of just one, for more diversity.</p>
                <h2>General</h2>
                <p>Daily Challenges no longer delete themselves when a player logs in while they are active.</p>
                <p>Added the ability to draw transparent sprites to the client whilst still managing black mask alphas.
                </p>
                <p>Players are now given introductory tutorial/controls information upon logging in for the first time
                    while on Kani'ani Island if they haven't started the main quest.</p>
                <p>Players are no longer able to teleport anywhere until they've completed the tutorial.</p>
                <p>Fixed Del'araz retreat issue. Del'araz will now chase the player when retreated from.</p>
                <p>Del'araz now has additional mechanics in Phase 2.</p>
                <p>Players are now able to eat whilst in combat, but cannot do so while in the wilderness. This change
                    does not include potions of any kind.</p>
                <p>Healing has been updated to support using the abandoned "heal()" function instead of directly
                    changing the level of Hits. This allows us to show heal sprites on the player when they heal from
                    something using the "heal()" method. This is going to be a slow change and is currently in testing
                    with Noxious Scythe special attack triggers. We've revived this abandoned, never-implemented
                    function to help players see when they are healed not only by food, but a weapon's special attack as
                    well. This will not include heal-over-time prayers or general recovery at this time.</p>
                <p>Greatswords have been implemented fully, and now show their stats client-side and have their special
                    attacks implemented in combat. We're still not sure how we want players to obtain these. (Looking
                    for ideas, suggestions - please submit via Discord if keeping up with updates)</p>
                <p>Several updates to various prayers (unreleased prayers) for tuning.</p>
                <p>Normal trees are no longer felled at 100%, and may last longer than 1 chop in rarer cases.</p>
                <p>The client has been updated to adjust overhead name visibility under certain, new conditions.</p>
                <p>Soul Slot has had its prayer level adjusted from 35 to 27.</p>
                <p>The "Send to Bank" option on the Year 1 Case and all Case Keys now works as intended.</p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">07/02/2024</p>
                    <div class="updatetitle">Various Fixes and Improvements</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">A few fixes show up in this week's update, as well as some secret
                        behind-the-scenes stuff!</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>
                    We're hard at work on implementing fixes into the game to get it ready to go live and play well.
                    We're finishing quests, new (or returning... duh duh DUH) areas, the cinematic reveal trailer and
                    pushing large changes to our server-side and client-side code to prepare for our tutorial island
                    testing phase and eventual full features reveal.
                </p>
                <h2>Trailer</h2>
                <p>The Ethereal Lands trailer is still very much so a work in progress and is coming along. We expect
                    this to take more time to finish due to the vision we have for the trailer and all we expect from
                    it.</p>
                <h2>General</h2>
                <p>When fishing, the think bubble overhead will now show the correct tool that the player is using and
                    not the alternate tool. (eg. Harpoon vs Harpoon of the Deep)</p>
                <p>The chance to fish up Gem of the Phantom Trawler has been halved (now 1/512 chance + 1/10 chance),
                    both on the first and second rolls.</p>
                <p>Gubgub's item reward table has been adjusted slightly.</p>
                <p>Gubgub now has speech patterns when attacking players with his spear to make it easier to know when
                    the attack is queued.</p>
                <p>Several Dragonfire resistances have been adjusted. Dragonfire attacks will be getting an entire
                    rework shortly.</p>
                <p>The monetary gain from alchemy spells has once again been reduced significantly, with Extreme Alchemy
                    moving from 50% of item value to 18% of item value.</p>
                <p>A secret feature release for Prayer has been finished and is functional in our initial tests.</p>
                <p>Prayers no longer have an initial hit to your prayer points when activated. They still function as
                    previously mentioned and do not drain your prayer points outside of combat, but we've also made
                    changes to drain your prayer points while the prayer is active inside the wilderness, outside of
                    combat, as normal. There are also a few prayers that will drain points outside of combat, including
                    Rapid Heal and Restore.</p>
                <p>The "Protect Items" prayer has been renamed to "Soul Slot" to more closely align with the story
                    element of Ethereal Lands. Other prayers may follow suit in a similar manner.</p>
                <p>Tutorial Island updates/changes to various NPCs.</p>
                <p>Work is being started to show the healing a player takes similar to damage the player takes. This
                    will be focused into items or prayers that heal the player at first, and then move to food and other
                    health restoring items/effects.
                </p>
                <h2>Website</h2>
                <p>Updates will now have update-specific images instead of using random images from our library of
                    images. Yay, design! These will be improved over time or more closely relate to the update the
                    picture is tied to.</p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">06/22/2024</p>
                    <div class="updatetitle">In-game Update Galore</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">The game is seeing various updates and improvements this week to ready for
                        pre-launch testing.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>This update sees various updates to many in-game activities and items. We've also started rendering
                    scenes from our upcoming EL trailer, so hopefully that will be finished within the month and we'll
                    have something awesome to show for it!
                </p>
                <h2>Major Gameplay Updates</h2>
                <p>Several prayers have had their drain rates tuned to drain less prayer points over time. However, the
                    first time you activate most prayer abilities, your prayer points will take an immediate hit. The
                    hit amount is based on whether the prayer is considered a "high level" or "low level" prayer,
                    currently set at 2 and 3 points respectively. Not all prayers are
                    affected by these changes (prayers unlocked at very early levels) but this may change in the future.
                    This change was made to increase the difficulty of the game in
                    various ways, but increase the amount of time prayers can be kept on once engaged. Prayer-flicking
                    will now cost additional points if switching off prayers entirely and switching them back on. It
                    will not cost any additional prayer points to turn a prayer off. <i>Most importantly, prayers will
                        only drain while in combat and can be kept on continually without draining your prayer while
                        outside of combat.</i> Once you enter combat, your prayer will drain as normal again. Hurrah!
                    <b>This initial hit to your prayer (at this current moment and with no future plans to change) does
                        not affect players while they are in the wilderness. The PvP systems in Runescape Classic are
                        very near and dear to player's hearts, and we want to keep that as unchanged as possible. This
                        update is also subject to change and will be reverted if we are not satisfied with the
                        testing results.
                    </b>
                </p>
                <h2>General</h2>
                <p>The Ethereal Lands cinematic trailer has started rendering its first scene! We should have the
                    cinematic up on the website's home page hopefully within the month!</p>
                <p>Three new prayers have been designed and added to the game, two of which were designed to help with
                    early-game leveling and dealing with lower-leveled monster/boss special attacks.</p>
                <p>Several interface texts have been updated to reflect their differences between existing and new
                    prayers that essentially do the same thing with slight differences.
                </p>
                <p>Protect from Melee was not working as intended, and now halves damage correctly when it's able to.
                </p>
                <p>Dragon Bars are now able to be made with many, many more dragon items by using them on the
                    appropriate furnace. The amount of Dragon Bars made will depend on which dragon item is used in the
                    smelting process.</p>
                <p>Rapid Heal has been significantly improved and now restores HP at about 4x the normal restoration
                    rate, but now costs significantly more in prayer drain rate.</p>
                <h2>Items</h2>
                <p>The Eye of Del'araz has been given updated examine information, making it clear that it can be
                    used
                    on a Charged Dragonstone Amulet (Amulet of Glory) to create the Eye of Glory.
                </p>
                <p>The Charged Dragonstone Amulet has been renamed to Amulet of Glory.</p>
                <p>The examine information for special cosmetics has been altered to be more clear that they will
                    never be returning to the game once deemed discontinued.</p>
                <h2>Website</h2>
                <p>Several updates to the index page of the website.</p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">06/18/2024</p>
                    <div class="updatetitle">Various Game Updates</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">The game is seeing various updates and improvements this week.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>Drop rate changes and new monster abilities/attacks are being introduced this week. In the coming
                    weeks, new prayers are going to be introduced to assist players at the lower-levels in reducing
                    damage taken by a smaller percent or entirely if using the prayer to avoid a special attack from a
                    lower-leveled boss or mob. We're also starting work on a cinematic trailer for Ethereal Lands.
                </p>
                <h2>Bosses</h2>
                <p>Del'araz has had his drop rates reduced across the board for Noxious Scythe pieces.
                </p>
                <p>The drop rate of Ice Dye (for a Noxious Scythe (Ice)) has been reduced by over half, giving a 1/1000
                    chance of dropping. (Del'araz)</p>
                <p>Gubgub's special attack bug has been fixed and will no longer make Gubgub unattackable after Gubgub
                    activates it.</p>
                <h2>Administration</h2>
                <p>Certain items have been restricted from being granted/spawned in-game. These items are mainly rares
                    and special items that should not be spawned in under any circumstances. The only way these items
                    will be granted is via manual database entry while the server is offline and will not occur often.
                </p>
                <h2>Character</h2>
                <p>A world announcement is now made when a player reaches maximum level in a skill (66).</p>
                <h2>Ethereal Dungeons</h2>
                <p>Ethereal Dungeons have had their own NPC spawn files created for enabling and disabling specific
                    dungeons, along with their previously added object spawn information.</p>
                <h2>Website</h2>
                <p>The Admin Dashboard has been given a few tools to assist with player issues such as Ethereal Souls
                    or cosmetic purchases, player cache issues with quests, etc. More tools will be added soon to assist
                    with mutes, bans, player cache removal and quest progress manipulation.</p>
                <p>Confirmation dialogues and database logging will be enabled for all admin tool usage to prevent
                    abuse. These tables and additions are being worked on along with the new tools that are coming and
                    will be enabled before Ethereal Lands goes live.</p>
                <h2>Misc</h2>
                <p>Work has been started on a cinematic Ethereal Lands trailer. It's going to be a banger. Stay tuned!
                </p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/web.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">06/11/2024</p>
                    <div class="updatetitle">Daily Challenges & Support</div>
                    <div class="patchnumber">Website & Database</div>
                    <p class="updatesummary">Updates to our Daily Challenges system as well as Support... support.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>We've made some updates to our Daily Challenges system and have brought it live. We've also brought
                    our Support page live and will soon be opening it to submit tickets for issues you may encounter.
                </p>
                <h2>Website</h2>
                <p>Daily Challenges have gone live. Claim up to 3 daily challenges by visiting the page each day. Daily
                    Challenges reset at 1:00 AM server time each day. When claiming your 3 daily challenges, you have
                    chances to get either Uncommon, Rare, Epic or Artifact challenges, each rewarding different amounts
                    of Ethereal Souls.</p>
                <p>The purchase of cosmetic items and Ethereal Souls has finished its testing phases and is moving to
                    dormant until the release of Ethereal Lands.</p>
                <p>We've updated the website to include a support page to submit assistance for support. This will
                    eventually be turned into an entire ticketing system for all admins to manage via their Admin
                    Dashboard.</p>
                <p>Several CSS adjustments have been made to the website for a cleaner, more appealing approach.</p>
                <h2>Database</h2>
                <p>The database now caches and adds players to the correct tables for Ethereal Souls and cosmetic
                    purchases if they initally sign up via the game client.</p>
                <h2>Quests</h2>
                <p>A new quest has been developed, replacing Cook's Assistant.</p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">06/04/2024</p>
                    <div class="updatetitle">Gubgub, Leader of Goblins</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">Some updates to various things, as well as Gubgub, a low-leveled bossing
                        activity.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>We're focusing on cleaning up previously implemented activities and items, such as the Ring of Travel
                    and Gubgub, Leader of Goblins. Slight adjustments have been made in all of these areas for a good
                    starting experience.
                </p>
                <h2>Items</h2>
                <p>Ring of Travel has been fixed. It now cancels correctly and teleports to various accessible areas
                    within the current Ethereal Lands play area as intended.</p>
                <p>Several item appearance sprite issues have been ironed out, including the new Pick'n'axe items from
                    Kani'ani Island.</p>
                <p>All 2-Handed weapons (R2H, Addy 2H, etc.) have had their appearance sprites adjusted significantly
                    and now appear as such: big, badass weapons.</p>
                <p>Adjustments are being made to the scimitar appearance sprites and should be completed shortly.</p>
                <h2>NPCs</h2>
                <p>Gubgub, Leader of Goblins has undergone several adjustments: He now has more drops, a special attack,
                    and lower leveled skills to support the low-leveled activity he was designed to fill.</p>
                <p>A special attack Del'araz used that could instantly kill a player has been reduced in damage. This is
                    still a very powerful attack, but wont instantly kill a player if not handled correctly.</p>
                <h2>Quests</h2>
                <p>A new quest has been created to introduce Cook's Assistant and is accessible directly off Kani'ani
                    Island. Cook's Assistant is still an accessible quest, but only able to be completed once this newly
                    added quest has been completed.</p>
                <p>The Cook's Assistant quest has been fully remastered and now requires the newly added quest to be
                    completed.</p>
                <h2>Other</h2>
                <p>The default view distance of the client has been set to <b>12 units</b>.</p>
                <p>Cosmetic head and body appearances are now working correctly and do not give the option in-game to
                    adjust chracter sprites to these appearances, as intended. This now allows us to correctly offer and
                    adjust player sprites via the online cosmetic shop when one is purchased.</p>
                <p>Players are no longer flagged as suspicious when their appearance falls outside of the normal valid
                    ranges for player appearance sprites.</p>
                <p>Additional body sprites and head sprites are being worked on for the cosmetic shop, including some
                    awesome ones that we can't wait to reveal!</p>
                <p>Daily Tasks, accessible via website while signed in, are being developed. These will allow players to
                    earn Ethereal Souls without having to pay real money if they don't want. The goal is for Ethereal
                    Souls to be earned at a reasonable rate either in a standalone way, or alongside purchasing Ethereal
                    Souls to buy awesome cosmetics.</p>
                <p>The Creator's Corridor has been added to the website and gives a glimpse into the creator system we
                    have planned for Ethereal Lands. This system is still very much a work-in-progress and is expected
                    to be fully functional sometime after the game's initial launch.</p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/server.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">05/30/2024</p>
                    <div class="updatetitle">Slew of Updates & Atlanta, GA Server</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">We've updated our game server to be hosted and implemented some more game
                        updates.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>We've gotten around to hosting the game server on a VPS finally, after two years of development,
                    allowing the server to remain online
                    24/7. We're currently testing the stability of this server while pushing several various game
                    updates. You'll notice below some grunt work we've been doing to get the game ready for release.
                    Along with this grunt work, we're focusing on the larger-picture updates, such as Ethereal Dungeons,
                    new items, etc. We're maybe 6 months out from a full release, and around 1 month away from the
                    Kani'ani Tutorial Island and the server stability tests. Stay tuned for those!
                </p>
                <h2>General</h2>
                <p>Lowered buy/sell price significantly on rune and dragon equippable items. This will help keep a
                    fairly stable economy by keeping the value of GP high.</p>
                <p>Several other items have had their buy/sell pricing lowered slightly.</p>
                <p>Updated compatibility for many, many items to work with the new examine boxes.</p>
                <p>Added checks for Ethereal Dungeon: Crypt of Dread (and all future dungeons) to load scenery and
                    interactable objects data while the dungeon is active. This allows us to easily disable and enable
                    the dungeon for various purposes such as fixes and limited-return events.</p>
                <p>All skills have had their levels reduced to fit in line with the level 66 maximum. This now completes
                    the skill reduction effort so we can start on removing all quests that aren't able to be completed
                    since the world has been shrunk.</p>
                <p>Terrain has been modified and scenery has been added to Al'Kharid where the entrance to Crypt of
                    Dread is located.</p>
                <p>All alchemy spells have had their gold output reduced fairly significantly. Extreme Alchemy (unlocked
                    in Crypt of Dread) gives less gold than High Alchemy used to before the adjustment of all alchemy
                    spells.</p>
                <p>Greatswords are under development in adamantite, rune and dragon varities. These weapons will provide
                    a higher accuracy bonus than a two-hander but a lower power bonus. They will also offer a small
                    prayer bonus in a couple of ways...</p>
                <p>Special weapon attacks (automatic trigger) have been added to the Dragon Sword, Dragon 2H Sword and
                    all Greatswords. Also, a special armor ability (automatic trigger) has been added to the Dragon
                    Plate Mail Body/Top. The chances of these special attacks/abilities triggering works with the Focus
                    Wards prayer. More of these are coming and are currently in development. We're keeping the special
                    attacks and abilities a secret until the items are acquired.</p>
                <p>The server-side item definitions/data has been updated in the rare case that the client defaults to
                    showing this information instead of the client-side information.</p>
                <p>Players are now able to turn a Rune 2-Handed Sword into a Rune 2-Handed Lazer (Year 1 Cosmetic). Upon
                    death, a normal Rune 2-Handed Sword will drop instead of the 2-Handed Lazer variant.</p>
                <p>Players are now able to turn a Charged Dragonstone Amulet into an Eye of Glory (Year 1 Cosmetic).
                    Upon death, a normal Charged Dragonstone Amulet will drop instead of the Eye of Glory/Del'araz
                    variant.</p>
                <h2>Website & Database</h2>
                <p>The server is now being hosted 24/7 on a Ubuntu Linux VPS. This is being tested for stability and so
                    far appears to be working well. If we launch and a problem arises, we'll double the specs. The
                    server and website is officially, finally setup and ready for release.</p>
                <p>The website cosmetics store has been updated with the ability to purchase Ethereal Souls to exchange
                    for cosmetics using PayPal (account, Pay Later or debit/credit card transactions) as the payment
                    processing vendor. We are working on a different system to allow database cache storage of these
                    purchased items so you can collect them in-game instead of having them delivered directly to the
                    bank. This has caused duplicate item_id issues (in rare cases) that causes the affected player to be
                    rolled-back. We'll keep you updated in this regard and the item store (and ability to purchase
                    Ethereal Souls) will not be enabled until this is resolved.</p>
                <p>Work has started on the Creator's Corridor, which will be a portal for players to start creating for
                    Ethereal Lands. More information will be released about this program in the future when it launches.
                </p>
            </div>
        </div>
        <div class="updatebox">
            <div class="updatetop">
                <div class="updateimage"><img src="images/updates/game.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">05/25/2024</p>
                    <div class="updatetitle">Cosmetic Crates & Crypt of Dread</div>
                    <div class="patchnumber">Pre-release Update</div>
                    <p class="updatesummary">We've made some updates to cosmetic crates and our first
                        Ethereal Dungeon, Crypt of Dread.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>This update focuses on quality of life changes and a few adjustments/fixes. Experience rates were
                    somewhat high with some training methods, so we've given those a little polish, as well as generally
                    fixed some bugs. We're also starting Ethereal Dungeon design. All code has been implemented on the
                    back-end for these dungeons, so now we're diving into the visual design of the dungeon, including
                    the entrance and dungeon itself.</p>
                <h2>General</h2>
                <p>We've adjusted cosmetic crates so they can be sent to the bank by using the "Send to Bank" option.
                </p>
                <p>We've added batch-opening of cosmetic crates to our to-do list. We expect this to take a little bit
                    of time as it's not a primary focus at this time.</p>
                <p>Frank's Mine Medium and Hard tasks have been completed and implemented with their respective rewards.
                </p>
                <p>The King Black Dragon spawn has been removed and is awaiting a complete redesign and relocation.
                    Along with its redesign, it will have a rare chance to drop a new, powerful artifact item! Stay
                    tuned for further information!</p>
                <h2>Adjustments & Fixes</h2>
                <p><b>Kani'ani Island</b> now correctly rewards 1 quest point when completed.</p>
                <p>Cremation experience rates for Prayer and Firemaking have been reduced. We thought the experience
                    rates were a little <i>too</i> good, so we've brought them down. This is still a very viable
                    training method as you'll earn more prayer experience than simply burying the bone.</p>
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
                <div class="updateimage"><img src="images/updates/server.png" alt="update image"></div>
                <div class="updatebartop">
                    <p class="updatedate">05/24/2024</p>
                    <div class="updatetitle">Website & Database Upgrades</div>
                    <div class="patchnumber">Website & Database</div>
                    <p class="updatesummary">This update focuses on website and database upgrades to prepare
                        for the release of the game.</p>
                </div>
            </div>
            <div class="updatecontent">
                <p>This update is fairly small and only focuses on several website and database upgrades. This is
                    mainly for archiving purposes as you'll likely not notice many changes on the front end.</p>
                <h2>Website Updates</h2>
                <p>This updates page has been heavily redesigned to meet the same quality as the other pages.</p>
                <p>Website has been visually redesigned.</p>
                <p>The website has been updated to support player logins.</p>
                <p>The cosmetics store has been designed and is ready for when the game releases. Cosmetics will be
                    able
                    to be earned entirely in-game by utilizing the website's daily task system to earn Ethereal
                    Souls or
                    by purchasing Ethereal Souls directly.
                    The tasks are completed in-game by the character you login with. Currently, the store is
                    disabled
                    but fully functional. Next, we're working on adding an inventory system to manage your purchases
                    and, eventually, purchasing Ethereal Souls using real currency.
                </p>
                <h2>Database Updates</h2>
                <p>Database has been upgraded/migrated to MySQL to support web-server database hosting, player
                    logins
                    and server hosting.</p>
                <p>Several database upgrades have been made to support cosmetic item purchases and equipping.</p>
                <h2>Server Updates</h2>
                <p>The server has been updated to check for duplicate itemID's before processing and saving player
                    data. This has been updated to support cosmetic item delivery from the website inventory.</p>
                <p>We've made some adjustments to logging that will disable logging .txt files for WARN and INFO
                    messages while the game server is running. While these events are pretty rare, we only need to
                    log
                    error and debug events.</p>
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