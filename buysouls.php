<?php
// Start the session
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: index");
    exit;
}

// Include database connection details
require 'globals.php';
require 'siteglobals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Fetch user information from session
$user_id = $_SESSION['user_id'];
$username = $_SESSION['username'];
$accstatus = $_SESSION['accstatus'];

// Fetch the latest amount of ethereal souls from the database
$amount_sql = "SELECT amount FROM etherealsouls WHERE id = ?";
$amount_stmt = $conn->prepare($amount_sql);
$amount_stmt->bind_param("i", $user_id);
$amount_stmt->execute();
$amount_result = $amount_stmt->get_result();

if ($amount_result->num_rows > 0) {
    $amount_row = $amount_result->fetch_assoc();
    $esouls = $amount_row['amount'];
} else {
    $esouls = 0; // Default value if no record is found
}

$formatted_esouls = number_format($esouls);
$isAdmin = isset($_SESSION['accstatus']) && $_SESSION['accstatus'] == 0;

$amount_stmt->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ethereal Lands - Control Panel</title>
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script
        src="https://www.paypal.com/sdk/js?client-id=ASRQTl6GfLMQ8w4GmkRrZKsGz4NdDpJWMPazJl1aaOsRDQWyjU1YzlzDg_8giPUYw8N1b4xLe5dxxbZ4&currency=USD&intent=capture&disable-funding=card"></script>
</head>

<body>
    <?php include 'topbar.php'; ?>
    <div class="accountmain">
        <div class="blanktop"></div>
        <div class="souls">
            <div class="souls-display">
                <?php echo htmlspecialchars($formatted_esouls); ?>
            </div>
            <span class="add-souls" id="buysouls">Buy Souls</span>
        </div>
    </div>
    <div class="main-account-front">
        <div class="account-top">
            <h1 class="page-header">Buy Ethereal Souls</h1>
        </div>
        <div class="souls-packages-list">
            <?php if ($soul_purchase_is_active == false): ?>
                <p class="store-message">The ability to purchase Ethereal Souls has been disabled. The purchase of Ethereal
                    Souls will not be enabled until Ethereal Lands launches later this year.</p>
            <?php else: ?>
                <div class="container">
                    <div class="card_box uncommon">
                        <img src="images/199souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="uncommon">1 Uncommon Cosmetic</b></p>
                        <p class="soulamount">200</p>
                        <div class="button-main purchase-button" id="souls-200" data-amount="200" data-price="1.99">$1.99
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card_box rare">
                        <img src="images/349souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="uncommon">2 Uncommon Cosmetics</b> or <b class="rare">1 Rare Cosmetic</b>
                        </p>
                        <p class="soulamount">400</p>
                        <div class="button-main purchase-button" id="souls-400" data-amount="400" data-price="3.49">$3.49
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card_box epic">
                        <img src="images/599souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="rare">2 Rare Cosmetics</b> or <b class="epic">1 Epic Cosmetic</b>
                        </p>
                        <p class="soulamount">800</p>
                        <div class="button-main purchase-button" id="souls-800" data-amount="800" data-price="5.99">$5.99
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card_box epic">
                        <img src="images/999souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="rare">4 Rare Cosmetics</b> or <b class="epic">2 Epic Cosmetics</b>
                        </p>
                        <p class="soulamount">1,600</p>
                        <div class="button-main purchase-button" id="souls-1600" data-amount="1600" data-price="9.99">$9.99
                        </div>
                    </div>
                </div>
                <div class="container">
                    <div class="card_box artifact">
                        <img src="images/1999souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="epic">4 Epic Cosmetics</b> or <b class="artifact">1 Artifact Cosmetic</b>
                        </p>
                        <p class="soulamount">3,600</p>
                        <div class="button-main purchase-button" id="souls-3600" data-amount="3600" data-price="19.99">
                            $19.99</div>
                    </div>
                </div>
                <div class="container">
                    <div class="card_box artifact">
                        <span></span>
                        <img src="images/4999souls.png" alt="Ethereal Soul">
                        <p>Equivalent to <b class="epic">13 Epic Cosmetics</b> or <b class="artifact">3 Artifact
                                Cosmetics</b>
                        </p>
                        <p class="soulamount">10,800</p>
                        <div class="button-main purchase-button" id="souls-10800" data-amount="10800" data-price="49.99">
                            $49.99</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    <script>
        document.querySelectorAll('.purchase-button').forEach(button => {
            button.addEventListener('click', () => {
                const amount = button.getAttribute('data-amount');
                const price = button.getAttribute('data-price');

                // Remove any existing PayPal button container
                const existingContainer = document.getElementById('paypal-button-container');
                if (existingContainer) {
                    existingContainer.remove();
                }

                // Create a new PayPal button container
                const paypalContainer = document.createElement('div');
                paypalContainer.id = 'paypal-button-container';
                document.body.appendChild(paypalContainer);

                paypal.Buttons({
                    createOrder: function (data, actions) {
                        return actions.order.create({
                            purchase_units: [{
                                amount: {
                                    value: price
                                }
                            }]
                        });
                    },
                    onApprove: function (data, actions) {
                        return actions.order.capture().then(function (details) {
                            fetch('/buysoulstransaction.php', {
                                method: 'post',
                                headers: {
                                    'Content-Type': 'application/json'
                                },
                                body: JSON.stringify({
                                    orderID: data.orderID,
                                    amount: amount
                                })
                            }).then(response => response.json())
                                .then(data => {
                                    if (data.success) {
                                        window.location.href = 'store';
                                    } else {
                                        alert('Transaction failed! Please try again!');
                                    }
                                });
                        });
                    }
                }).render(paypalContainer);

                window.scrollTo({
                    top: document.documentElement.scrollHeight,
                    behavior: 'smooth'
                });
            });
        });
    </script>
</body>

</html>