<?php
  include("../check_auth.php");
  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }
  if ($_POST["password"] != $_POST["password_confirm"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+yêu+cầu");
    exit();
  }
  $conn = include("../database.php");
  
  $stmt = $conn->prepare("INSERT INTO users (username, password, is_teacher, email, phone, name_first, name_last) VALUES (?, ?, 0, ?, ?, ?, ?)");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param(
    "ssssss",
    $conn->real_escape_string($_POST["username"]),
    password_hash($_POST["password"], PASSWORD_DEFAULT),
    $conn->real_escape_string($_POST["email"]),
    $conn->real_escape_string($_POST["phone"]),
    $conn->real_escape_string($_POST["name_first"]),
    $conn->real_escape_string($_POST["name_last"]),
  );
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/teachers/manage.php");
?>