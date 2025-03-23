<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Error</title>
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="js/jquery.js"></script>
</head>

<body class="flex flex-col w-screen h-screen bg-blue-200 items-center justify-center gap-4">
  <script src="js/error.js"></script>

  <h1 class="text-3xl font-bold text-center">Có lỗi xảy ra</h1>
  <?php
    $a = htmlspecialchars($_GET["errmsg"] ?? "Có lỗi không xác định");
    echo("<p class='text-lg'>$a</p>")
  ?>
  <button class="bg-white border-1 rounded p-4 text-lg cursor-pointer js-to-homepage">Quay
    lại</button>
</body>

</html>