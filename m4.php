<?php
  session_start();
  if (!isset($_SESSION['account'])) {
    echo "<p align='center'>要登入才能使用本功能喔!</p>";
    exit();
  }
?>
<!doctype html>
<html>
  <head>
    <title>會員管理</title>
    <meta charset="utf-8">
  </head>
  <body>
    <h1>會員管理頁面</h1>
    <p align="center">
      <a href="m4-1.php">查看會員資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;  
      <a href="m4-2.php">修改會員資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      <a href="m4-3.php">刪除會員資料</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    </p>
  </body>
</html>