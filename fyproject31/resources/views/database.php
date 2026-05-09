<?php
$server = "sql131.infinityfree.com";
$username = "if0_38003918";
$password = "";  // Add your database password here
$dbname = "if0_38003918_abtestdb007";

// Create connection using MySQLi
$conn = mysqli_connect($server, $username, $password, $dbname);

// Check connection
if(!$conn) {
    die("Connection Failed: " . mysqli_connect_error());
}

// Optional: Set charset to avoid encoding issues
mysqli_set_charset($conn, "utf8");

// Your code continues here...
?>