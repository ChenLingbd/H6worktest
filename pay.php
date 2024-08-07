<!doctype html>
<html>
<head>
    <meta charset="utf-8">
    <title>付款方式</title>
</head>
<body>
<h1 align="center">您的訂單已送出</h1>
<h2 align="center">請選擇付款方式</h2>
    <?php
    // 檢查用戶是否存在
    if (empty($_COOKIE['name'])) {
        echo "<script type='text/javascript'>";
        echo "alert('用戶信息缺失');";
        echo "history.back();";
        echo "</script>";
        exit;
    }
    
    // 取得用戶名
    $user = $_COOKIE['name'];
    ?>

    <form action="process_payment.php" method="post" align="center">
        <p>用戶名：<strong><?php echo htmlspecialchars($user); ?></strong></p>
        <p>
            <label>
                <input type="radio" name="payment_method" value="cash_on_delivery" required>
                貨到付款
            </label>
        </p>
        <p>
            <label>
                <input type="radio" name="payment_method" value="online_payment" required>
                線上付款
            </label>
        </p>
        <input type="hidden" name="user" value="<?php echo htmlspecialchars($user); ?>">
        <button type="submit">送出</button>
    </form>
</body>
</html>
