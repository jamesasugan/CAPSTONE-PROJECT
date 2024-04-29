<?php
$host = "localhost";
$username = "root";
$database = "hcmccapstone_db";

$conn = new mysqli($host, $username, '', $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
