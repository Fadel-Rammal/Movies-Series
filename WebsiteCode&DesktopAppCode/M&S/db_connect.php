<?php
$server = "localhost";
$un = "root";
$password = "";
$dbname = "Movies&Series";

$connection = new mysqli($server, $un, $password, $dbname);

if ($connection->connect_error) {
    die("connection failed: " . $connection->connect_error);
}

?>