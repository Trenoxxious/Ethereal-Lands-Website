<?php
// Database credentials
$servername = "localhost"; //3306 is the port if needed
$username = "playethe_root";
$password = "imthebestmany0";
$dbname = "playethe_ethereallands";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Query to select id from players table
$sql = "SELECT id FROM players";
$result = $conn->query($sql);

// Check if there are results
if ($result->num_rows > 0) {
    // Output data of each row
    while($row = $result->fetch_assoc()) {
        echo "id: " . $row["id"]. "<br>";
    }
} else {
    echo "0 results";
}

// Close connection
$conn->close();
?>
