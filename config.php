<?php
if (session_status() == PHP_SESSION_NONE) {
    // Start the session if it's not already started
    session_start();
}
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "My_Inventory";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


?>
