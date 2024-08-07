<?php

// 檢查是否登入
session_start(); // 開啟 session
if (!isset($_SESSION['account'])) {
    echo "<p align='center'>要登入才能使用本功能喔!</p>";
    exit();
}

require_once 'dbtools.inc.php'; // 引入資料庫連接檔案

// 建立連接
$link = create_connection();
// 獲取用戶訂單
$sql = "SELECT * FROM orders"; // 過濾出特定用戶的訂單
$result = execute_sql($link, $sql);

mysqli_close($link); // 關閉連接
?>

<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>顯示訂單內容</title>
</head>
<body>
    <h1>訂單內容</h1>
    <hr>
    <table border="1" bgcolor="white" rules="cols" align="center" cellpadding="5">
        <tr height="25">
            <td colspan="7" align="center" bgcolor="#CCCC00">訂單細目</td>
        </tr>
        <tr height="25" align="center" bgcolor="FFFF99">
            <td>姓名</td>
            <td>訂單編號</td>
            <td>日期時間</td>
            <td>書號</td>
            <td>數量</td>
            <td>貸款狀態</td> <!-- 新增一行 -->
            <td>操作</td> <!-- 新增一行 -->
        </tr>
        <?php
if (mysqli_num_rows($result) > 0) {
    $previous_order_number = null; // 用于存储前一个订单编号
    while ($row = mysqli_fetch_assoc($result)) {
        // 判斷當前订单编号是否與前一个相同，如果相同则只显示书号和数量
        if ($row["number"] === $previous_order_number) {
            echo "<tr>"; // 新行
            echo "<td colspan='3'></td>"; // 空单元格，占满所有列，除了操作列
            echo "<td align='center'>" . htmlspecialchars($row["book_no"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . htmlspecialchars($row["quantity"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center' colspan='2'></td>"; // 空单元格，占满两列
            echo "</tr>";
        } else {
            // 如果當前订单编號與前一个不同，则显示所有数据
            if ($previous_order_number !== null) {
                echo "<tr>"; // 新行
                echo "<td colspan='7' style='border-bottom: 2px solid black;'></td>"; // 实线单元格，占满所有列
                echo "</tr>";
            }
            
            echo "<tr>";
            echo "<td align='center'>" . htmlspecialchars($row["username"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . htmlspecialchars($row["number"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . htmlspecialchars($row["datetime"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . htmlspecialchars($row["book_no"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . htmlspecialchars($row["quantity"], ENT_QUOTES, 'UTF-8') . "</td>";
            echo "<td align='center'>" . ($row["checked"] ? "已收款" : "未收款") . "</td>"; // 显示贷款状态
            echo "<td align='center'>";
            echo "<form method='post' action='update_loan_status.php'>";
            echo "<input type='hidden' name='order_id' value='" . htmlspecialchars($row["no"], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='hidden' name='current_status' value='" . htmlspecialchars($row["checked"], ENT_QUOTES, 'UTF-8') . "'>";
            echo "<input type='submit' value='" . ($row["checked"] ? "標記為未收款" : "標記為已收款") . "'>";
            echo "</form>";
            echo "</td>";
            echo "</tr>";
            $previous_order_number = $row["number"]; // 更新前一个订单编号为当前订单编号
        }
    }
} else {
    echo "<tr><td colspan='7' align='center'>目前沒有訂單喔!</td></tr>";
}
?>


    </table>
    <a href="result.php">圖表參考</a>
</body>
</html> 