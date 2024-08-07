<?php
session_start();

// // 檢查是否通過 POST 請求訪問
// if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
//     echo "<script type='text/javascript'>";
//     echo "alert('非法訪問');";
//     echo "history.back();";
//     echo "</script>";
//     exit;
// }

// // 檢查付款方式和用戶名是否存在
// if (empty($_POST['payment_method']) || empty($_POST['user'])) {
//     echo "<script type='text/javascript'>";
//     echo "alert('付款方式或用戶信息缺失');";
//     echo "history.back();";
//     echo "</script>";
//     exit;
// }
// 取得付款方式和用戶名
$payment_method = $_POST['payment_method'];
$user = $_POST['user']; // 确保在 HTML 表单中包含 user 字段
$number = $_SESSION['number'];
$book_no_list = explode(",", $_COOKIE["book_no_list"]);
$quantity_list = explode(",", $_COOKIE["quantity_list"]);

// 根據付款方式顯示相應信息
if ($payment_method === 'cash_on_delivery') {
    echo "<script type='text/javascript'>";
    echo "alert('您選擇了貨到付款，請在交貨時付款');";
    echo "window.location.href = 'catalog.php?user=" . urlencode($user) . "';";
    echo "</script>";
} else if ($payment_method === 'online_payment') {
    // 更新資料庫，將該用戶的所有訂單設為已收款
    require_once("dbtools.inc.php");
    $link = create_connection();
    $sql = "UPDATE orders SET checked = 1 WHERE number = $number";
    $result = execute_sql($link, $sql);
    // 扣除商品庫存
    for ($i = 0; $i < count($book_no_list); $i++) {
        $book_no = $book_no_list[$i];
        $quantity = $quantity_list[$i];

        // 更新库存
        $sql_update_inventory = "UPDATE com_man 
                                 SET stock = stock - $quantity
                                 WHERE id = $book_no";
    
        $result = execute_sql($link, $sql_update_inventory);
    }
    $total = $_SESSION['total'];
    echo "<script type='text/javascript'>";
    echo "alert('您一共支付了 $total 元');";
    echo "window.location.href = 'catalog.php?user=" . urlencode($user) . "';";
    echo "</script>";

    mysqli_close($link);
} else {
    echo "<script type='text/javascript'>";
    echo "alert('未知的付款方式');";
    echo "history.back();";
    echo "</script>";
}
setcookie("book_no_list", "");
setcookie("book_name_list", "");
setcookie("price_list", "");
setcookie("quantity_list", "");	
?>
