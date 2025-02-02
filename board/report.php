<?php
include "../common/dbconnect.php";

if ($_POST['report_content'] == "post") {
    // 신고 횟수 추가
    $sql = "update article set reported = article.reported + 1 where article_id = $_POST[content_id]";
    $result = mysqli_query($dbcon, $sql);

    // 신고 누적 시 자동 삭제
    $sql = "select reported from article where article_id = $_POST[content_id]";
    $result = mysqli_query($dbcon, $sql);

    $row = mysqli_fetch_array($result);
    if ($row['reported'] >= 3) {
        $sql = "delete from article where article_id = $_POST[content_id]";
        $result = mysqli_query($dbcon, $sql);
        echo "<script>alert('신고가 정상적으로 접수되었습니다.');</script>";
        header('location:../board.php');
    } else {
        echo "<script>history.back();</script>";
    }
} else if ($_POST['report_content'] == "comment") {
    // 신고 횟수 추가
    $sql = "update article_comments set reported = article_comments.reported + 1 where comment_id = $_POST[content_id]";
    $result = mysqli_query($dbcon, $sql);

    // 신고 누적 시 자동 삭제
    $sql = "select reported from article_comments where comment_id = $_POST[content_id]";
    $result = mysqli_query($dbcon, $sql);

    $row = mysqli_fetch_array($result);
    if ($row['reported'] >= 3) {
        $sql = "delete from article_comments where comment_id = $_POST[content_id]";
        $result = mysqli_query($dbcon, $sql);
    }

    echo "<script>alert('신고가 정상적으로 접수되었습니다.'); history.back();</script>";
}


?>