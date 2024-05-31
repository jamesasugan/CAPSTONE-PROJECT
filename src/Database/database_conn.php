<?php
$host = "localhost";
$username = "root";
$database = "hcmccapstone_dbrevised";

$conn = new mysqli($host, $username, '', $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
