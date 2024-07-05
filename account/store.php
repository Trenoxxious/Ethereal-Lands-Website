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
require '../siteglobals.php';

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

$query = "SELECT * FROM etherealitems WHERE is_active = 1";
$result = mysqli_query($conn, $query);

$purchased_items_sql = "SELECT item_id FROM user_purchases WHERE user_id = ?";
$purchased_stmt = $conn->prepare($purchased_items_sql);
$purchased_stmt->bind_param("i", $user_id);
$purchased_stmt->execute();
$purchased_result = $purchased_stmt->get_result();

$purchased_items = [];
while ($row = $purchased_result->fetch_assoc()) {
    $purchased_items[] = $row['item_id'];
}

$amount_stmt->close();
$purchased_stmt->close();
$conn->close();
?>

<!DOCTYPE html>

<html>

<head>
    <title>Ethereal Lands - Void Merchant</title>
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
        <div class="souls">
            <div class="souls-display">
                <?php echo htmlspecialchars($formatted_esouls); ?>
            </div>
            <span class="add-souls" id="buysouls">Buy Souls</span>
        </div>
    </div>
    <div class="purchase-message" id="message"></div>
    <div class="main-account-front">
        <div class="section-header">
            <h1 class="page-header void-font" id="void-merchant"
                style="color: transparent; animation: rotate-hue-color 3s infinite linear;">The Void Merchant
            </h1>
            <?php if ($store_is_active == false): ?>
                <p class="important-message">The Void Merchant has left town. The purchase of cosmetic items will not be
                    enabled until Ethereal Lands launches later this year.</p>
            <?php endif; ?>
        </div>
        <div class="account-store">
            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                <?php $purchased = in_array($item['item_id'], $purchased_items); ?>
                <div class="store-item <?php echo strtolower($item['rarity']); ?>-border">
                    <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                    <img src="images/store-items/<?php echo $item['item_id']; ?>.png" alt="<?php echo $item['name']; ?>">
                    <p class="<?php echo strtolower($item['rarity']); ?>-background">
                        <?php echo htmlspecialchars($item['rarity']); ?> Cosmetic
                    </p>
                    <p class="price"><?php echo htmlspecialchars($item['price']); ?> <img src="images/soul.png"
                            alt="Ethereal Souls"></p>
                    <form class="purchase-form" method="post">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button type="submit" class="button-main" <?php echo $purchased || $store_is_active == false ? 'disabled' : ''; ?>>
                            <?php if ($purchased): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="26px" viewBox="0 -960 960 960" width="26px"
                                    fill="#6ffd6f">
                                    <path d="M389-267 195-460l51-52 143 143 325-324 51 51-376 375Z" />
                                </svg>
                                <span style="color: #6ffd6f">Owned!</span>
                            <?php else: ?>
                                Buy Cosmetic
                            <?php endif; ?>
                        </button>
                    </form>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            $('.purchase-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting the traditional way
                var formData = $(this).serialize();
                $.post('scripts/purchase.php', formData, function (response) {
                    // Display the response message
                    $('#message').html(response);
                    $('.purchase-message').css('visibility', 'visible');

                    // Optionally, you can clear the message after a few seconds
                    setTimeout(function () {
                        $('#message').html('');
                        $('.purchase-message').css('visibility', 'hidden');
                    }, 2000);
                });
            });

            $('#soul-purchase-form').on('submit', function (event) {
                event.preventDefault(); // Prevent the form from submitting the traditional way
                var formData = $(this).serialize();
                $.post('purchase_souls.php', formData, function (response) {
                    // Display the response message
                    $('#message').html(response);
                    $('.purchase-message').css('visibility', 'visible');

                    // Optionally, you can clear the message after a few seconds
                    setTimeout(function () {
                        $('#message').html('');
                        $('.purchase-message').css('visibility', 'hidden');
                    }, 2000);
                });
            });
        });
    </script>

</body>

</html>