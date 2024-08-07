<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index");
    exit;
}

// Include database connection details
require '../globals.php';

// Fetch user information from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$accstatus = $_SESSION['accstatus'];

$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Ethereal Lands - Support</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="../script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
</head>

<body>
    <?php include 'topbar.php'; ?>
    <div class="accountmain">
        <div class="blanktop"></div>
    </div>
    <div class="main-account-front">
        <div class="account-top">
            <h1 class="page-header">Ethereal Support (<?php echo htmlspecialchars($username); ?>)</h1>
            <button class="button-main button-main-red" id="report-server-offline">Report Game Server Offline</button>
            <p class="page-info">Submit a support ticket to get assistance with a character-specific issue, account
                issue or in-game issue. Tickets
                are usually answered within 30 minutes, but can sometimes take up to 24 hours.</p>
            <p class="page-info">Your character name and player ID is automatically provided in the ticket, so it is not
                necessary to include.</p>
        </div>
        <div class="account-support">
            <div class="form-sec">
                <form id="support-form" method="post" class="ticket-form" action="scripts/send_support_ticket.php">
                    <label for="email">Your Email Address <span style="color=red;">*</span></label>
                    <input type="email" id="email" name="email" required><br><br>

                    <label for="subject">Ticket Subject <span style="color=red;">*</span></label>
                    <input type="text" id="subject" name="subject" required><br><br>

                    <label for="message">Ticket Description <span style="color=red;">*</span></label>
                    <textarea id="message" name="message" required></textarea><br><br>

                    <input class="button-main" type="submit" name="submit" value="Submit">
                </form>
            </div>
            <div id="support-message-response" class="support-message"></div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('#support-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the default form submission
                $.ajax({
                    url: '../scripts/send_support_ticket.php',
                    type: 'POST',
                    data: $(this).serialize(),
                    success: function (response) {
                        $('#support-message-response').html('Ticket submitted successfully!');
                        $('.support-message').css('visibility', 'visible');
                        $('.form-sec').hide();
                        setTimeout(() => {
                            $('.support-message').css('visibility', 'hidden');
                        }, 2000); // Hide the message box after 2 seconds
                    },
                    error: function (xhr, status, error) {
                        $('#support-message-response').html('An error occurred: ' + xhr.responseText);
                        $('.support-message').css('visibility', 'visible');
                        setTimeout(() => {
                            $('.support-message').css('visibility', 'hidden');
                        }, 2000); // Hide the message box after 2 seconds
                    }
                });
            });
        });
        $('#report-server-offline').on('click', function (event) {
            event.preventDefault();
            $.ajax({
                url: '../scripts/server_offline.php',
                type: 'POST',
                success: function (response) {
                    $('#support-message-response').html(response.message);
                    $('.support-message').css('visibility', 'visible');
                    setTimeout(() => {
                        $('.support-message').css('visibility', 'hidden');
                    }, 5000);
                },
                error: function (xhr, status, error) {
                    $('#support-message-response').html('An error occurred: ' + xhr.responseText);
                    $('.support-message').css('visibility', 'visible');
                    setTimeout(() => {
                        $('.support-message').css('visibility', 'hidden');
                    }, 5000);
                }
            });
        });
    </script>
</body>

</html>