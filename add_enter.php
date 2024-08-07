<?php
session_start();
// 建立資料連接
require_once 'dbtools.inc.php';
$link = create_connection();

    // 取得購物車資料
    $book_no_array = explode(",", $_COOKIE["book_no_list"]);
    $quantity_array = explode(",", $_COOKIE["quantity_list"]);
    $username = isset($_COOKIE["name"]) ? $_COOKIE["name"] : ''; 
    $order_no = $_GET['order_no'];
    // 取得當前時間
    date_default_timezone_set('Asia/Taipei'); // 設定時區為台北
    $datetime = date('Y-m-d H:i:s');

    // 準備插入資料的SQL語句
    $sql = "INSERT INTO orders (number, datetime, username, book_no, quantity, checked) VALUES ";
    $values = array();
      // 紀錄全域變數number
    $_SESSION['number'] = $order_no;
    // 準備每筆資料的值
    for ($i = 0; $i < count($book_no_array); $i++) {
        $book_no = $book_no_array[$i];
        $quantity = $quantity_array[$i];
        $values[] = "('$order_no','$datetime', '$username', '$book_no', '$quantity', 0)";
    }

    // 將所有資料值組合成SQL語句
    $sql .= implode(", ", $values);

    // 執行SQL語句
    $result = execute_sql($link, $sql);

    // 檢查是否插入成功
    if ($result) {
        echo "購物車資料已成功插入到資料庫中。";
    } else {
        echo "插入購物車資料到資料庫失敗。";
    }


// 關閉資料連接
mysqli_close($link);

// 重新導向到付款頁面
header("location: pay.php");
?>
