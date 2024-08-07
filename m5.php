<?php
session_start();
require_once("dbtools.inc.php");
header("Content-type: text/html; charset=utf-8");


// 取得表單資料
$account = $_POST["account"];
$password = $_POST["password"];

// 建立資料連接
$link = create_connection();

// 檢查帳號密碼是否正確
$sql = "SELECT * FROM `manager` WHERE `account` = '$account' AND `password` = '$password'";
$result = execute_sql($link, $sql);

// 如果帳號密碼錯誤
if (mysqli_num_rows($result) == 0) {
  // 釋放 $result 佔用的記憶體
  mysqli_free_result($result);

  // 關閉資料連接
  mysqli_close($link);

  // 顯示訊息要求使用者輸入正確的帳號密碼
  echo "<script type='text/javascript'>";
  echo "alert('帳號密碼錯誤，請查明後再登入');";
  echo "history.back();";
  echo "</script>";
} else {
  // 如果帳號密碼正確
  // 取得管理員資料
  $manager_data = mysqli_fetch_assoc($result);

  // 釋放 $result 佔用的記憶體
  mysqli_free_result($result);

  // 關閉資料連接
  mysqli_close($link);
  
  // 設定 Session 變數
  $_SESSION['account'] = $account;

 

  // 使用 JavaScript 判斷是否為管理員，並載入對應的頁面
  echo "<script type='text/javascript'>";
  echo "var isAdmin = true;"; // 假設使用者是管理員
  echo "parent.onLoginSuccess(isAdmin);";
  echo "</script>";
}
?>
