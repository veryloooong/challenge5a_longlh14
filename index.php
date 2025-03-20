<?php
  session_start();

  if (isset($_SESSION["sid"])) {
    header("Location: home.php");
    exit();
  }
?>

<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Cổng thông tin sinh viên</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="js/jquery.js"></script>
</head>

<body class="w-screen h-screen bg-blue-200 flex items-center justify-center flex-col gap-8">
  <h1 class="text-3xl font-bold text-center">Trang web quản lý sinh viên của trường ABC</h1>
  <div class="w-fit min-w-96 bg-white flex flex-col justify-center items-center p-8 rounded gap-4">
    <h3 class="text-xl font-bold">Đăng nhập</h3>
    <form action="lib/authenticate.php" method="POST" class="w-full">
      <label for="username">
        Tên đăng nhập
        <div
          class="flex flex-row p-4 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
          <i class="fa-solid fa-user"></i>
          <input type="text" name="username" id="username" placeholder="Tên đăng nhập"
            class="flex-grow h-full focus:outline-none" required>
        </div>
      </label>
      <label for="password">
        Mật khẩu
        <div
          class="flex flex-row p-4 w-full border-2 border-gray-300 rounded items-center gap-2 mb-4 cursor-text">
          <i class="fa-solid fa-key"></i>
          <input type="password" name="password" id="password" placeholder="Mật khẩu"
            class="flex-grow h-full focus:outline-none" required>
        </div>
      </label>
      <?php
        if (isset($_GET["wrong"])) {
          echo("<p class='text-center text-red-600'>Sai thông tin đăng nhập</p>");
        }
      ?>
      <button type="submit"
        class="w-full bg-blue-400 text-white p-4 font-semibold text-lg cursor-pointer">Đăng
        nhập</button>
    </form>
  </div>

  <script src="js/index.js"></script>
</body>

</html>