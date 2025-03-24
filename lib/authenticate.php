<?php
  session_start();

  $conn = include("database.php");

  if (!isset($_POST["username"], $_POST["password"])) {
    exit("Missing username or password");
  }

  $username = $conn->real_escape_string($_POST["username"]);

  $stmt = $conn->prepare("SELECT id, password, is_teacher, email, phone, name_first, name_last FROM users WHERE username = ?");
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

  /* @type int $id
   * @type string $password_hash
   * @type bool $is_teacher
   * @type string $email
   * @type string $phone
   * @type string $name_first
   * @type string $name_last
   */
  $stmt->bind_result($id, $password_hash, $is_teacher, $email, $phone, $name_first, $name_last);
  $stmt->fetch();

  if (!password_verify($_POST["password"], $password_hash)) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php?wrong=1");
    exit();
  }

  session_regenerate_id();
  $_SESSION["sid"] = $id;
  $_SESSION["username"] = $username;
  $_SESSION["is_teacher"] = $is_teacher;
  $_SESSION["email"] = $email;
  $_SESSION["phone"] = $phone;
  $_SESSION["name_first"] = $name_first;
  $_SESSION["name_last"] = $name_last;
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/home.php");
?>