<?php
// 取得表單資料
$book_no = $_GET["id"];
$name = $_GET["name"];
$price = $_GET["price"];
$quantity = $_POST["quantity"];
if (empty($quantity)) $quantity = 1;

// 建立資料連接
require_once("dbtools.inc.php");
$link = create_connection();

// 查詢庫存
$sql = "SELECT stock FROM com_man WHERE id = $book_no";
$result = execute_sql($link, $sql);
$row = mysqli_fetch_assoc($result);
$stock = $row['stock'];

// 檢查庫存是否足夠
if ($quantity > $stock) {
    echo "<script type='text/javascript'>";
    echo "alert('選擇的數量不能大於剩餘存量');";
    echo "history.back();";
    echo "</script>";
    exit();
}

// 若購物車沒有任何項目，則直接加入產品資料
if (empty($_COOKIE["book_no_list"])) {
    setcookie("book_no_list", $book_no);
    setcookie("book_name_list", $name);
    setcookie("price_list", $price);
    setcookie("quantity_list", $quantity);
} else {
    // 取得購物車資料
    $book_no_array = explode(",", $_COOKIE["book_no_list"]);
    $book_name_array = explode(",", $_COOKIE["book_name_list"]);
    $price_array = explode(",", $_COOKIE["price_list"]);
    $quantity_array = explode(",", $_COOKIE["quantity_list"]);

    // 判斷選擇的物品是否已在購物車中
    if (in_array($book_no, $book_no_array)) {
        // 如果選擇的物品已經在購物車中，變更物品數量即可
        $key = array_search($book_no, $book_no_array);
        $quantity_array[$key] += $quantity;
    } else {
        // 如果選擇的物品沒有在購物車中，則將物品資料加入購物車
        $book_no_array[] = $book_no;
        $book_name_array[] = $name;
        $price_array[] = $price;
        $quantity_array[] = $quantity;
    }

    // 儲存購物車資料
    setcookie("book_no_list", implode(",", $book_no_array));
    setcookie("book_name_list", implode(",", $book_name_array));
    setcookie("price_list", implode(",", $price_array));
    setcookie("quantity_list", implode(",", $quantity_array));
}

// 釋放資源及關閉資料連接
mysqli_free_result($result);
mysqli_close($link);
?>
<!doctype html>
<html>
<head>
    <meta charset="utf-8">
</head>
<body bgcolor="lightyellow">
    <h1> </h1>
    <p align="center">您所選取的產品及數量已成功放入購物車！</p>
    <p align="center"><a href="catalog.php">繼續購物</a></p>
</body>
</html>
