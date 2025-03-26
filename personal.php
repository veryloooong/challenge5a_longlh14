<?php
  include("lib/check_auth.php");

  // TODO: add avatars
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

  <h1 class="text-2xl text-center font-bold mt-16">Thông tin cá nhân</h1>

  <div class="container mx-auto mt-8">
    <div class="bg-white p-6 rounded-lg shadow-md max-w-2xl mx-auto border-1">
      <div class="grid grid-cols-2 gap-4 items-center personal-info">
        <div class="font-semibold">Họ và tên:</div>
        <div><?= htmlspecialchars($_SESSION["name_last"] . " " . $_SESSION["name_first"]) ?></div>

        <div class="font-semibold">Tên đăng nhập</div>
        <div><?= htmlspecialchars($_SESSION['username']) ?></div>

        <div class="font-semibold">Email:</div>
        <div><?= htmlspecialchars($_SESSION['email']) ?></div>

        <div class="font-semibold">Số điện thoại:</div>
        <div><?= htmlspecialchars($_SESSION['phone']) ?></div>

        <div class="font-semibold">Chức vụ:</div>
        <div><?= htmlspecialchars($_SESSION['is_teacher'] == 1 ? "Giáo viên" : "Sinh viên") ?></div>
      </div>

      <form action="/lib/personal/change_info.php" method="POST" class="form-change-info hidden"
        id="form-change-info">
        <div class="grid grid-cols-2 gap-4 items-center">
          <div class="font-semibold">Email:</div>
          <input type="email" placeholder="Email" name="email"
            value="<?= htmlspecialchars($_SESSION["email"]) ?>"
            class="border-1 rounded border-gray-500 p-2" required>

          <div class="font-semibold">Số điện thoại:</div>
          <input type="tel" placeholder="Số điện thoại" name="phone"
            value="<?= htmlspecialchars($_SESSION["phone"]) ?>"
            class="border-1 rounded border-gray-500 p-2" required>
        </div>
      </form>

      <form action="/lib/personal/change_pass.php" method="POST" class="form-change-pass hidden"
        id="form-change-pass">
        <div class="grid grid-cols-2 gap-4 items-center">
          <div class="font-semibold">Mật khẩu cũ:</div>
          <input type="password" placeholder="Mật khẩu cũ" name="password_old"
            class="border-1 rounded border-gray-500 p-2 pass-change-old" required>

          <div class="font-semibold">Mật khẩu mới</div>
          <input type="password" placeholder="Mật khẩu mới" name="password_new"
            class="border-1 rounded border-gray-500 p-2 pass-change-new" required>

          <div class="font-semibold">Nhập lại mật khẩu mới</div>
          <input type="password" placeholder="Nhập lại mật khẩu mới"
            class="border-1 rounded border-gray-500 p-2 pass-change-confirm" required>

          <div class="font-semibold self-start">Yêu cầu về mật khẩu:</div>
          <ul class="list-disc">
            <li>Tối thiểu 8 ký tự</li>
            <li>Tối thiểu 1 chữ cái viết hoa</li>
            <li>Tối thiểu 1 chữ cái viết thường</li>
            <li>Tối thiểu 1 chữ số</li>
            <li>Tối thiểu 1 ký tự đặc biệt</li>
          </ul>
        </div>

        <p class="text-red-500 text-center hidden pass-change-alert">Hãy chọn mật khẩu mới khác</p>
      </form>

      <div class="w-full flex flex-row justify-center mt-8 gap-4">
        <button type="submit"
          class="rounded bg-blue-500 text-white p-4 cursor-pointer hidden js-change-info-confirm"
          form="form-change-info">
          Thay đổi
        </button>
        <button type="button"
          class="rounded bg-blue-500 text-white p-4 cursor-pointer hidden js-change-pass-confirm">
          Thay đổi
        </button>
        <button class="rounded bg-blue-500 text-white p-4 cursor-pointer js-change-info">Chỉnh sửa
          thông tin</button>
        <button class="rounded bg-blue-500 text-white p-4 cursor-pointer js-change-pass">Đổi mật
          khẩu</button>
      </div>
    </div>
  </div>

  <script src="js/personal.js"></script>
</body>

</html>