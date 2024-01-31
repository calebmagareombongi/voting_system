<?php

// Connection information
$host = "mysql-3243c5eb-calebmagareombongi-16ac.a.aivencloud.com";
$port = 10068;
$dbname = "defaultdb";
$user = "avnadmin";
$password = "AVNS_BRhBTq5jTQ7lEwDiIv1"; // Replace this with the actual password

// Create a MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Return the MySQLi connection object
return $conn;
?>
