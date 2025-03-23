<?php
  include("lib/check_auth.php");
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
    include("components/header.php")
  ?>

  <h1 class="text-2xl text-center font-bold mt-16">Xin chào,
    <?= htmlspecialchars($_SESSION["name_last"] . " " . $_SESSION["name_first"]) ?></h1>

  <div class="w-full flex flex-row p-8 gap-4">
    <div class="flex-grow bg-white border-1 rounded">
      <h3 class="text-center text-xl font-bold">Các bài tập</h3>
    </div>
    <div class="flex-grow bg-white border-1 rounded">
      <h3 class="text-center text-xl font-bold">Các môn học</h3>
    </div>
  </div>
</body>

</html>