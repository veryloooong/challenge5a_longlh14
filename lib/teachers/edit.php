<?php
  include("../check_auth.php");
  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }

  $conn = include("../database.php");

  $name_first = preg_replace("/[^[:alnum:][:space:]]/u", '', $_POST["name_first_edit"]);
  $name_last = preg_replace("/[^[:alnum:][:space:]]/u", '', $_POST["name_last_edit"]);

  $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ?, name_first = ?, name_last = ? WHERE is_teacher = 0 AND username = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param(
    "sssss",
    $conn->real_escape_string($_POST["email_edit"]),
    $conn->real_escape_string($_POST["phone_edit"]),
    $name_first,
    $name_last,
    $conn->real_escape_string($_POST["username_edit"]),
  );
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/teachers/manage.php");
?>