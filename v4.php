<?php
session_start();
require_once 'dbtools.inc.php'; // 引入資料庫連接檔案

// 建立連接
$link = create_connection();

// 處理表單提交
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id'];
    $price = $_POST['price'];
    $introduce = $_POST['introduce'];
    $stock = $_POST['stock'];

    if ($stock == 0) {
        // 如果存量為 0，刪除該商品
        $sql = "DELETE FROM com_man WHERE id='$id'";
        if (execute_sql($link, $sql)) {
          // 重置 AUTO_INCREMENT
          $sql_reset_ai = "ALTER TABLE com_man AUTO_INCREMENT = 1";
          execute_sql($link, $sql_reset_ai);
        }
    } else {
        // 否則，更新商品資料
        $sql = "UPDATE com_man SET price='$price', introduce='$introduce', stock='$stock' WHERE id='$id'";
    }
    
    // 執行 SQL 語句並檢查是否成功
    if (execute_sql($link, $sql)) {
        // 成功後跳轉回商品列表頁面
        mysqli_close($link);
        header('Location: v3.php');
        exit;
    } else {
        // 如果執行失敗，顯示錯誤信息
        echo "Error: " . mysqli_error($link);
    }
}

// 獲取商品資料
if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM com_man WHERE id='$id'";
    $result = execute_sql($link, $sql);
    $row = mysqli_fetch_assoc($result);
}

// 關閉連接
mysqli_close($link);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>修改商品資料</title>
</head>
<body bgcolor="#FFE6CC">
    <h1 align="center">修改商品資料</h1>
    <form action="v4.php" method="post">
        <table width="75%" align="center" border="2" bordercolor="#999999">
            <tr bgcolor="#0033CC">
                <td align="center" style='font-size: 36px;'><font color="#FFFFFF">書名</font></td>
                <td align="center" style='font-size: 36px;'><font color="#FFFFFF">說明</font></td>
                <td align="center" style='font-size: 36px;'><font color="#FFFFFF">價格</font></td>
                <td align="center" style='font-size: 36px;'><font color="#FFFFFF">存量</font></td>
            </tr>
            <tr>
                <td bgcolor='#FFCCCC' style='font-size: 28px;'><?php echo htmlspecialchars($row['name']); ?></td>
                <td bgcolor='#CCFFCC' style='font-size: 28px;'>
                    <input type="text" name="introduce" value="<?php echo htmlspecialchars($row['introduce']); ?>" style='font-size: 24px; width: 100%;'>
                </td>
                <td bgcolor='#FFCCCC' style='font-size: 24px;'>
                    <input type="text" name="price" value="<?php echo htmlspecialchars($row['price']); ?>" style='font-size: 24px; width: 100%;'>
                </td>
                <td bgcolor='#CCFFCC' style='font-size: 24px;'>
                    <input type="text" name="stock" value="<?php echo htmlspecialchars($row['stock']); ?>" style='font-size: 24px; width: 100%;'>
                </td>
            </tr>
        </table>
        <p align="center">
            <input type="hidden" name="id" value="<?php echo htmlspecialchars($row['id']); ?>">
            <input type="submit" value="保存修改" style='font-size: 24px;'>
            <input type="button" value="取消" onclick="javascript:window.open('v3.php','_self')" style='font-size: 24px;'>
        </p>
    </form>
</body>
</html>