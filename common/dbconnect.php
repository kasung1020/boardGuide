<?php
$host = "127.0.0.1";
$user = "root";
$pw = "";

$dbcon = mysqli_connect($host, $user, $pw);

// DB 선택
$db_select = mysqli_select_db($dbcon, "bdguide");
?>