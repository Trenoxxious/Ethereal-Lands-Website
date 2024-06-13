<div class="topbar">
    <nav class="accountbar">
        <h1 class="accountname"><?php echo $username; ?></h1>
        <div id="navlinks">
            <a href="account">Home</a>
            <a href="challenges">Daily Challenges</a>
            <?php if ($isAdmin): ?>
                <a href="adminpanel">Admin Dashboard</a>
            <?php endif; ?>
            <a href="store void-font">The Void</a>
            <a href="index">Game Page</a>
            <a href="support">Support</a>
            <a href="scripts/logout">Logout</a>
        </div>
        <div id="menuexpand">
            <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="#FFFFFF">
                <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
            </svg>
        </div>
    </nav>
    <div id="expandedmenu">
        <div id="menuclose">
            <svg xmlns="http://www.w3.org/2000/svg" height="40px" viewBox="0 -960 960 960" width="40px" fill="#FFFFFF">
                <path d="M673-446.67H160v-66.66h513l-240-240L480-800l320 320-320 320-47-46.67 240-240Z" />
            </svg>
        </div>
        <a class="button-main" href="account">Home</a>
        <a class="button-main" href="challenges">Daily Challenges</a>
        <?php if ($isAdmin): ?>
            <a class="button-main" href="adminpanel">Admin Dashboard</a>
        <?php endif; ?>
        <a class="button-main void-font" href="store"
            style="border: 1px solid transparent; animation: rotate-hue 5s infinite linear;">The
            Void</a>
        <a class="button-main" href="index">Game Page</a>
        <a class="button-main" href="support" id="support-button">Character Support</a>
        <a class="button-main" href="scripts/logout">Logout</a>

        <style>
            @keyframes rotate-hue {
                0% {
                    border-color: #8b00ff;
                }

                25% {
                    border-color: #6a00ff;
                }

                50% {
                    border-color: #9370db;
                }

                75% {
                    border-color: #ba55d3;
                }

                100% {
                    border-color: #8b00ff;
                }
            }
        </style>

    </div>
</div>