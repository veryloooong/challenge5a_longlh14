<?php
  include("../lib/check_auth.php");

  $conn = include("../lib/database.php");
  $stmt = $conn->prepare("SELECT id, username, email, phone, is_teacher, CONCAT(name_last, ' ', name_first) AS name FROM users WHERE username = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $username = $conn->real_escape_string($_GET["username"]);
  $stmt->bind_param("s", $username);
  if (!$stmt->execute()) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  
  $user_info = $stmt->get_result()->fetch_assoc();
  if (!$user_info) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Người+dùng+không+tồn+tại");
    exit();
  }

  $stmt = $conn->prepare("SELECT * FROM messages WHERE user_to = ?");
  if (!$stmt) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/error.php?errmsg=Lỗi+hệ+thống");
    exit();
  }
  $stmt->bind_param("i", $user_info["id"]);
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
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="../js/jquery.js"></script>
</head>

<body>
  <?php
    include("../components/header.php");
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Thông tin người dùng</h1>

  <div class="container mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1">
      <div class="grid grid-cols-2 gap-4 items-center personal-info">
        <div class="font-semibold">Họ và tên:</div>
        <div><?= htmlspecialchars($user_info["name"]) ?></div>

        <div class="font-semibold">Tên đăng nhập</div>
        <div><?= htmlspecialchars($user_info["username"]) ?></div>

        <div class="font-semibold">Email:</div>
        <div><?= htmlspecialchars($user_info["email"]) ?></div>

        <div class="font-semibold">Số điện thoại:</div>
        <div><?= htmlspecialchars($user_info["phone"]) ?></div>

        <div class="font-semibold">Chức vụ:</div>
        <div><?= htmlspecialchars($user_info["is_teacher"] == 1 ? "Giáo viên" : "Sinh viên") ?>
        </div>
      </div>
    </div>
  </div>

  <h2 class="text-xl text-center font-bold mt-4">Tin nhắn</h2>

  <div class="mx-auto mt-4 w-full">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1 w-full">
      <form action="/lib/messages/send.php" method="POST"
        class="w-full flex flex-row gap-2 form-message-send">
        <input type="text" name="message_content" id="message_content"
          class="rounded border border-slate-400 px-4 flex-grow" placeholder="Nội dung tin nhắn"
          required>
        <input type="hidden" name="user_to" id="user_to" value="<?= $user_info["id"] ?>">
        <button type="submit"
          class="text-white bg-blue-500 px-4 py-2 rounded cursor-pointer">Gửi</button>
      </form>

      <!-- TODO -->
    </div>
  </div>
</body>

</html>