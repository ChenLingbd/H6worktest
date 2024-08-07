
<?php
  // 若購物車是空的，就顯示尚未選購產品
  if (empty($_COOKIE["book_no_list"])) {
    echo "<script type='text/javascript'>";
    echo "alert('您尚未選購任何產品');";
    echo "history.back();";		
    echo "</script>";
    exit; // 確保購物車為空時不會繼續執行下面的代碼
  }
?>

<!doctype html>
<html>
  <head>
    <meta charset="utf-8">
  </head>
  <body>

    <hr>
    <table border="5" bgcolor="white" rules="cols" align="center" cellpadding="5">
    <tr height="25">
        <td colspan="5" align="Center" bgcolor="#CCCC00">個人資料</td>
    </tr>
    <tr height="25">
      <td colspan="5">姓名：<u><?php echo $_COOKIE["name"] ?>
        <?php for ($i = 0; $i <= 100 - 2* strlen($_COOKIE["name"]); $i++) echo "&nbsp;"; ?></u>
      </td>
    </tr>

    <tr height="25">
      <td colspan="5" align="center" bgcolor="#CCCC00">訂單細目</td>
    </tr>
    <tr height="25" align="center" bgcolor="FFFF99">
      <td>書號</td>
      <td>書名</td>
      <td>定價</td>
      <td>數量</td>
      <td>小計</td>                                                                
    </tr>     
      <?php
        session_start();
        // 取得購物車資料
        $book_no_array = explode(",", $_COOKIE["book_no_list"]);
        $book_name_array = explode(",", $_COOKIE["book_name_list"]);
        $price_array = explode(",", $_COOKIE["price_list"]);     
        $quantity_array = explode(",", $_COOKIE["quantity_list"]);     
                    
        // 顯示購物車內容
        $total = 0;     
        for ($i = 0; $i < count($book_no_array); $i++) {
          // 計算小計
          $sub_total = $price_array[$i] * $quantity_array[$i];
                    
          // 計算總計
          $total += $sub_total;
                    
          // 顯示各欄位資料
          echo "<tr>";   
          echo "<td align='center'>" . $book_no_array[$i] . "</td>";          
          echo "<td align='center'>" . $book_name_array[$i] . "</td>";          
          echo "<td align='center'>$" . $price_array[$i] . "</td>";
          echo "<td align='center'>" . $quantity_array[$i] . "</td>";
          echo "<td align='center'>$" . $sub_total . "</td>";
          echo "</tr>";
        }
        echo "<tr align='right' bgcolor='#CCCC00'>";
        echo "<td colspan='5'>總金額 = " . $total . "</td>";    
        echo "</tr>";

        $_SESSION['total'] = $total;
      ?>

    <?php
      // 建立資料庫連接
      require_once 'dbtools.inc.php';
      $link = create_connection();

      // 查詢最後一筆訂單的編號
      $sql = "SELECT no FROM orders ORDER BY no DESC LIMIT 1";
      $result = execute_sql($link, $sql);

      // 檢查是否有資料
      if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $latest_order_no = $row['no'] + 1; // 獲取最後一筆訂單編號並加一
      } else {
        $latest_order_no = 1; // 如果沒有任何訂單，則訂單編號為 1
      }

      // 關閉資料庫連接
      mysqli_close($link);
    ?>

    <a href="add_enter.php?order_no=<?php echo $latest_order_no; ?>">送出訂單</a>

  </body>
</html>
