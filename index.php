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
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <div id="navlinks">
                <a href="recent_updates">Game Updates</a>
                <a href="creators_corridor">Creator's Corridor</a>
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
            <a class="button-main" href="recent_updates">Game Updates</a>
            <a class="button-main" href="creators_corridor">Creator's Corridor</a>
            <a class="button-main" href="https://discord.gg/d6RtsDyRZX">Discord</a>
            <?php if ($loggedIn): ?>
            <a class="button-main" id="introaccountbutton">
                My Account
            </a>
        <?php else: ?>
            <a class="button-main" id="introaccountbutton">
                Login
            </a>
        <?php endif; ?>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "scripts/get_total_accounts.php",
                method: "GET",
                success: function (data) {
                    var jsonData = JSON.parse(data);
                    $("#totalAccounts").text(jsonData.totalAccounts);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    console.log("AJAX request failed: " + textStatus + ", " + errorThrown);
                }
            });
        });
    </script>
    <div id="intro">
        <video autoplay loop muted playsinline>
            <source src="video/introvideo.mp4" type="video/mp4">
            Your browser does not support the video tag.
        </video>
        <div class="video-filter"></div>
        <div class="blanktop"></div>
        <div class="character-counter">Currently, <span id="totalAccounts">#</span>
            heroes stand at the portal to New Gielinor, primed to snuff the evil that is Del'araz...</div>
        <div class="intro-intro">
            <h1 class="white-h1">FORGE YOUR DESTINY IN NEW GIELINOR</h1>
            <h3>Tons of new features are awaiting new adventurers.</h3>
            <p class="story">
            Brace yourselves for the noxious invasion of Gielinor. The world has been sundered, and new threats rise from the Void. Find a way to harness the void energy and turn the tables against Del'araz! Welcome to New Gielinor.
            </p>
            <!-- <div class="intro-logo"></div>
            <h2>A Runescape Classic Adventure</h2> -->
            <!-- <p>Explore a world that's been sundered by the noxious invasion...</p> -->
        </div>
    </div>
    <div class="overlay" id="overlay"></div>

    <div class="popup" id="popup">
        <span class="popup-close" id="popup-close">&times;</span>
        <div class="popup-header" id="popup-header-text">
            <h2>Create a Character</h2>
        </div>
        <p id="register-note">Note: Ethereal Lands is not yet available, but this will create and claim your character
            name.</p>
        <form class="popup-form" id="registration-form">
            <input type="text" id="username" name="username" maxlength="12" pattern="[A-Za-z0-9 ]{1,12}"
                placeholder="Character Name" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="password" id="confirm-password" placeholder="Confirm Password" required>
            <input type="email" id="email" name="email" placeholder="Email Address" required>
            <input type="submit" value="Create Character">
        </form>
        <div class="registrationmessage" id="errorsuccessmessage"></div>
    </div>

    <div class="popup" id="popup-login">
        <span class="popup-close" id="popup-login-close">&times;</span>
        <div class="popup-header">
            <h2>Login</h2>
        </div>
        <p>Use your Ethereal Lands username and password to login below.</p>
        <form class="popup-form" method="post" id="login-form" action="login.php">
            <input type="text" id="username-login" name="username" maxlength="12" pattern="[A-Za-z0-9 ]{1,12}"
                placeholder="Character Name" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class="loginmessage" id="errorsuccessmessagelogin"></div>
    </div>

    <script>
        $(document).ready(function () {
            $('#login-form').on('submit', function (event) {
                event.preventDefault();
                var formData = $(this).serialize();
                $.ajax({
                    url: 'scripts/login.php',
                    type: 'POST',
                    data: formData,
                    dataType: 'json',
                    success: function (response) {
                        $('#errorsuccessmessagelogin').html(response.message);

                        if (response.status === 'success') {
                            setTimeout(function () {
                                window.location.href = 'account/character';
                            }, 2000);
                        } else {
                            $('#errorsuccessmessagelogin').html(response.message);
                            setTimeout(function () {
                                $('#errorsuccessmessagelogin').html('');
                            }, 3000);
                        }
                    }
                });
                $('input, textarea').blur();
            });
        });
    </script>

    <div class="popup" id="popup-account">
        <span class="popup-close" id="popup-account-close">&times;</span>
        <div class="popup-header">
            <h2>Login or Sign Up</h2>
        </div>
        <div class="button-main margin-top-15" id="registerbutton">Sign Up</div>
        <div class="button-main margin-top-15" id="loginbutton">Login</div>
    </div>

    <script>
        let loggedIn = <?php echo json_encode(isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']); ?>;

        document.getElementById('introaccountbutton').addEventListener('click', function () {
            if (loggedIn) {
                window.location.href = 'account/character';
            } else {
                document.getElementById('popup-account').classList.add('active');
                document.getElementById('overlay').classList.add('active');
            }
        });

        document.getElementById('accountbutton').addEventListener('click', function () {
            if (loggedIn) {
                window.location.href = 'account/character';
            } else {
                document.getElementById('popup-account').classList.add('active');
                document.getElementById('overlay').classList.add('active');
            }
        });

        document.getElementById('loginbutton').addEventListener('click', function () {
            document.getElementById('popup-login').classList.add('active');
            document.getElementById('popup-account').classList.remove('active');
            document.getElementById('overlay').classList.add('active');
            document.getElementById('username-login').focus();
        });

        document.getElementById('registerbutton').addEventListener('click', function () {
            document.getElementById('popup').classList.add('active');
            document.getElementById('popup-account').classList.remove('active');
            document.getElementById('overlay').classList.add('active');
            document.getElementById('username').focus();
        });

        document.getElementById('popup-close').addEventListener('click', function () {
            document.getElementById('popup').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        });

        document.getElementById('popup-account-close').addEventListener('click', function () {
            document.getElementById('popup-account').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        });

        document.getElementById('popup-login-close').addEventListener('click', function () {
            document.getElementById('popup-login').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        });

        document.getElementById('overlay').addEventListener('click', function () {
            document.getElementById('popup').classList.remove('active');
            document.getElementById('popup-account').classList.remove('active');
            document.getElementById('popup-login').classList.remove('active');
            document.getElementById('overlay').classList.remove('active');
        });

        document.getElementById('registration-form').addEventListener('submit', function (event) {
            event.preventDefault();
            let password = document.getElementById('password').value;
            let confirmPassword = document.getElementById('confirm-password').value;

            if (password !== confirmPassword) {
                document.getElementById('errorsuccessmessage').innerText = 'The passwords entered do not match.';
                return;
            }

            var formData = new FormData(this);

            fetch('scripts/register.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('registration-form').style.display = 'none';
                        document.getElementById('popup-header-text').style.display = 'none';
                        document.getElementById('register-note').style.display = 'none';
                        document.getElementById('errorsuccessmessage').innerText = 'You\'ve successfully created a character! We\'ll see you in Ethereal Lands shortly!';
                    } else {
                        document.getElementById('errorsuccessmessage').innerText = data.message;
                    }
                })
                .catch(error => {
                    document.getElementById('errorsuccessmessage').innerText = 'An error occurred.';
                    console.error('Error:', error);
                });
            $('input, textarea').blur();
        });
    </script>
    <div class="slide-main" id="slide1">
        <div class="slide-content">
            <h1>New Maximum Level</h1>
            <p>Ethereal Lands features a new story, quests, areas, monsters and so much more. To tell this new story,
                <b>we've reduced the maximum level you can reach to 66</b>. You'll reach maximum level in a shorter
                time, but we're putting a considerable amount of effort into the development and health of our end-game
                experience. Maximum level will gradually rise with each major expansion release, with the first set to
                raise the maximum level to <b>77</b>.
            </p>
        </div>
        <div class="slide-content">
            <h1>New Gielinor</h1>
            <p>Some areas of Gielinor will never be same. Edgeville, Lumbridge, Karamja Island and many, many more areas
                have been forever-changed by the noxious invasion. The Gielinor you know and love will feel similar, but
                offer brand new adventuring experiences as you explore the new, sundered world of New Gielinor.
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <div class="slide-main" id="slide2">
        <div class="slide-content">
            <h1>Expanded Locations</h1>
            <p>New and expanded areas are coming to Gielinor! New areas are built retaining the Classic touch, careful
                not to
                fall into the typical "private server" feel. Unlock powerful training areas by completing tasks! Explore
                new underground dungeons and caves! Most importantly, <b>experience a completely new tutorial island</b>
                right from the get-go, sending you on your first quest utilizing almost every skill right on the island
                and showing you a glimpse of what's to come in New Gielinor.
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <div class="slide-main" id="slide3">
        <div class="slide-content">
            <h1>Graveyards</h1>
            <p>Gone are the days of respawning in Lumbridge... at least all the time.<br><br>New to all accessible areas
                are <b>graveyards</b>; respawn points with <i>possible</i> bank access to get you back into what you
                were doing quicker! However, you may have to complete a task or two in order to get access to these new
                graveyard banks.
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <div class="slide-main" id="slide4">
        <div class="slide-content">
            <h1>New Skill: Huntsman</h1>
            <p>Very similar to the much-beloved Slayer skill, the Huntsman skill focuses on retrieving items or
                completing specific tasks instead of simply killing creatures. Huntsman offers awesome rewards and
                gives us the ability to grant players with itemized rewards to help with leveling other skills.
            </p>
        </div>
        <div class="slide-content">
            <h1>Improved Skill Guilds</h1>
            <p>With some areas of New Gielinor being inaccessible, this left us without guilds for some skills that we
                still wanted, so we've re-designed some of these returning guilds and reinvented the way that you'll
                access and use these guilds.
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <div class="slide-main" id="slide5">
        <div class="slide-content">
            <h1>Quest Overhaul</h1>
            <p>Within our universe, some quests remain, but many quest givers have closed up shop and moved on. Some new
                quest givers have arrived as well! All quests
                available are either crafted masterfully, or have been remastered from scratch. Along with
                these changes, most items, examine texts and dialogue has been remastered to improve grammatic clarity
                and your overall gameplay experience.
            </p>
        </div>
        <div class="slide-content">
            <h1>New Threats Loom!</h1>
            <p>Ethereal Lands is a dangerous place. Some monsters have been given special abilities, notated either by
                NPC dialogue or chat notification that it's coming, giving you an opportunity to counter the attack.
                Your Hero has also grown in power, though! Many powerful items have been given auto-triggering special
                attacks or abilities to help take out these threats across New Gielinor. Get acquainted with your
                prayers too, as several have been added!
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <div class="slide-main" id="slide6">
        <div class="slide-content">
            <h1>Ethereal Dungeons</h1>
            <p>As a seasonal activity, rotating out every-so-often, Ethereal Dungeons are small, bite-sized
                dungeon-delving
                experiences that scale to your character's combat level. Starting at level 20, you can complete these
                dungeons, each containing a varying amount of
                bosses that drop <b>epic or greater rarity loot</b> to enhance your gameplay at any level! For example,
                <b><span class="epicfont">Harpoon of
                        the
                        Deep</span></b> has
                a 50% chance to cook any fish that you catch while you carry it! Insanity!
            </p>
        </div>
        <!-- <div class="slide-fade"></div> -->
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>