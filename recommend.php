<?php
  require_once("dbtools.inc.php");
  header("Content-type: text/html; charset=utf-8");

  //取得表單資料
  $name = $_POST["name"];
  $introduction = $_POST["introduction"];

  //建立資料連接
  $link = create_connection();

  //執行 SELECT 陳述式來選取候選項目資料
  $sql = "SELECT * FROM candidate WHERE name='$name'";
  $result = execute_sql($link, $sql);

  //檢查被推薦是否有在候選項目清單
  if (mysqli_num_rows($result) == 0)
  {
    //釋放資源
    mysqli_free_result($result);

    //將候選資料加入資料庫
    $sql = "INSERT INTO candidate (name , introduction , score)
            VALUES ('$name', '$introduction', 0)";
    $result = execute_sql($link, $sql);

    //將使用者導向線上投票首頁
    header("location:v2.php");
  }
  else
  {
    //顯示被推薦人已經是候選的訊息
    echo "<p align='center'>您推薦的已經在商品項目，不需要再推薦。</p>";
    echo "<p align='center'><a href ='javascript:history.back()'>回上一頁</a>";
    echo "　　<a href='v2.php'>回首頁</a></p>";
  }

  //關閉資料連接
  mysqli_close($link);
?>