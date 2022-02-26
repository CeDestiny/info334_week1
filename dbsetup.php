<?php
/*
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "nbastats";
*/

$servername = "dbweek1.celdz2ekldnz.us-east-1.rds.amazonaws.com";
$username = "admin";
$password = "week1password";
$dbname = "nbastats";
$port = 3306;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);
// Check connection
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

?>