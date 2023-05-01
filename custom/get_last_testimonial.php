<?php
// Connect to MySQL database
$servername = "localhost";
$username = "u578755924_mirazondepeso";
$password = "cmXoasys03";
$dbname = "u578755924_mirazondepeso";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve last record from MySQL table
$sql = "SELECT testimonial FROM jj19p_joomtestimonials ORDER BY id DESC LIMIT 1";
$result = $conn->query($sql);

// Format result as JSON and return to AJAX call
$row = $result->fetch_assoc();
echo json_encode($row);

$conn->close();
