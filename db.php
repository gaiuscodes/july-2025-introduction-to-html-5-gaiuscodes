<?php
$host = 'localhost';
$user = 'root';
$password = '';
$port = '3307';
$dbname = 'portfolio';

$conn = new mysqli($host, $user, $password, $dbname, $port);

if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
