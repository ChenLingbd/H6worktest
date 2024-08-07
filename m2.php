<?php
$email = $_GET['email'];
$state = $_GET['state'];

require_once "dbtools.inc.php";
$link = create_connection();
$sql = "SELECT state from mms WHERE email = '$email'";
$result = execute_sql($link, $sql);

$row = mysqli_fetch_row($result);

if( $row[0] == $state){

    $sql = "UPDATE mms SET state='enable' WHERE email = '$email'";
    execute_sql($link, $sql);
    echo "confirmed";
}
else{
    header("location: m1.html");
}
?>
