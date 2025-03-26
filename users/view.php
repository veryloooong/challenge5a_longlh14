<?php
  include("../lib/check_auth.php");
  if ($_GET["username"] == $_SESSION["username"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/users.php");
    exit();
  }
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

  $stmt = $conn->prepare("SELECT messages.*, CONCAT(users.name_last, ' ', users.name_first) AS name FROM messages JOIN users ON messages.user_from = users.id WHERE user_to = ?");
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
  <link rel="icon" type="image/x-icon" href="/img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="/js/jquery.js"></script>
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

  <dialog id="dialog-delete-message" title="Xóa tin nhắn"
    class="fixed m-auto rounded border border-slate-400 p-8">
    <h3 class="text-center font-semibold text-lg mb-4">Xóa tin nhắn</h3>
    <form class="flex flex-col items-start gap-2" action="/lib/messages/delete.php" method="POST">
      <p>Bạn có chắc chắn muốn xóa tin nhắn?</p>
      <input type="hidden" name="message_id_delete" id="message_id_delete" value="" required>
      <input type="hidden" name="username" value="<?= $user_info["username"] ?>" required>
      <fieldset class="flex flex-row items-center justify-end gap-2 w-full">
        <button type="submit"
          class="bg-red-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-delete-message">Xóa</button>
        <button formmethod="dialog" type="button"
          class="bg-white text-black border border-black px-4 py-2 font-semibold cursor-pointer rounded js-delete-message-close">Hủy</button>
      </fieldset>
    </form>
  </dialog>

  <dialog id="dialog-edit-message" title="Sửa tin nhắn"
    class="fixed m-auto rounded border border-slate-400 p-8">
    <h3 class="text-center font-semibold text-lg mb-4">Sửa tin nhắn</h3>
    <form class="flex flex-col items-start gap-2" action="/lib/messages/edit.php" method="POST">
      <label for="message_content_edit">
        Nội dung tin nhắn
        <div
          class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
          <input type="text" name="message_content_edit" id="message_content_edit"
            placeholder="Nội dung tin nhắn" class="flex-grow h-full focus:outline-none" value=""
            required>
        </div>
      </label>
      <input type="hidden" name="message_id_edit" id="message_id_edit" value="" required>
      <input type="hidden" name="username" value="<?= $user_info["username"] ?>" required>
      <fieldset class="flex flex-row items-center justify-end gap-2 w-full">
        <button type="submit"
          class="bg-red-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-edit-message">Xóa</button>
        <button formmethod="dialog" type="button"
          class="bg-white text-black border border-black px-4 py-2 font-semibold cursor-pointer rounded js-edit-message-close">Hủy</button>
      </fieldset>
    </form>
  </dialog>

  <div class="mx-auto mt-4 w-full">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1 w-full">
      <form action="/lib/messages/send.php" method="POST"
        class="w-full flex flex-row gap-2 form-message-send">
        <input type="text" name="message_content" id="message_content"
          class="rounded border border-slate-400 px-4 flex-grow" placeholder="Nội dung tin nhắn"
          required>
        <input type="hidden" name="user_to" id="user_to" value="<?= $user_info["id"] ?>">
        <input type="hidden" name="username" id="username" value="<?= $user_info["username"] ?>">
        <button type="submit"
          class="text-white bg-blue-500 px-4 py-2 rounded cursor-pointer">Gửi</button>
      </form>

      <?php foreach ($messages as $message): ?>
      <div class="flex justify-between border border-slate-400 rounded p-3 mt-2 min-h-28">
        <div class="flex flex-col items-start gap-2 flex-grow">
          <span class="font-bold"><?= htmlspecialchars($message["name"]) ?></span>
          <p class="break-words break-all overflow-hidden" id="message-<?= $message["id"] ?>">
            <?= htmlspecialchars($message["content"]) ?></p>
        </div>
        <div class="flex flex-col items-end gap-2 w-max">
          <span
            class="italic whitespace-nowrap"><?= htmlspecialchars($message["created_at"]) ?></span>
          <?php if ($message["user_from"] == $_SESSION["sid"]): ?>
          <div class="flex flex-row gap-2">
            <button
              class="py-2 px-4 bg-blue-500 rounded text-white cursor-pointer js-edit-message-popup"
              value="<?= $message["id"] ?>">Sửa</button>
            <button
              class="py-2 px-4 bg-red-500 rounded text-white cursor-pointer js-delete-message-popup"
              value="<?= $message["id"] ?>">Xóa</button>
          </div>
          <?php endif; ?>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <script src="/js/messages.js"></script>
</body>

</html>