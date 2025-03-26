<?php
  include("../check_auth.php");
  $conn = include("../database.php");
  $stmt = $conn->prepare("SELECT COUNT(*) FROM messages WHERE id = ? AND user_from = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("ii", $_POST["message_id_edit"], $_SESSION["sid"]);
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
  $stmt = $conn->prepare("UPDATE messages SET content = ? WHERE id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $content = stripslashes($_POST["message_content_edit"]);
  $content = $conn->real_escape_string($content);
  $content = htmlspecialchars($content);
  $stmt->bind_param("si", $content, $_POST["message_id_edit"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $username = $conn->real_escape_string($_POST["username"]);
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/users/view.php?username=$username");
  exit();
?>