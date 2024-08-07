

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
    <title>修改會員資料</title>
    <meta charset="utf-8">
  </head>
  <body>
    <form name="myForm" method="post" action="update.php" >
      <table border="2" align="center" bordercolor="#6666FF">
        <tr>
          <td colspan="2" bgcolor="#6666FF" align="center">
            <font color="#FFFFFF">請填入下列資料 (標示「*」欄位請務必填寫)</font>
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*使用者帳號：</td>
          <td><?php echo $row["account"] ?></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*使用者密碼：</td>
          <td>
            <input type="password" name="password" size="15" value="<?php echo $row['password'] ?>">
            (請使用英文或數字鍵，勿使用特殊字元)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*密碼確認：</td>
          <td>
            <input type="password" name="re_password" size="15" value="<?php echo $row["password"] ?>">
            (再輸入一次密碼，並記下您的使用者名稱與密碼)
          </td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">*姓名：</td>
          <td><input type="text" name="name" size="8" value="<?php echo $row["name"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td align="right">E-mail 帳號：</td>
          <td><input type="text" name="email" size="30" value="<?php echo $row["email"] ?>"></td>
        </tr>
        <tr bgcolor="#99FF99">
          <td colspan="2" align="CENTER">
            <input type="submit" value="修改資料">
            <input type="reset" value="重新填寫">
          </td>
        </tr>
      </table>
    </form>
  </body>
</html>
<?php
    //釋放資源及關閉資料連接
    mysqli_free_result($result);
    mysqli_close($link);
  }
?>