<?php
  include("../lib/check_auth.php"); 
  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
  }

  $conn = include("../lib/database.php");
  $stmt = $conn->prepare("SELECT homework.* FROM homework WHERE id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $_GET["id"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $assignment = $stmt->get_result()->fetch_assoc();
  if (!$assignment) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Bài+tập+không+tồn+tại");
    exit();
  }

  $stmt = $conn->prepare("SELECT path FROM homework_files WHERE assignment_id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $_GET["id"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $result = $stmt->get_result();
  $files = [];
  while ($row = $result->fetch_assoc()) {
    $files[] = $row['path'];
  }

  $stmt = $conn->prepare("SELECT submissions.*, CONCAT(users.name_last, ' ', users.name_first) FROM submissions JOIN users ON submissions.student_id = users.id WHERE assignment_id = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $_GET["id"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $submissions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
  foreach ($submissions as &$submission) {
    $stmt = $conn->prepare("SELECT path FROM submissions_files WHERE submission_id = ?");
    if (!$stmt) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
    $stmt->bind_param("i", $submission["id"]);
    if (!$stmt->execute()) {
      header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
      exit();
    }
    $result = $stmt->get_result();
    $submission["paths"] = [];
    while ($row = $result->fetch_assoc()) {
      $submission["paths"][] = $row["path"];
    }
  }
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cổng thông tin sinh viên</title>
  <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="/js/jquery.js"></script>
</head>

<body>
  <?php
    include("../components/header.php")
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Thông tin bài tập</h1>

  <div class="container mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1 w-fit">
      <div class="grid grid-cols-2 gap-4 items-center">
        <div class="font-semibold">Tiêu đề:</div>
        <div><?= htmlspecialchars($assignment["title"]) ?></div>

        <div class="font-semibold">Nội dung:</div>
        <div><?= nl2br(htmlspecialchars($assignment["description"])) ?></div>

        <?php if (!empty($files)): ?>
        <div class="font-semibold">Tệp đính kèm:</div>
        <ul class="list-none">
          <?php foreach ($files as $file): ?>
          <li class="mb-2">
            <a href="<?= htmlspecialchars($file) ?>"
              class="flex items-center gap-2 text-blue-600 hover:text-blue-800 break-words break-all"
              target="_blank">
              <i class="fas fa-file"></i>
              <?= htmlspecialchars(basename($file)) ?>
            </a>
          </li>
          <?php endforeach; ?>
        </ul>
        <?php endif; ?>
      </div>
    </div>
  </div>

  <div class="mx-auto mt-4 w-full">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1 w-full">

      <h3 class="text-center font-semibold text-lg">Bài làm của sinh viên</h3>

      <?php foreach ($submissions as $message): ?>
      <div class="flex justify-between border border-slate-400 rounded p-3 mt-2 min-h-28">
        <?php print_r($message) ?>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</body>

</html>