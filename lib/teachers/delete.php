<?php
  include("../check_auth.php");

  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }

  /* @type mysqli $conn */
  $conn = include("../database.php");
  $stmt = $conn->prepare("DELETE FROM users WHERE is_teacher = 0 AND username = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("s", $conn->real_escape_string($_POST["student_username"]));
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/teachers/manage.php");
?>