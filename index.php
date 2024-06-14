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
                <a href="updates">Game Updates</a>
                <a href="creatorscorridor">Creator's Corridor</a>
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
            <a class="button-main" href="updates">Game Updates</a>
            <a class="button-main" href="creatorscorridor">Creator's Corridor</a>
            <a class="button-main" href="https://discord.gg/d6RtsDyRZX">Discord</a>
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
        <div class="blanktop"></div>
        <div class="character-counter">Currently, <span id="totalAccounts">#</span>
            heroes stand at the portal to Gielinor, primed to snuff the evil that is Del'araz...</div>
        <?php if ($loggedIn): ?>
            <button class="button-main" id="introaccountbutton">
                My Account
            </button>
        <?php else: ?>
            <button class="button-main" id="introaccountbutton">
                Login
            </button>
        <?php endif; ?>
        <!-- <h1>Ethereal Lands</h1> -->
        <div class="intro-logo"></div>
        <h2>A Runescape Classic Adventure</h2>
        <p>Explore a world that's been sundered by the noxious invasion...</p>
        <!-- <p class="story">
            In the realm of Gielinor, a malignant force is stirring. The malevolent demon general, Del'araz, has
            unleashed his noxious lords upon the land, spreading a virulent plague that darkens the skies and withers
            the earth. With Lumbridge in his sights, Del'araz is amassing a terrifying demonic army, intent on sundering
            the town to ashes to lay the foundations for a dark uprising.
            <br><br>
            If the relentless advance of Del'araz and his legion is not halted, the entire world risks falling into
            chaos, with every corner of Gielinor surrendering under his tyrannical rule. The call to arms rings out
            across the land, beckoning heroes to rise against this encroaching darkness, in a desperate bid to save
            their world from being irrevocably conquered by the forces of Del'araz.
        </p> -->
        <div class="slide-fade"></div>
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
                                window.location.href = 'account';
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
                window.location.href = 'account';
            } else {
                document.getElementById('popup-account').classList.add('active');
                document.getElementById('overlay').classList.add('active');
            }
        });

        document.getElementById('accountbutton').addEventListener('click', function () {
            if (loggedIn) {
                window.location.href = 'account';
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
    <div class="slide" id="slide1">
        <div class="slide-content">
            <h1>New Maximum Level</h1>
            <p>Ethereal Lands features a new story, quests, areas, monsters and so much more. To tell this new story,
                <b>we've reduced the maximum level you can reach to 66</b>. You'll reach maximum level in a shorter
                time, but we're putting a considerable amount of effort into the development and health of our end-game
                experience. Maximum level will gradually rise with each major expansion release, with the first set to
                raise the maximum level to <b>77</b>.
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <div class="slide" id="slide2">
        <div class="slide-content">
            <h1>Expanded Locations</h1>
            <p>New and expanded areas are coming to Gielinor! Areas are built retaining the Classic touch, careful to
                not
                fall into the typical "private server" feel. Unlock powerful training areas by completing tasks! Explore
                new underground dungeons and caves! Most importantly, <b>experience a completely new tutorial island</b>
                right from the get-go, sending you on your first quest utilizing almost every skill right on the island.
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <div class="slide" id="slide3">
        <div class="slide-content">
            <h1>Graveyards</h1>
            <p>Gone are the days of respawning in Lumbridge... at least all the time.<br><br>New to all accessible areas
                are
                <b>graveyards</b>, respawn points with <i>possible</i> bank access to get you back into what you were
                doing
                quicker! You may have to complete a task or two in order to get access to these graveyard banks,
                however.
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <div class="slide" id="slide4">
        <div class="slide-content">
            <h1>New Skill: Huntsman</h1>
            <p>Very similar to the much-beloved Slayer skill, the Huntsman skill focuses on retrieving items or
                completing
                specific tasks instead of simply killing creatures. Huntsman offers many awesome rewards, and also gives
                us the
                ability to grant players with items that can help with leveling other skills.
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <div class="slide" id="slide5">
        <div class="slide-content">
            <h1>Quest Overhaul</h1>
            <p>Within our universe, some quests remain, but many quest givers have closed up shop and moved on as their
                quests have been fulfilled. Some new quest givers have arrived as well! All quests available are either
                built masterfully, or have
                been remastered for a perfect experience. Along with these changes, most items, examine texts and dialog
                has been remastered to improve grammatic clarity.
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <div class="slide" id="slide6">
        <div class="slide-content">
            <h1>Ethereal Dungeons</h1>
            <p>As a seasonal activity, rotating about every three months or so, Ethereal Dungeons are small, bite-sized
                dungeon-delving
                experiences that scale to your character's combat level. Starting at level 20, you can complete these
                dungeons, each containing a varying amount of
                bosses that drop <b>epic or greater rarity loot</b> to enhance your gameplay! For example, <b><span
                        class="epicfont">Harpoon of
                        the
                        Deep</span></b> has
                a 50% chance to cook any fish that you catch while you carry it! Insanity!
            </p>
        </div>
        <div class="slide-fade"></div>
    </div>
    <?php include 'footer.php'; ?>
</body>

</html>