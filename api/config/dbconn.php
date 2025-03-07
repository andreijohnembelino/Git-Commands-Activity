<?php
$servername = "localhost";
$username = ""; // It's best not to hardcode credentials
$password = ""; // It's best not to hardcode credentials
$dbname = "lgu_health";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>