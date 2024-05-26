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

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Read POST data
    $json = file_get_contents('php://input');
    $data = json_decode($json);

    if (isset($data->orderID) && isset($data->amount)) {
        // Validate the PayPal order
        $orderID = $data->orderID;
        $amount = intval($data->amount);

        $clientId = 'ASRQTl6GfLMQ8w4GmkRrZKsGz4NdDpJWMPazJl1aaOsRDQWyjU1YzlzDg_8giPUYw8N1b4xLe5dxxbZ4';
        $clientSecret = 'EK3tMgDeslaXxMNU2tDBqcOr4Jgy3j5WC1MMPgfSfjoKk1SywDE0z--MQ-rAD4P5Dha0ClD6lzEDkXkp';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, "https://api-m.sandbox.paypal.com/v2/checkout/orders/$orderID");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Content-Type: application/json',
            'Authorization: Basic ' . base64_encode("$clientId:$clientSecret")
        ]);
        $response = curl_exec($ch);
        curl_close($ch);

        $response = json_decode($response);

        if ($response && $response->status === 'COMPLETED') {
            // Prepare an SQL statement to insert or update the etherealsouls table
            $stmt = $conn->prepare("INSERT INTO etherealsouls (id, amount) VALUES (?, ?) 
                                    ON DUPLICATE KEY UPDATE amount = amount + VALUES(amount)");
            $stmt->bind_param("ii", $user_id, $amount);

            if ($stmt->execute()) {
                echo json_encode(['success' => true]);
            } else {
                echo json_encode(['success' => false, 'error' => $stmt->error]);
            }

            $stmt->close();
        } else {
            echo json_encode(['success' => false, 'error' => 'Invalid PayPal order.']);
        }
    } else {
        echo json_encode(['success' => false, 'error' => 'Invalid request.']);
    }
} else {
    echo json_encode(['success' => false, 'error' => 'Invalid request method.']);
}
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - Control Panel</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://www.paypal.com/sdk/js?client-id=YOUR_PAYPAL_CLIENT_ID&currency=USD"></script>
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
        <h1 class="page-header">Buy Ethereal Souls</h1>
        <div class="souls-packages-list">
            <div class="container">
                <div class="card_box uncommon">
                    <img src="images/199souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="uncommon">1 Uncommon Cosmetic</b></p>
                    <p class="soulamount">200</p>
                    <div class="button-main" id="paypal-button-200">$1.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box rare">
                    <img src="images/349souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="uncommon">2 Uncommon Cosmetics</b> or <b class="rare">1 Rare Cosmetic</b>
                    </p>
                    <p class="soulamount">400</p>
                    <div class="button-main" id="paypal-button-400">$3.49</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box epic">
                    <img src="images/599souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">2 Rare Cosmetics</b> or <b class="epic">1 Epic Cosmetic</b>
                    </p>
                    <p class="soulamount">800</p>
                    <div class="button-main" id="paypal-button-800">$5.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box epic">
                    <img src="images/999souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="rare">4 Rare Cosmetics</b> or <b class="epic">2 Epic Cosmetics</b>
                    </p>
                    <p class="soulamount">1,600</p>
                    <div class="button-main" id="paypal-button-1600">$9.99</div>
                </div>
            </div>
            <div class="container">
                <div class="card_box artifact">
                    <img src="images/1999souls.png" alt="Ethereal Soul">
                    <p>Equivalent to <b class="epic">4 Epic Cosmetics</b> or <b class="artifact">1 Artifact
                            Cosmetic</b>
                    </p>
                    <p class="soulamount">3,600</p>
                    <div class="button-main" id="paypal-button-3600">$19.99</div>
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
                    <div class="button-main" id="paypal-button-10800">$49.99</div>
                </div>
            </div>
        </div>
    </div>
    <script>
        // PayPal button for 200 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '1.99'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 200
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-200');

        // PayPal button for 400 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '3.49'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 400
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-400');

        // PayPal button for 800 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '5.99'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 800
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-800');

        // PayPal button for 1600 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '9.99'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 1600
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-1600');

        // PayPal button for 3600 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '19.99'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 3600
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-3600');

        // PayPal button for 3600 souls package
        paypal.Buttons({
            createOrder: function (data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '49.99'
                        }
                    }]
                });
            },
            onApprove: function (data, actions) {
                return actions.order.capture().then(function (details) {
                    // Call your server to save the transaction
                    fetch('/buysouls.php', {
                        method: 'post',
                        headers: {
                            'content-type': 'application/json'
                        },
                        body: JSON.stringify({
                            orderID: data.orderID,
                            amount: 10800
                        })
                    }).then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                alert('Transaction completed by ' + details.payer.name.given_name);
                            } else {
                                alert('Transaction failed');
                            }
                        });
                });
            }
        }).render('#paypal-button-10800');

        // Repeat for other packages with different amounts and prices
    </script>
</body>

</html>