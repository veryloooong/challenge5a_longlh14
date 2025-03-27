<?php
  include("../lib/check_auth.php");
  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
  }

  $conn = include("../lib/database.php");
  $stmt = $conn->prepare("SELECT * FROM homework");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $assignments = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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

  <h1 class="text-2xl text-center font-bold mt-16">Bài tập</h1>
  <div class="container mx-auto mt-8 flex gap-8">
    <!-- Left panel: Homework list -->
    <div class="w-1/2 p-4 border border-slate-400 rounded-lg">
      <h2 class="text-xl font-bold mb-4">Danh sách bài tập</h2>
      <div id="homework-list" class="space-y-4">
        <?php foreach ($assignments as $assignment): ?>
        <div class="p-4 border border-slate-200 rounded flex justify-between items-start">
          <div class="flex-grow">
            <h3 class="font-bold"><?= htmlspecialchars($assignment['title']) ?></h3>
            <p class="mt-2 break-words break-all overflow-hidden">
              <?= htmlspecialchars($assignment['description']) ?></p>
          </div>
          <div class="w-max">
            <a href="/teachers/homework_detail.php?id=<?= $assignment['id'] ?>">
              <button
                class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer whitespace-nowrap">
                Xem chi tiết
              </button>
            </a>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Right panel: Add homework form -->
    <div class="w-1/2 p-4 border border-slate-400 rounded-lg">
      <h2 class="text-xl font-bold mb-4">Thêm bài tập mới</h2>
      <form action="/lib/homework/add.php" method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="block mb-2">Tiêu đề:</label>
          <input type="text" name="title" required class="w-full p-2 border rounded">
        </div>
        <div class="mb-4">
          <label class="block mb-2">Mô tả:</label>
          <textarea name="description" required class="w-full p-2 border rounded h-32"></textarea>
        </div>
        <div class="mb-4">
          <label class="block mb-2">File đính kèm:</label>
          <input type="file" name="homework_files[]" multiple class="w-full p-2 border rounded">
          <p>Kích thước mỗi file tối đa 5MB</p>
        </div>
        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded cursor-pointer">
          Thêm bài tập
        </button>
      </form>
    </div>
  </div>
</body>

</html>