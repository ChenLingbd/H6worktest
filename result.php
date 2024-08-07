<!doctype html>
<html>
<head>
  <title>售貨結果</title>
  <meta charset="utf-8">
</head>
<body>
  <h1 align='center'>售貨結果</h1>
  <table align='center' width='600' border='1' bordercolor='#990033'>
    <tr bgcolor='#CC66FF'>
      <td align='center'><b><font color='#FFFFFF'>售貨產品編號</font></b></td>
      <td align='center'><b><font color='#FFFFFF'>售貨數</font></b></td>
      <td align='center'><b><font color='#FFFFFF'>售貨百分比</font></b></td>
      <td align='center'><b><font color='#FFFFFF'>直方圖</font></b></td>
    </tr>
    <tr bgcolor='#FFCCFF'>
    <?php
      require_once("dbtools.inc.php");

      //建立資料連接
      $link = create_connection();

      //修改 SQL 查詢以按產品編號分組並計算數量總和
      $sql = "SELECT book_no, SUM(quantity) AS total_quantity FROM orders GROUP BY book_no";
      $result = execute_sql($link, $sql);

      //計算總數量
      $total_score = 0;
      while ($row = mysqli_fetch_assoc($result)) {
        $total_score += $row['total_quantity'];
      }

      //將記錄指標移至第 1 筆記錄
      mysqli_data_seek($result, 0);

      //列出所有產品編號的統計數據
      while ($row = mysqli_fetch_assoc($result)) {
        //計算產品數量百分比
        $percent = round($row["total_quantity"] / $total_score, 4) * 100;

        //顯示產品統計數據
        echo "<tr>";
        echo "<td align='center'>" . htmlspecialchars($row["book_no"]) . "</td>";
        echo "<td align='center'>" . htmlspecialchars($row['total_quantity']) . "</td>";
        echo "<td align='center'>" . $percent . "%</td>";
        echo "<td height='35'><img src='bar.jpg' width='" . ($percent * 3) . "' height='20'></td>";
        echo "</tr>";
      }

      //釋放資源及關閉資料連接
      mysqli_free_result($result);
      mysqli_close($link);
    ?>
    <tr bgcolor='#FFCCFF'>
      <td align='center'>總計</td>
      <td align='center'><?php echo $total_score; ?></td>
      <td align='center'>100%</td>
      <td><img src='bar.jpg' width='300' height='20'></td>
    </tr>
  </table>
</body>
</html>
