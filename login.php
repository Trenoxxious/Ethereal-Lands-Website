<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log_login', '/home/playethe/public_html/error-login.log');

// Start the session
session_start();

// Database credentials
$servername = "localhost";
$username = "playethe_root";
$password = "imthebestmany0";
$dbname = "playethe_ethereallands";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT id, pass FROM players WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Check if the password matches
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['pass'])) {
            // Password is correct, start the session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: account.php");
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found with that character name.";
    }

    $conn->close();
}