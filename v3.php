<?php
  //檢查是否登入
  session_start();
  if (!isset($_SESSION['account'])) {
    echo "<p align='center'>要登入才能使用本功能喔!</p>";
    exit();
  }
?>

<!DOCTYPE html>
<html>
<head>
  <meta charset="UTF-8">
  <title>商品介面</title>
</head>
<body bgcolor="#FFE6CC">
  <h1 align="center">商品介面</h1>
  <form name="myForm" method="post" >
    <table width="75%" align="center" border="2" bordercolor="#999999">
      <tr bgcolor="#0033CC">
        <td align="center" style='font-size: 50px;'><font color="#FFFFFF">書名</font></td>
        <td align="center" style='font-size: 36px;'><font color="#FFFFFF">說明</font></td>       
        <td align="center" style='font-size: 36px;'><font color="#FFFFFF">價格</font></td>
        <td align="center" style='font-size: 36px;'><font color="#FFFFFF">存量</font></td>  
        <td align="center" style='font-size: 36px;'><font color="#FFFFFF">圖片</font></td>
        <td align="center" style='font-size: 36px;'><font color="#FFFFFF">操作</font></td>

      </tr>
      <?php
        require_once("dbtools.inc.php");

        //建立資料連接
        $link = create_connection();

        //執行 Select 陳述式選取候選資料
        $sql = "SELECT * FROM com_man";
        $result = execute_sql($link, $sql);

        while ($row = mysqli_fetch_object($result))
        {
          echo "<tr>";
          echo "<td bgcolor='#FFCCCC' style='font-size: 28px;'>$row->name</td>";
          echo "<td bgcolor='#CCFFCC' style='font-size: 28px;'>$row->introduce</td>";
          echo "<td bgcolor='#FFCCCC' style='font-size: 24px;'>$row->price</td>";
          echo "<td bgcolor='#CCFFCC' style='font-size: 24px;'>$row->stock</td>";
          echo "<td bgcolor='#CCFFCC' style='max-width: 100px; max-height: 100px;'><img src='./image/$row->id.jpg' alt='book_image' style='width:100%; height:auto;'></td>
          ></td>";
          echo "<td bgcolor='#FFCCCC' style='font-size: 24px;'><a href='v4.php?id=$row->id'>修改</a></td>";
          echo "</tr>";
        }

        //關閉資料連接
        mysqli_close($link);
      ?>
    </table>
    <p align="center">
      <input type="button" value="新增商品"
          onclick="javascript:window.open('v1.html','_self')">
    </p>
  </form>
</body>
</html>
