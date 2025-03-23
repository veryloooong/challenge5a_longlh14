<header class="bg-blue-300 py-4 px-8 gap-8">
  <ul class="flex flex-row gap-8 items-center">
    <li>
      <a href="/home.php" class="text-lg font-bold hover:underline">Cổng thông tin sinh viên</a>
    </li>
    <li>
      <a href="/personal.php" class="hover:underline">Thông tin cá nhân</a>
    </li>
    <li>
      <a href="/users.php" class="hover:underline">Các người dùng</a>
    </li>
    <?php
      if ($_SESSION["is_teacher"]) {
        echo("
          <li>
            <a href=\"/teachers/manage.php\" class=\"hover:underline\">Quản lý sinh viên</a>
          </li>
          <li>
            <a href=\"/teachers/homework.php\" class=\"hover:underline\">Bài tập</a>
          </li>
        ");
      }
    ?>
    <li>
      <a href="/lib/logout.php" class="hover:underline">Đăng xuất</a>
    </li>
  </ul>
</header>