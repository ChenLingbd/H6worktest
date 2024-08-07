<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  $passed = $_COOKIE["passed"];

  /*  如果 cookie 中的 passed 變數不等於 TRUE，
      表示尚未登入網站，將使用者導向首頁 index.html */
  if ($passed != "TRUE")
  {
    header("location:m3.html");
    exit();
  }

  /*  如果 cookie 中的 passed 變數等於 TRUE，
      表示已經登入網站，將使用者的帳號刪除 */
  else
  {
    require_once("dbtools.inc.php");

    $id = $_COOKIE["id"];

    //建立資料連接
    $link = create_connection();
    
    //刪除帳號
    $sql = "DELETE FROM mms Where id = $id";
    $result = execute_sql($link, $sql);
  }
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
    <title>刪除會員資料成功</title>
  </head>
  <body bgcolor="#FFFFFF">
    <p align="center">
      您的資料已從本站中刪除，若要再次使用本站台服務，請重新申請，謝謝。
    </p>
    <p align="center"><a href="m3.html">回首頁</a></p>
  </body>
</html>

<?php
  //清除 cookie 內容
  setcookie("id", "");
  setcookie("passed", "");
  //關閉資料連接
  mysqli_close($link);
  exit();
?>
