<?php
  include("../check_auth.php");
  if ($_POST["user_to"] == $_SESSION["sid"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/users.php");
    exit();
  }
  $conn = include("../database.php");
  $content = stripslashes($_POST["message_content"]);
  $content = $conn->real_escape_string($content);
  $content = htmlspecialchars($content);

  $stmt = $conn->prepare("INSERT INTO messages (content, user_from, user_to) VALUES (?, ?, ?)");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("sii", $content, $_SESSION["sid"], $_POST["user_to"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $username = $conn->real_escape_string($_POST["username"]);
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/users/view.php?username=$username");
  exit();
?>