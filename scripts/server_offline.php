<?php
// Start the session
session_start();

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
ini_set('log_errors', 1);
ini_set('error_log', '/home/playethe/public_html/error.log');

header('Content-Type: application/json');

require '../globals.php';

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    echo json_encode(['status' => 'error', 'message' => "Connection failed: " . $conn->connect_error]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $last_run = @filemtime(__FILE__);
    $current_time = time();
    $time_diff = $current_time - $last_run;

    if ($time_diff >= 600) { // 10 minutes in seconds
        $to = 'support@playethereallands.com';
        $headers = "MIME-Version: 1.0\r\n";
        $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
        $headers .= 'From: noreply@playethereallands.com' . "\r\n" .
            'Reply-To: support@playethereallands.com' . "\r\n" .
            'X-Mailer: PHP/' . phpversion();
        $subject = 'Report of Server Offline!';
        $message = "The server has been reported as being offline. Please address this issue in Putty to restore server access for Ethereal Lands.
            ";
        if (mail($to, $subject, $message, $headers)) {
            echo json_encode(['status' => 'error', 'message' => 'Thank you for reporting the server as offline. A notification has been sent to the support team to get it back online as soon as possible.']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'There was an issue reporting the server. Please try again later.']);
        }
    } else {
        echo json_encode(['status' => 'error', 'message' => 'The server has been reported as offline less than 10 minutes ago. Our support team is currently aware of the issue and working to resolve it as soon as possible. Remaining: ' . $time_diff]);
    }
}