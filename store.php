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

$query = "SELECT * FROM etherealitems";
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
    <title>Ethereal Lands - My Account</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="main.css?ver=<?= time(); ?>">
    <link rel="stylesheet" href="account.css?ver=<?= time(); ?>">
    <script defer src="script.js?ver=<?= time(); ?>"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>

<body>
    <div class="topbar">
        <nav class="accountbar">
            <h1 class="accountname"><?php echo $username; ?></h1>
            <div id="navlinks">
                <a href="index">Home</a>
                <a href="account">My Account</a>
                <?php if ($isAdmin): ?>
                    <a href="#">Admin Dashboard</a>
                <?php endif; ?>
                <a href="store">Store</a>
                <a href="logout">Logout</a>
            </div>
            <div id="menuexpandaccount">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px"
                    fill="#FFFFFF">
                    <path d="M120-240v-80h720v80H120Zm0-200v-80h720v80H120Zm0-200v-80h720v80H120Z" />
                </svg>
            </div>
        </nav>
        <div id="expandedmenuaccount">
            <a href="index">Home</a>
            <a href="account">My Account</a>
            <?php if ($isAdmin): ?>
                <a href="#">Admin Dashboard</a>
            <?php endif; ?>
            <a href="store">Store</a>
            <a href="logout">Logout</a>
        </div>
    </div>
    <div class="accountmain">
        <div class="blanktop"></div>
        <div class="souls">
            <div class="souls-display">
                <?php echo htmlspecialchars($formatted_esouls); ?>
            </div>
            <span class="add-souls" id="buysouls">Buy More</span>
        </div>
        <div id="message" class="purchase-message"></div>
    </div>
    <div class="main-account-front">
        <div class="store-header">
            <h1 class="page-header">Shop</h1>
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
                        <button type="submit" class="button-main" <?php echo $purchased ? 'disabled' : ''; ?>>
                            <?php if ($purchased): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" height="30px" viewBox="0 -960 960 960" width="30px"
                                    fill="#6ffd6f">
                                    <path d="M389-267 195-460l51-52 143 143 325-324 51 51-376 375Z" />
                                </svg>
                                Owned!
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
                $.post('purchase.php', formData, function (response) {
                    // Display the response message
                    $('#message').html(response);
                    $('.purchase-message').css('visibility', 'visible');

                    // Optionally, you can clear the message after a few seconds
                    setTimeout(function () {
                        $('#message').html('');
                        $('.purchase-message').css('visibility', 'hidden');
                    }, 5000);
                });
            });
        });
    </script>

</body>

</html>