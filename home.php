<?php
  include("lib/check_auth.php");
  $conn = include("lib/database.php");
  $stmt = $conn->prepare("SELECT messages.*, CONCAT(users.name_last, ' ', users.name_first) AS name FROM messages JOIN users ON messages.user_from = users.id WHERE messages.user_to = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $_SESSION["sid"]);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $messages = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
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
  <script src="js/jquery.js"></script>
</head>

<body>
  <?php
    include("components/header.php")
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Xin chào,
    <?= htmlspecialchars($_SESSION["name_last"] . " " . $_SESSION["name_first"]) ?></h1>

  <div class="w-full flex flex-row p-8 gap-4">
    <div class="flex-grow bg-white border-1 rounded">
      <h3 class="text-center text-xl font-bold">Tin nhắn</h3>
      <?php foreach ($messages as $message): ?>
      <div class="flex justify-between border border-slate-400 rounded p-3 m-4">
        <div class="flex flex-col items-start gap-2 flex-grow">
          <span class="font-bold"><?= htmlspecialchars($message["name"]) ?></span>
          <p class="break-words break-all overflow-hidden" id="message-<?= $message["id"] ?>">
            <?= htmlspecialchars($message["content"]) ?></p>
        </div>
        <span
          class="italic whitespace-nowrap"><?= htmlspecialchars($message["created_at"]) ?></span>
      </div>
      <?php endforeach; ?>
    </div>
    <!-- <div class="flex-grow bg-white border-1 rounded">
      <h3 class="text-center text-xl font-bold">Các môn học</h3>
    </div> -->
  </div>
</body>

</html>