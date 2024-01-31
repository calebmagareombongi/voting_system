<?php

// Connection information
$host = "host_name";
$port = my-port;
$dbname = "my-db";
$user = "my_user_name";
$password = "my_password"; // Replace this with the actual password

// Create a MySQLi connection
$conn = new mysqli($host, $user, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Return the MySQLi connection object
return $conn;
?>
