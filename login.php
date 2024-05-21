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

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from database
    $sql = "SELECT id, username, pass FROM players WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Check if the password matches
        $row = $result->fetch_assoc();

        if (password_verify($password, $row['pass'])) {
            // Password is correct, fetch the amount from etherealsouls table
            $player_id = $row['id'];
            $amount_sql = "SELECT amount FROM etherealsouls WHERE id = ?";
            $amount_stmt = $conn->prepare($amount_sql);
            $amount_stmt->bind_param("i", $player_id);
            $amount_stmt->execute();
            $amount_result = $amount_stmt->get_result();

            if ($amount_result->num_rows > 0) {
                $amount_row = $amount_result->fetch_assoc();
                $amount = $amount_row['amount'];

                // Store user information in session
                $_SESSION['user_id'] = $row['id'];
                $_SESSION['username'] = $row['username'];
                $_SESSION['amount'] = $amount;
                $_SESSION['loggedIn'] = true;

                // Redirect to account.php
                header("Location: account");
                exit;
            } else {
                echo "No corresponding record found in etherealsouls.";
            }

            $amount_stmt->close();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
    $conn->close();
}
?>