<?php
require_once("dbtools.inc.php");
header("Content-type: text/html; charset=utf-8");

$link = create_connection();
// 取得表單資料
$name = $_POST["name"];
$introduce = $_POST["introduce"];
$price = $_POST["price"];
$stock = $_POST["stock"];

// 檢查存量是否為 0
if ($stock == 0) {
    echo "<p align='center'>錯誤：存量不能為 0。</p>";
    echo "<p align='center'><a href ='javascript:history.back()'>回上一頁</a></p>";
    // 關閉資料連接
    mysqli_close($link);
    exit; // 停止繼續執行
}
// 檢查被推薦圖書是否已存在於候選項目清單
$sql_check = "SELECT * FROM com_man WHERE name='$name'";

$result_check = execute_sql($link, $sql_check);

if(mysqli_num_rows($result_check) == 0) {

    // 釋放資源
    mysqli_free_result($result_check);
    $sql = "SELECT MAX(id) AS id FROM com_man";
    $result = execute_sql($link, $sql);
    $row = mysqli_fetch_assoc($result);

    // 取得目前最大的下一個圖書編號
    $id = $row['id'] + 1;

    // 處理上傳的書面影像
    $image_temp = $_FILES["image"]["tmp_name"];
    $image_folder = "image/";
    $image_name = $id . ".jpg"; 
    $image_path = $image_folder . $image_name;

    // 檢查上傳的影像檔案
    if (move_uploaded_file($image_temp, $image_path)) {
        // 將圖書資料加入資料庫
        $sql_insert = "INSERT INTO com_man ( name, introduce, price, stock) 
            VALUES ('$name', '$introduce', '$price', '$stock')";
        $result_insert = execute_sql($link, $sql_insert);
        if ($result_insert) {
            // 成功新增圖書資料
            echo "<p align='center'>圖書資料已成功新增，編號為 $id ，謝謝您的推薦！</p>";
            echo "<p align='center'><a href ='v3.php'>回首頁</a></p>";
        } else {
            // 新增圖書資料至資料庫失敗
            echo "<p align='center'>新增圖書資料至資料庫失敗。</p>";
        }
        // 關閉資料連接
        mysqli_close($link);
    } else {
        // 上傳影像失敗
        echo "<p align='center'>上傳圖書影像失敗。</p>";
        // 關閉資料連接
        mysqli_close($link);
    }
} else {
    // 顯示被推薦圖書已存在於候選項目清單的訊息
    echo "<p align='center'>您推薦的圖書已經在候選項目，不需要再推薦。</p>";
    echo "<p align='center'><a href ='javascript:history.back()'>回上一頁</a>";
    echo "　　<a href='v3.php'>回首頁</a></p>";
    // 關閉資料連接
    mysqli_close($link);
}
   
?>
