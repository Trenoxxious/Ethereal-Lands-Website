<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Updates</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account/account.css?ver=<?= time(); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
    <div class="mainupdate-container" style="display: inline-block;">
        <a href="/game_updates/kaniani_island">
            <div class="mainupdate">
                <img src="images/updates/mainupdate_tutisland.png" alt="Explore a new, packed tutorial island!"
                    style="width: 100%; height: 100%; object-fit: contain;">
            </div>
        </a>
    </div>
    <div id="updateList" class="updatelist">
        <!-- Updates loaded here -->
    </div>
    <div id="loadingIndicator" style="display: none;">Loading more updates...</div>

    <?php include 'footer.php'; ?>

    <script>
        let page = 1;
        let loading = false;

        function loadUpdates() {
            if (loading) return;
            loading = true;
            $('#loadingIndicator').show();

            $.ajax({
                url: 'get_updates.php',
                method: 'GET',
                data: { page: page },
                success: function(response) {
                    if (response.trim() === '') {
                        $('#loadingIndicator').hide();
                    } else {
                        $('#updateList').append(response);
                        page++;
                        loading = false;
                        $('#loadingIndicator').hide();
                    }
                },
                error: function() {
                    $('#loadingIndicator').text('Error loading updates. Please try again.');
                    loading = false;
                }
            });
        }

        $(document).ready(function() {
            loadUpdates(); // Load initial updates

            $(window).scroll(function() {
                if ($(window).scrollTop() + $(window).height() > $(document).height() - 100) {
                    loadUpdates();
                }
            });

            // Event delegation for update box clicks
            $('#updateList').on('click', '.updatebox', function() {
                const updatecontent = $(this).find('.updatecontent');
                updatecontent.slideToggle("fast", "swing");
            });
        });
    </script>
</body>

</html>