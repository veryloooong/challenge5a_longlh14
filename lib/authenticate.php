<?php

session_start();

$host = "127.0.0.1";
$user = "user";
$pass = "p@ssw0rd";
$database = "challenge5a_longlh14";

$conn = new mysqli($host, $user, $pass, $database);
if ($conn->connect_error) {
  exit("Error connecting to DB: ". $conn->connect_error);
}

if (!isset($_POST["username"], $_POST["password"])) {
  exit("Missing username or password");
}

$username = $conn->real_escape_string($_POST["username"]);

if ($stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?")) {
  $stmt->bind_param("s", $username);
  if ($stmt->execute()) {
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id, $password_hash);
      $stmt->fetch();
      if (password_verify($_POST["password"], $password_hash)) {
        session_regenerate_id();
        $sid = sprintf("%d%s", $id, $username);
        $_SESSION["sid"] = hash("sha256", $sid);
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/home.php");
      } else {
        header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php?wrong=1");
      }
    } else {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php?wrong=1");
    }
  } else {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
} else {
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
  exit();
}

?>