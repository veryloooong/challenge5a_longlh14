<?php
  session_start();

  if (!isset($_SESSION["sid"])) {
    header("Location: http://" . $_SERVER["HTTP_HOST"] . "/index.php");
    exit();
  }
?>