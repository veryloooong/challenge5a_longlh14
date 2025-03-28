<?php
  include("../check_auth.php");
  if (!isset($_SESSION["is_teacher"]) || $_SESSION["is_teacher"]) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }

  print_r($_POST);
  print_r($_FILES);
?>