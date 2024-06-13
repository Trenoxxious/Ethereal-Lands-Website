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
        echo json_encode(['status' => 'success']);
    } else {
        echo json_encode(['status' => 'error']);
    }
}