<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "student_scores";

// Create connection
$conn = new mysqli($host, $user, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
