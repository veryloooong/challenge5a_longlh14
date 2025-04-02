<?php
  include("../check_auth.php");
  if (!isset($_SESSION["is_teacher"]) || $_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }

  // check alr submit
  $conn = include("../database.php");
  $stmt = $conn->prepare("SELECT COUNT(*) FROM submissions WHERE assignment_id = ? AND student_id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("ii", $_POST["assignment_id"], $_SESSION["sid"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $result = 0;
  $stmt->bind_result($result);
  $stmt->fetch();
  if ($result > 0) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Đã+nộp+bài");
    exit();
  }
  $stmt->close();

  // check
  $target_dir = "../../uploads/students/";
  for ($i = 0; $i < count($_FILES["submission_files"]["name"]); $i++) {
    if ($_FILES["submission_files"]["error"][$i] != UPLOAD_ERR_OK) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+tạo+file");
      exit();
    }
    // limit file size 5MB
    if ($_FILES["submission_files"]["size"][$i] > 5000000) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=File+quá+lớn");
      exit();
    }
    $finfo = new finfo(FILEINFO_MIME_TYPE);
    $mime_type = $finfo->file($_FILES["submission_files"]["tmp_name"][$i]);
    finfo_close($finfo);
    if ($mime_type !== 'application/pdf') {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Định+dạng+không+hợp+lệ");
      exit();
    }
    $target_file = $target_dir . basename($_FILES["submission_files"]["name"][$i]);
    $file_type = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    if ($file_type != "pdf") {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Định+dạng+không+hợp+lệ");
      exit();
    }
  }

  // upload
  $uploaded_files = array();
  for ($i = 0; $i < count($_FILES["submission_files"]["name"]); $i++) {
    $hash = sha1_file($_FILES["submission_files"]["tmp_name"][$i]);
    $target_file = $target_dir . $hash . '.pdf';
    if (!move_uploaded_file($_FILES["submission_files"]["tmp_name"][$i], $target_file)) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+tạo+file");
      exit();
    }
    $uploaded_files[] = "/uploads/students/" . $hash . '.pdf';
  }
  
  // add to db
  $stmt = $conn->prepare("INSERT INTO submissions (assignment_id, student_id) VALUES (?, ?)");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("ii", $_POST["assignment_id"], $_SESSION["sid"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $submission_id = $conn->insert_id;
  foreach ($uploaded_files as $file) {
    $stmt = $conn->prepare("INSERT INTO submissions_files (submission_id, path) VALUES (?, ?)");
    if (!$stmt) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
    $stmt->bind_param("is", $submission_id, $file);
    if (!$stmt->execute()) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
  }

  $assignment_id = $_POST["assignment_id"];
  header("Location: http://" . $_SERVER["HTTP_HOST"] . "/students/homework_detail.php?id=$assignment_id");
?>