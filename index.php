<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Play Ethereal Lands</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="mainbar">
            <div class="logo" id="toplogo">
            </div>
            <div id="navlinks">
                <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
                <a href="updates">Game Updates</a>
            </div>
            <div class="button-div">
                <button class="button-main" id="accountbutton">
                    Login
                </button>
            </div>
            <div id="menuexpand">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenu">
            <a href="https://discord.gg/d6RtsDyRZX">Discord</a>
            <a href="updates">Game Updates</a>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $.ajax({
                url: "get_total_accounts.php",
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
        <button class="button-main" id="introaccountbutton">
            Login
        </button>
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
        <p>Note: Ethereal Lands is not yet available, but this will create and claim your character name.</p>
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
            <input type="text" id="username" name="username" maxlength="12" pattern="[A-Za-z0-9 ]{1,12}"
                placeholder="Character Name" required>
            <input type="password" id="password" name="password" placeholder="Password" required>
            <input type="submit" value="Login">
        </form>
        <div class=" loginmessage" id="errorsuccessmessage">
        </div>
    </div>

    <div class="popup" id="popup-account">
        <span class="popup-close" id="popup-account-close">&times;</span>
        <div class="popup-header">
            <h2>Login or Sign Up</h2>
        </div>
        <div class="button-main margin-top-15" id="registerbutton">Sign Up</div>
        <div class="button-main margin-top-15" id="loginbutton">Login</div>
    </div>

    <script>
        document.getElementById('introaccountbutton').addEventListener('click', function () {
            document.getElementById('popup-account').classList.add('active');
            document.getElementById('overlay').classList.add('active');
        });

        document.getElementById('accountbutton').addEventListener('click', function () {
            document.getElementById('popup-account').classList.add('active');
            document.getElementById('overlay').classList.add('active');
        });

        document.getElementById('loginbutton').addEventListener('click', function () {
            let loggedIn = <? php echo isset($_SESSION['loggedIn']) && $_SESSION['loggedIn'] ? 'true' : 'false'; ?>;
            if (loggedIn) {
                window.location.href = 'account.php';
            } else {
                document.getElementById('popup-login').classList.add('active');
                document.getElementById('popup-account').classList.remove('active');
                document.getElementById('overlay').classList.add('active');
            }
        });

        document.getElementById('registerbutton').addEventListener('click', function () {
            document.getElementById('popup').classList.add('active');
            document.getElementById('popup-account').classList.remove('active');
            document.getElementById('overlay').classList.add('active');
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

            fetch('register.php', {
                method: 'POST',
                body: formData
            })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('registration-form').style.display = 'none';
                        document.getElementById('popup-header-text').style.display = 'none';
                        document.getElementById('errorsuccessmessage').innerText = 'You\'ve successfully created a character! We\'ll see you in Gielinor shortly!';
                    } else {
                        document.getElementById('errorsuccessmessage').innerText = data.message;
                    }
                })
                .catch(error => {
                    document.getElementById('errorsuccessmessage').innerText = 'An error occurred.';
                    console.error('Error:', error);
                });
        });
    </script>
    <div class="slide" id="slide1">
        <div class="slide-content">
            <h1>New Maximum Level</h1>
            <p>Ethereal Lands features a new story, quests, areas, monsters and so much more. To tell this new story,
                <b>we've reduced the maximum level you can reach to 66</b>. Don't fret! You'll reach maximum level in no
                time, and we're putting a considerable amount of effort into the development and health of our end-game
                experience! Maximum level will gradually rise with each major expansion release, with the first
                expansion
                set to raise the maximum level to 77.
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
                right from the get-go, using almost all skills and securing your first quest point!
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
    <!--
    <div class="slide" id="slide2">
        <h1>Graveyards</h1>
        <p>Gone are the days of respawning in Lumbridge... at least all the time.<br><br>New to all accessible areas are
            <b>graveyards</b>, respawn points with <i>possible</i> bank access to get you back into what you were doing
            quicker! You may have to complete a task or two in order to get access to these graveyard banks, however.
        </p>
        <h1>New Skill: Huntsman</h1>
        <p>Very similar to the much-beloved Slayer skill, the Huntsman skill focuses on retrieving items or completing
            specific tasks instead of simply killing creatures. Huntsman offers many awesome rewards, and also gives us the
            ability to grant players with items that can help with leveling other skills.<br><br>Rewards for Huntsman
            bounties, or formally acquisitions, are based on the bounty
            given. For example, a bounty to collect rat eyes will reward either gold, an experience lamp or several Eye
            of Newts, based on the player's choice.<br><br>Bounty points are rewarded for fulfilling bounties and can be
            spent for rewards or tossing away a bounty.</p>
    </div>
    <hr>
    <div class="slide" id="slide3">
        <h2>Seasonal Activity:</h2>
        <h1>Ethereal Dungeons</h1>
        <p>Lasting for <b>3 months each</b> (the first lasting longer), an Ethereal Dungeon allows you to enter and
            defeat monsters and bosses to earn a bit of Huntsman experience and <b>epic</b> seasonal
            rewards!<br><br>Ethereal Dungeons are activities that grant cosmetic
            <b>and</b> non-cosmetic, non-tradable rewards.<br><br>Monsters and bosses within the dungeon will <b>scale
                its stats to a player based on their combat level once engaged</b>, but still provide a desirable
            challenge for any worthy adversary! We'll be looking for lots of feedback and ideas on these the first
            go-around, so make sure to post to Discord with your thoughts!
        </p>
        <p>The first Ethereal Dungeon is <b class="epicfont">Crypt of Dread</b>, found in Al'Kharid!</p>
        <h1>Be a Creator!</h1>
        <p>We're going to be providing resources and rewards for anyone looking to take a stab at creating items for
            Ethereal Lands' cosmetic crates. Along with living on in the "examine" text of an item forever, if picked,
            you'll be rewarded for your chosen submission! Don't worry, cosmetic crates are entirely free. While we are
            going to explore paid cosmetics in the store, the cases and
            keys (which we consider gambling) have a chance to drop from all monsters within a specific range of your
            combat level just by playing the game. Cases rotate out yearly and will be discontinued. Rest assured, we
            won't ever sell gambling.</p>
    </div> -->
</body>

</html>