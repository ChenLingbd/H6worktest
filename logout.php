<?php
  session_start();
  // 清除所有會話變量
  $_SESSION = array();

  // 如果有使用 cookies 的話也應該清除
  if (ini_get("session.use_cookies")) {
      $params = session_get_cookie_params();
      setcookie(session_name(), '', time() - 42000,
          $params["path"], $params["domain"],
          $params["secure"], $params["httponly"]
      );
  }

  setcookie("book_no_list", "");
  setcookie("book_name_list", "");
  setcookie("price_list", "");
  setcookie("quantity_list", "");	

  // 最後銷毀會話
  session_destroy();

   // 輸出 JavaScript 代碼，執行 onLogoutSuccess() 函數
   echo "<script type='text/javascript'>";
   echo "parent.onLogoutSuccess();"; // 在父頁面中執行 onLogoutSuccess() 函數
   echo "</script>";
  exit();
?>
