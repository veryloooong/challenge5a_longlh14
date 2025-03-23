<?php
  include("../check_auth.php");
  $conn = include("../database.php");
  $username = $conn->real_escape_string($_SESSION["username"]);
  $email = $conn->real_escape_string($_POST["email"]);
  $phone = $conn->real_escape_string($_POST["phone"]);

  $stmt = $conn->prepare("UPDATE users SET email = ?, phone = ? WHERE username = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $stmt->bind_param("sss", $email, $phone, $username);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  
  $_SESSION["email"] = $email;
  $_SESSION["phone"] = $phone;

  echo("<script>alert('Đã cập nhật thông tin thành công')</script>");
  sleep(2);
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/personal.php");
?>