<?php
include "../common/dbconnect.php";

$current_post = $_POST['current_post'];

if (isset($_POST['isNotice'])) {
    $sql = "delete from notice where notice_id = $current_post";
    $delete_article = mysqli_query($dbcon, $sql);

    header('location:../notice.php');
} else {
    $sql = "delete from article where article_id = $current_post";
    $delete_article = mysqli_query($dbcon, $sql);
    
    header('location:../board.php');
}

mysqli_close($dbcon);
?>