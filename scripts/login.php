<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log_login', '/home/playethe/public_html/error-login.log');

require '../globals.php';

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

    $sql = "SELECT p.id, p.username, p.group_id, p.skill_total, p.bounty_points, p.combat, p.pass, 
    e.total_dailies_completed
    FROM players p
    LEFT JOIN etherealsouls e ON p.id = e.id
    WHERE p.username = ?";

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
            $_SESSION['skill_total'] = $row['skill_total'];
            $_SESSION['bounty_points'] = $row['bounty_points'];
            $_SESSION['combat_level'] = $row['combat'];
            $_SESSION['accstatus'] = $row['group_id'];
            $_SESSION['loggedIn'] = true;
            
            // Add the total_dailies_completed to the session
            $_SESSION['total_dailies_completed'] = $row['total_dailies_completed'] ?? 0;

            // Check if user has an entry in etherealsouls table, if not, make one
            $sql = "SELECT id FROM etherealsouls WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $row['id']);
            $stmt->execute();
            $result = $stmt->get_result();

            if ($result->num_rows == 0) {
                // Insert new entry for user in etherealsouls table
                $stmt = $conn->prepare("INSERT INTO etherealsouls (id, amount) VALUES (?, 0)");
                if (!$stmt) {
                    throw new Exception("Prepare failed (INSERT into etherealsouls): " . $conn->error);
                }
                $stmt->bind_param("i", $row['id']);
                if (!$stmt->execute()) {
                    throw new Exception("Execute failed (INSERT into etherealsouls): " . $stmt->error);
                }
                $stmt->close();
            }

            // Redirect to account.php
            echo json_encode(['status' => 'success', 'message' => 'Login successful! Taking you to your account...']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Invalid password. Please try again.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No character found with that username.']);
    }

    $stmt->close();
    $conn->close();
}