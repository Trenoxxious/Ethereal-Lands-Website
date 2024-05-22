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

$amount_stmt->close();
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
            <span class="add-souls" id="buysouls">+</span>
        </div>
        <div id="message" class="purchase-message"></div>
    </div>
    <div class="main-account-front">
        <div class="account-store">
            <h1>Shop</h1>
            <?php while ($item = mysqli_fetch_assoc($result)): ?>
                <div class="store-item">
                    <h2><?php echo htmlspecialchars($item['name']); ?></h2>
                    <p class="<?php echo strtolower($item['rarity']); ?>"><?php echo htmlspecialchars($item['rarity']); ?>
                    </p>
                    <p class="price"><?php echo htmlspecialchars($item['price']); ?> <img src="images/soul.png"
                            alt="Ethereal Souls"></p>
                    <form class="purchase-form" method="post">
                        <input type="hidden" name="item_id" value="<?php echo $item['item_id']; ?>">
                        <button type="submit" class="button-main">Buy Item</button>
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
                    $('#message').html(response).css('display', 'block');

                    // Optionally, you can clear the message after a few seconds
                    setTimeout(function () {
                        $('#message').html('').css('display', 'none');
                    }, 5000);
                });
            });
        });
    </script>

</body>

</html>