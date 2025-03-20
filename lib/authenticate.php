<?php

$host = "127.0.0.1";
$username = "user";
$password = "p@ssw0rd";
$database = "challenge5a_longlh14";

$conn = new mysqli($host, $username, $password, $database);
if ($conn->connect_error) {
  exit("Error connecting to DB: ". $conn->connect_error);
}

echo("f u");

?>