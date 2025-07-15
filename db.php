<?php
$host = 'localhost';
$user = 'root';
$pass = 'K@mikaze3290';
$dbname = 'lifechoicesshop';

$conn = new mysqli($host, $user, $pass, $dbname);
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>