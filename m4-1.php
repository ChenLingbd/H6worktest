<?php
  //檢查 cookie 中的 passed 變數是否等於 TRUE
  $passed = $_COOKIE["passed"];

  //如果 cookie 中的 passed 變數不等於 TRUE
  //表示尚未登入網站，將使用者導向首頁 index.html
  if ($passed != "TRUE")
  {
    header("location:m3.html");
    exit();
  }

  //如果 cookie 中的 passed 變數等於 TRUE
  //表示已經登入網站，取得使用者資料
  else
  {
    require_once("dbtools.inc.php");

    $id = $_COOKIE["id"];

    //建立資料連接
    $link = create_connection();

    //執行 SELECT 陳述式取得使用者資料
    $sql = "SELECT * FROM mms Where id = $id";
    $result = execute_sql($link, $sql);

    $row = mysqli_fetch_assoc($result);
?>
<!doctype html>
<html>
  <head>
    <title>查看會員資料</title>
    <meta charset="utf-8">
  </head>
  <body>
    <table border="2" align="center" bordercolor="#6666FF">
      <tr>
        <td colspan="2" bgcolor="#6666FF" align="center">
          <font color="#FFFFFF">您的會員資料</font>
        </td>
      </tr>
      <tr bgcolor="#99FF99">
        <td align="right">使用者帳號：</td>
        <td><?php echo $row["account"] ?></td>
      </tr>
      <tr bgcolor="#99FF99">
        <td align="right">使用者密碼：</td>
        <td><?php echo $row['password'] ?></td>
      </tr>
      <tr bgcolor="#99FF99">
        <td align="right">姓名：</td>
        <td><?php echo $row["name"] ?></td>
      </tr>
      <tr bgcolor="#99FF99">
        <td align="right">E-mail 帳號：</td>
        <td><?php echo $row["email"] ?></td>
      </tr>
    </table>
  </body>
</html>
<?php
    //釋放資源及關閉資料連接
    mysqli_free_result($result);
    mysqli_close($link);
  }
?>
