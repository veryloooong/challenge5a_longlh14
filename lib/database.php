<?php
$host = "127.0.0.1";
$user = "user";
$pass = "p@ssw0rd";
$database = "challenge5a_longlh14";

$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
  exit("Error connecting to DB: ". $conn->connect_error);
}

return $conn;
?>