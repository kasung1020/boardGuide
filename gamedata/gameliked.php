<?php
include "../common/dbconnect.php";

session_start();

if (isset($_SESSION['user_id'])){

    $user_id = $_SESSION['user_id'];
    $game_id = $_POST['game_id'];

    $game_get_liked = "SELECT * FROM game_likes WHERE user_id = '$user_id' AND game_id = $game_id";
    $result_liked = mysqli_query($dbcon, $game_get_liked);

    if ($result_liked && mysqli_num_rows($result_liked) > 0) {
        echo "<script>alert('이미 추천한 게임입니다.');</script>";
    } else {
        $liked = "INSERT INTO game_likes(user_id, game_id) VALUES ('$user_id', $game_id)";
        $exec_liked = mysqli_query($dbcon, $liked);

        // games 테이블의 좋아요 카운트 업데이트
        if ($exec_liked) {
            $update_likes = "UPDATE games SET likes = likes + 1 WHERE id = $game_id";
            mysqli_query($dbcon, $update_likes);
        }
    }

    echo "<script>history.back();</script>";

} else {
    echo "<script>alert('로그인이 필요합니다.');history.back();</script>";
}
mysqli_close($dbcon);
?>
