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

  }
?>
