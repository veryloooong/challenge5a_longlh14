<?php
  include("../check_auth.php"); 
  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }
  if (!isset($_FILES["homework_files"]["error"])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  
  // check
  $target_dir = "../../uploads/teachers/";
  for ($i = 0; $i < count($_FILES["homework_files"]["name"]); $i++) {
    if ($_FILES["homework_files"]["error"][$i] != UPLOAD_ERR_OK) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+tạo+file");
      exit();
    }
    // limit file size 5MB
    if ($_FILES["homework_files"]["size"][$i] > 5000000) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=File+quá+lớn");
      exit();
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES["homework_files"]["tmp_name"][$i]);
    finfo_close($finfo);
    if ($mime_type !== 'application/pdf') {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Định+dạng+không+hợp+lệ");
      exit();
    }
    $target_file = $target_dir . basename($_FILES["homework_files"]["name"][$i]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_type != "pdf") {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Định+dạng+không+hợp+lệ");
      exit();
    }
  }
  // upload
  $uploaded_files = array();
  for ($i = 0; $i < count($_FILES["homework_files"]["name"]); $i++) {
    $hash = sha1_file($_FILES["homework_files"]["tmp_name"][$i]);
    $target_file = $target_dir . $hash . '.pdf';
    if (!move_uploaded_file($_FILES["homework_files"]["tmp_name"][$i], $target_file)) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+tạo+file");
      exit();
    }
    $uploaded_files[] = "/uploads/teachers/" . $hash . '.pdf';
  }

  // add to db
  $conn = include("../database.php");
  $stmt = $conn->prepare("INSERT INTO homework (title, description) VALUES (?, ?)");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("ss", $_POST["title"], $_POST["description"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $homework_id = $conn->insert_id;
  foreach ($uploaded_files as $file) {
    $stmt = $conn->prepare("INSERT INTO homework_files (assignment_id, path) VALUES (?, ?)");
    if (!$stmt) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
    $stmt->bind_param("is", $homework_id, $file);
    if (!$stmt->execute()) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
  }

  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/teachers/homework.php");
?>