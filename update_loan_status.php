<?php
session_start();
if (!isset($_SESSION['account'])) {
    echo "<p align='center'>要登入才能使用本功能喔!</p>";
    exit();
}

require_once 'dbtools.inc.php'; // 引入資料庫連接檔案

// 建立連接
$link = create_connection();

// 獲取 POST 數據
$order_id = $_POST['order_id'];
$current_status = $_POST['current_status'];

// 計算新的狀態
$new_status = $current_status ? 0 : 1;

// 更新訂單的貸款狀態
$sql = "UPDATE orders SET checked = $new_status WHERE no = '$order_id'";
execute_sql($link, $sql);

// 關閉連接
mysqli_close($link);

// 重定向回訂單頁面
header("Location: add_orders.php");
exit();
?>
