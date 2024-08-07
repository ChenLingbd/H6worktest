<?php
setcookie("name", $_POST["account"]);
require_once("dbtools.inc.php");
header("Content-type: text/html; charset=utf-8");
session_start();

//取得表單資料
$account = $_POST["account"];
$password = $_POST["password"];

//建立資料連接
$link = create_connection();

//檢查帳號密碼是否正確
$sql = "SELECT * FROM `mms` WHERE `account` = '$account' AND `password` = '$password'";
$result = execute_sql($link, $sql);

//如果帳號密碼錯誤
if (mysqli_num_rows($result) == 0) {
  //釋放 $result 佔用的記憶體
  mysqli_free_result($result);

  //關閉資料連接
  mysqli_close($link);

  //顯示訊息要求使用者輸入正確的帳號密碼
  echo "<script type='text/javascript'>";
  echo "alert('帳號密碼錯誤，請查明後再登入');";
  echo "history.back();";
  echo "</script>";
} else {
  //取得 id 欄位
  $id = mysqli_fetch_object($result)->id;

  //釋放 $result 佔用的記憶體
  mysqli_free_result($result);

  //關閉資料連接
  mysqli_close($link);
  
  // 設定 Session 變數
  $_SESSION['account'] = $account;

  //將使用者資料加入 cookies
  setcookie("id", $id);
  setcookie("passed", "TRUE");

  // 使用 JavaScript 调用 parent.onLoginSuccess 并跳转到 index.html
  echo "<script type='text/javascript'>";
  echo "parent.onLoginSuccess();";
  echo "</script>";
}
?>
