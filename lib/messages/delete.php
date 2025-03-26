<?php
  include("../check_auth.php");
  $conn = include("../database.php");
  $stmt = $conn->prepare("SELECT COUNT(*) FROM messages WHERE id = ? AND user_from = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("ii", $_POST["message_id_delete"], $_SESSION["sid"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_result($count);
  $stmt->fetch();
  if ($count !== 1) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Tin+nhắn+không+tồn+tại");
    exit();
  }
  $stmt->close();
  $stmt = $conn->prepare("DELETE FROM messages WHERE id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $_POST["message_id_delete"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $username = $conn->real_escape_string($_POST["username"]);
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/users/view.php?username=$username");
  exit();
?>