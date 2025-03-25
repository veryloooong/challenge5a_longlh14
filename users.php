<?php
  include("lib/check_auth.php");

  $conn = include("lib/database.php");
  $stmt = $conn->prepare("SELECT username, is_teacher, CONCAT(name_last, ' ', name_first) AS name FROM users");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }

  $users = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cổng thông tin sinh viên</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="js/jquery.js"></script>
</head>

<body>
  <?php
    include("components/header.php");
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Các người dùng</h1>

  <div class="flex flex-col items-start w-full p-8">
    <table class="self-center border-collapse border border-slate-400 my-4 w-full">
      <tr class="bg-blue-500 text-white font-bold">
        <th class="border border-slate-400 px-4 py-2">Họ và tên</th>
        <th class="border border-slate-400 px-4 py-2">Chức vụ</th>
        <th class="border border-slate-400 px-4 py-2">Thông tin</th>
      </tr>

      <?php foreach ($users as $i => $user): ?>
      <tr class="<?= $i % 2 === 0 ? 'bg-white' : 'bg-slate-200' ?>">
        <td class="border border-slate-400 px-4 py-2">
          <?= htmlspecialchars($user["name"]) ?></td>
        <td class="border border-slate-400 px-4 py-2">
          <?= htmlspecialchars($user["is_teacher"] ? "Giáo viên" : "Sinh viên") ?></td>
        <td class="border border-slate-400 px-4 py-2">
          <div class="flex flex-row gap-2 items-center justify-center">
            <a href="/users/view.php?username=<?= htmlspecialchars($user["username"]) ?>">
              <button class="rounded bg-blue-500 px-4 py-2 text-white cursor-pointer"
                type="button">Xem</button>
            </a>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>

  </div>

</body>

</html>