<?php
require "dbsetting.php";

$conn = new mysqli($dbServer, $dbUsername, $dbPassword, $dbName);

if (!$conn) {
    die("Failed to connect to database. Error: " . mysqli_connect_error());
}
