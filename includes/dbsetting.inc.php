<?php
$dbServer = "localhost";
$dbUsername = "root";
$dbPassword = "";
$dbName = "gograb";

$conn = new mysqli($dbServer, $dbUser, $dbPassword, $dbName);

if (!$conn) {
    die("Failed to connect to database. Error: " . mysqli_connect_error());
}