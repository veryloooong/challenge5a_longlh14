<?php

session_start();

$conn = include("database.php");

if (!isset($_POST["username"], $_POST["password"])) {
  exit("Missing username or password");
}

$username = $conn->real_escape_string($_POST["username"]);

if ($stmt = $conn->prepare("SELECT id, password, is_teacher, email, phone, name_first, name_last FROM users WHERE username = ?")) {
  $stmt->bind_param("s", $username);
  if ($stmt->execute()) {
    $stmt->store_result();
    if ($stmt->num_rows == 1) {
      $stmt->bind_result($id, $password_hash, $is_teacher, $email, $phone, $name_first, $name_last);
      $stmt->fetch();
      if (password_verify($_POST["password"], $password_hash)) {
        session_regenerate_id();
        $_SESSION["sid"] = $id;
        $_SESSION["username"] = $username;
        $_SESSION["is_teacher"] = $is_teacher;
        $_SESSION["email"] = $email;
        $_SESSION["phone"] = $phone;
        $_SESSION["name_first"] = $name_first;
        $_SESSION["name_last"] = $name_last;
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