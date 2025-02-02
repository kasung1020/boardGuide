<?php
include "../common/dbconnect.php";

$comment_id = $_POST['comment_id'];

$sql = "delete from article_comments where comment_id = $comment_id";
$delete_comment = mysqli_query($dbcon, $sql);

// 변수에 이전 페이지 정보를 저장
$prevPage = $_SERVER['HTTP_REFERER'];

// 페이지 이동
header('location:'.$prevPage);

mysqli_close($dbcon);
?>