<?php
  include("../lib/check_auth.php");

  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
  }

  $conn = include("../lib/database.php");

  $stmt = $conn->prepare("SELECT name_first, name_last, username, email, phone FROM users WHERE is_teacher = 0 ORDER BY name_first ASC");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $students = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cổng thông tin sinh viên</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" type="image/x-icon" href="../img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="../js/jquery.js"></script>
</head>

<body>
  <?php
    include("../components/header.php")
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Quản lý sinh viên</h1>

  <div class="flex flex-col items-start p-8">
    <h3 class="text-lg font-semibold">Danh sách sinh viên</h3>

    <table class="self-center border-collapse border border-slate-400 mt-4 mb-4">
      <tr class="bg-blue-500 text-white font-bold">
        <th class="border border-slate-400 px-4 py-2">Họ và tên</th>
        <th class="border border-slate-400 px-4 py-2">Tên đăng nhập</th>
        <th class="border border-slate-400 px-4 py-2">Email</th>
        <th class="border border-slate-400 px-4 py-2">Số điện thoại</th>
      </tr>

      <?php foreach ($students as $i => $student): ?>
      <tr class="<?= $i % 2 === 0 ? 'bg-white' : 'bg-slate-200' ?>">
        <td class="border border-slate-400 px-4 py-2">
          <?= htmlspecialchars($student["name_last"] . " " . $student["name_first"]) ?></td>
        <td class="border border-slate-400 px-4 py-2"><?= htmlspecialchars($student["username"]) ?>
        </td>
        <td class="border border-slate-400 px-4 py-2"><?= htmlspecialchars($student["email"]) ?>
        </td>
        <td class="border border-slate-400 px-4 py-2"><?= htmlspecialchars($student["phone"]) ?>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>

    <button class="bg-blue-500 text-white cursor-pointer rounded p-4">Thêm sinh viên</button>
    <!-- TODO: add add student functionality -->
  </div>
</body>

</html>