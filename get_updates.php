<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log_login', '/home/playethe/public_html/error-login.log');

require 'globals.php';

// Start the session
session_start();

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the page number from the AJAX request
$page = isset($_GET['page']) ? intval($_GET['page']) : 1;
$perPage = 5; // Number of updates per page

// Fetch updates from the database
$stmt = $dbname->prepare("SELECT * FROM updates ORDER BY date DESC LIMIT :limit OFFSET :offset");
$stmt->bindValue(':limit', $perPage, PDO::PARAM_INT);
$stmt->bindValue(':offset', ($page - 1) * $perPage, PDO::PARAM_INT);
$stmt->execute();
$updates = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Generate HTML for updates
foreach ($updates as $update) {
    echo '<div class="updatebox">';
    echo '<div class="updatetop">';
    echo '<div class="updateimage"><img src="' . htmlspecialchars($update['image_url']) . '" alt="update image"></div>';
    echo '<div class="updatebartop">';
    echo '<p class="updatedate">' . htmlspecialchars($update['date']) . '</p>';
    echo '<div class="updatetitle">' . htmlspecialchars($update['title']) . '</div>';
    echo '<div class="patchnumber">' . htmlspecialchars($update['patch_number']) . '</div>';
    echo '<p class="updatesummary">' . htmlspecialchars($update['summary']) . '</p>';
    echo '</div>';
    echo '</div>';
    echo '<div class="updatecontent">' . $update['content'] . '</div>';
    echo '</div>';
}