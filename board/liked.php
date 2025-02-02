<?php
include "../common/dbconnect.php";

session_start();

$target_post = $_POST['target_post'];
$liked_user = $_SESSION['user_id'];

$get_liked = "select * from article_liked where article_id = $target_post and liked_user = '$liked_user'";
$result_liked = mysqli_query($dbcon, $get_liked);

if ($result_liked && mysqli_num_rows($result_liked)) {
    echo "<script>alert('이미 추천한 게시물입니다.');</script>";
} else {
    $liked = "insert into article_liked(article_id, liked_user) values ($target_post, '$liked_user')";
    $exec_liked = mysqli_query($dbcon, $liked);
}

echo "<script>history.back();</script>";

mysqli_close($dbcon);
?>