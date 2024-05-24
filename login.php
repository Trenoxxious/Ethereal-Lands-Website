<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/home/playethe/public_html/error-login.log');

require 'globals.php';

// Start the session
session_start();

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
    $sql = "SELECT id, username, group_id, pass FROM players WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if the password matches
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['pass'])) {
            // Password is correct, store user information in session
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            $_SESSION['accstatus'] = $row['group_id'];
            $_SESSION['loggedIn'] = true;

            // Redirect to account.php
            echo "<div class='success'>Login successful! Redirecting...</div>";
            echo "<script>setTimeout(function(){ window.location.href = 'account.php'; }, 2000);</script>";
        } else {
            echo "<div class='error'>Invalid password.</div>";
        }
    } else {
        echo "<div class='error'>No user found with that username.</div>";
    }

    $stmt->close();
    $conn->close();
}