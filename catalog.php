<?php
  //檢查是否登入
  session_start();
  if (!isset($_SESSION['account'])) {
    echo "<p align='center'>要登入才能使用本功能喔!</p>";
    exit();
  }
?>
<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body bgcolor="lightyellow">
    <table border="0" align="center" width="800" cellspacing="2">
      <tr bgcolor="#BABA76" height="30" align="center">
        <td>書號</td>
        <td>書名</td>
        <td>定價</td>
        <td>圖片</td>
        <td>輸入數量</td>
        <td>剩餘存量</td>
        <td>進行訂購</td>
      </tr>
        <?php
          //建立資料連接
          require_once("dbtools.inc.php");
          $link = create_connection();

          //篩選出所有產品資料
          $sql = "SELECT * FROM com_man";
          $result = execute_sql($link, $sql);

          //計算總記錄數
          $total_records = mysqli_num_rows($result);

          //列出所有產品資料
          for ($i = 0; $i < $total_records; $i++)
          {
           //取得產品資料
            $row = mysqli_fetch_assoc($result);
            if($row["stock"] > 0){
              //顯示產品各欄位的資料
              echo "<form method='post' action='add_to_cart.php?id=" .
              $row["id"] . "&name=" . urlencode($row["name"]) .
              "&price=" . $row["price"] . "'>";
              echo "<tr align='center' bgcolor='#EDEAB1'>";
              echo "<td>" . $row["id"] . "</td>";
              echo "<td>" . $row["name"] . "</td>";
              echo "<td>$" . $row["price"] . "</td>";
              //新增圖片欄位，直接使用指定的圖片 URL
              echo "<td><img src='image/" . $row["id"] . ".jpg' width='100'></td>";
              echo "<td><input type='number' name='quantity' size='5' value='1' max='10'></td>";
              echo "<td>" . $row["stock"] . "</td>";
              echo "<td><input type='submit' value='放入購物車'></td>";
              echo "</tr>";
              echo "</form>";
            }
            
          } 

          //釋放資源及關閉資料連接
          mysqli_free_result($result);
          mysqli_close($link);
        ?>
    </table>
  </body>
</html>
