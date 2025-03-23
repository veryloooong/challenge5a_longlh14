<?php
  include("../check_auth.php");
  $conn = include("../database.php");
  if (!isset($_POST["password_old"], $_POST["password_new"], $_SESSION["username"])) {
    exit("Missing information");
  }
  $username = $conn->real_escape_string($_SESSION["username"]);

  $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $stmt->bind_param("s", $username);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $stmt->store_result();
  if ($stmt->num_rows != 1) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php?wrong=1");
    exit();
  }

  $stmt->bind_result($id, $password);
  $stmt->fetch();

  if (!password_verify($_POST["password_old"], $password) || $_SESSION["sid"] != $id) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $password_new = password_hash($_POST["password_new"], PASSWORD_DEFAULT);
  $stmt = $conn->prepare("UPDATE users SET password = ? WHERE username = ?");
  $stmt->bind_param("ss", $password_new, $username);
  
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  echo("<script>alert('Đã thay đổi mật khẩu thành công')</script>");
  sleep(2);
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/personal.php");
?>