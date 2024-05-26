<div class="topbar">
    <nav class="accountbar">
        <h1 class="accountname"><?php echo $username; ?></h1>
        <div id="navlinks">
            <a href="index">Home</a>
            <a href="account">My Account</a>
            <?php if ($isAdmin): ?>
                <a href="adminpanel">Admin Dashboard</a>
            <?php endif; ?>
            <a href="store">Store</a>
            <a href="logout">Logout</a>
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
        <a class="button-main" href="index">Home</a>
        <a class="button-main" href="account">My Account</a>
        <?php if ($isAdmin): ?>
            <a class="button-main" href="#">Admin Dashboard</a>
        <?php endif; ?>
        <a class="button-main" href="store">Store</a>
        <a class="button-main" href="logout">Logout</a>
    </div>
</div>