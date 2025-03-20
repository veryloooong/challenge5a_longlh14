<?php
  session_start();
  
  if (!isset($_SESSION["sid"])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
  }
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cổng thông tin sinh viên</title>
  <link rel="stylesheet" href="css/main.css">
  <link rel="icon" type="image/x-icon" href="img/favicon.ico">
  <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
  <script src="https://kit.fontawesome.com/8cc5db2d2e.js" crossorigin="anonymous"></script>
  <script src="js/jquery.js"></script>
</head>

<body>
  <h1>Xin chào</h1>
</body>

</html>