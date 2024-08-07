<?php
require_once 'dbtools.inc.php';

$account = $_POST['account'];
$upass = $_POST['password'];
$name = $_POST['name'];
$email = $_POST['email'];
$state = "123456";
for($i = 0; $i < 6; $i++){
    $state[$i]= chr(random_int(ord('A'), ord('Z')));
}
$link = create_connection();
$sql = "INSERT INTO mms(account, password, name, email, state) VALUES('$account', '$upass','$name','$email', '$state');";
$result = execute_sql($link, $sql);
echo $result;

require 'pmail.inc.php';
$mail = getmail();

$to_email=$to_name=$email;
$from_email="dppss99015@gmail.com";
$from_name="=?utf-8?B?".base64_encode('大衣公司')."?=";
$mail->setFrom($from_email, $from_name);
$mail->addAddress($to_email, $to_name);
$mail->Subject = "email confirm";
$message="帳號開通： <a href='http://localhost/u1133141/H3/m2.php?email=$email&state=$state'>開啟</a>";
$mail->isHTML(true);
$mail->Body=$message;

if( !$mail->send()){
    echo 'mail send fail!';
}else{
    echo 'mail send!';
}
?>