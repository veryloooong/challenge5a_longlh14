<?php
  include("../lib/check_auth.php");

  if (!isset($_SESSION["is_teacher"]) || !$_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
  }

  $conn = include("../lib/database.php");

  $stmt = $conn->prepare("SELECT name_first, name_last, username, email, phone FROM users WHERE is_teacher = 0 ORDER BY name_first");
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

  <div class="flex flex-col items-start w-full p-8">
    <dialog id="dialog-delete-student" title="Xóa sinh viên"
      class="fixed m-auto rounded border border-slate-400 p-8">
      <h3 class="text-center font-semibold text-lg mb-4">Xóa sinh viên</h3>
      <form class="flex flex-col items-start gap-2" action="/lib/teachers/delete.php" method="POST">
        <p>Bạn có chắc chắn muốn xóa sinh viên khỏi lớp không?</p>
        <input type="hidden" name="student_username" id="student_username" value="" required>
        <fieldset class="flex flex-row items-center justify-end gap-2 w-full">
          <button type="submit"
            class="bg-red-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-delete-student">Xóa</button>
          <button formmethod="dialog" type="button"
            class="bg-white text-black border border-black px-4 py-2 font-semibold cursor-pointer rounded js-delete-student-close">Hủy</button>
        </fieldset>
      </form>
    </dialog>

    <dialog id="dialog-edit-student" title="Sửa thông tin sinh viên"
      class="fixed m-auto rounded border border-slate-400 p-8">
      <h3 class="text-center font-semibold text-lg mb-4">Sửa thông tin sinh viên</h3>
      <form class="flex flex-col items-start gap-2" id="form-edit-student"
        action="/lib/teachers/edit.php" method="POST">
        <input type="hidden" name="username_edit" id="username_edit" required>
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="name_last_edit">
            Họ và tên đệm
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="name_last_edit" id="name_last_edit"
                placeholder="Họ và tên đệm" class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
          <label for="name_first_edit">
            Tên
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="name_first_edit" id="name_first_edit" placeholder="Tên"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
        </fieldset>
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="phone_edit">
            Số điện thoại
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-phone"></i>
              <input type="text" name="phone_edit" id="phone_edit" placeholder="Số điện thoại"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
          <label for="email_edit">
            Email
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-envelope"></i>
              <input type="email" name="email_edit" id="email_edit" placeholder="Email"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
        </fieldset>
        <fieldset class="flex flex-row items-center justify-end gap-2 w-full">
          <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-edit-student">Sửa</button>
          <button formmethod="dialog" type="button"
            class="bg-red-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-edit-student-close">Hủy</button>
        </fieldset>
      </form>
    </dialog>

    <table class="self-center border-collapse border border-slate-400 my-4 w-full">
      <tr class="bg-blue-500 text-white font-bold">
        <th class="border border-slate-400 px-4 py-2">Họ và tên</th>
        <th class="border border-slate-400 px-4 py-2">Tên đăng nhập</th>
        <th class="border border-slate-400 px-4 py-2">Email</th>
        <th class="border border-slate-400 px-4 py-2">Số điện thoại</th>
        <th class="border border-slate-400 px-4 py-2">Thao tác</th>
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
        <td class="border border-slate-400 px-4 py-2">
          <div class="flex flex-row gap-2 items-center justify-center">
            <button
              class="rounded bg-blue-500 px-4 py-2 text-white cursor-pointer js-edit-student-popup"
              value="<?= $student["username"] . ":" . $student["email"] . ":" . $student["phone"] . ":" . $student["name_first"] . ":" . $student["name_last"] ?>">
              Chỉnh sửa</button>
            <button
              class="rounded bg-red-500 px-4 py-2 text-white cursor-pointer js-delete-student-popup"
              value="<?= $student["username"] ?>">Xóa</button>
          </div>
        </td>
      </tr>
      <?php endforeach; ?>
    </table>

    <dialog id="dialog-add-student" title="Thêm sinh viên"
      class="fixed m-auto rounded border border-slate-400 p-8">
      <h3 class="text-center font-semibold text-lg mb-4">Thêm sinh viên</h3>
      <form class="flex flex-col items-start gap-2" id="form-add-student"
        action="/lib/teachers/add.php" method="POST">
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="name_last">
            Họ và tên đệm
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="name_last" id="name_last" placeholder="Họ và tên đệm"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
          <label for="name_first">
            Tên
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="name_first" id="name_first" placeholder="Tên"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
        </fieldset>
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="phone">
            Số điện thoại
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-phone"></i>
              <input type="text" name="phone" id="phone" placeholder="Số điện thoại"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
          <label for="email">
            Email
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-envelope"></i>
              <input type="email" name="email" id="email" placeholder="Email"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
        </fieldset>
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="username" class="flex-grow">
            Tên đăng nhập
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-user"></i>
              <input type="text" name="username" id="username" placeholder="Tên đăng nhập"
                class="flex-grow h-full focus:outline-none" maxlength="32" required>
            </div>
          </label>
        </fieldset>
        <fieldset class="flex flex-row gap-2 items-center w-full">
          <label for="password">
            Mật khẩu
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password" id="password" placeholder="Mật khẩu"
                class="flex-grow h-full focus:outline-none" required>
            </div>
          </label>
          <label for="password_confirm">
            Nhập lại mật khẩu
            <div
              class="flex flex-row p-2 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
              <i class="fa-solid fa-lock"></i>
              <input type="password" name="password_confirm" id="password_confirm"
                placeholder="Nhập lại mật khẩu" class="flex-grow h-full focus:outline-none"
                required>
            </div>
          </label>
        </fieldset>
        <div class="text-sm flex flex-row items-start justify-between w-full">
          <p>Yêu cầu về mật khẩu:</p>
          <ul class="list-disc">
            <li>Tối thiểu 8 ký tự</li>
            <li>Tối thiểu 1 chữ cái viết hoa</li>
            <li>Tối thiểu 1 chữ cái viết thường</li>
            <li>Tối thiểu 1 chữ số</li>
            <li>Tối thiểu 1 ký tự đặc biệt</li>
          </ul>
        </div>
        <p class="self-center text-center password-alert text-red-500 text-sm hidden"></p>
        <fieldset class="flex flex-row items-center justify-end gap-2 w-full">
          <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-add-student">Thêm</button>
          <button formmethod="dialog" type="button"
            class="bg-red-500 text-white px-4 py-2 font-semibold cursor-pointer rounded js-add-student-close">Hủy</button>
        </fieldset>
      </form>
    </dialog>

    <button class="text-white bg-blue-500 p-4 rounded cursor-pointer js-add-student-popup">Thêm sinh
      viên</button>

    <script src="../js/dialog.js"></script>
  </div>
</body>

</html>