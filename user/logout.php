<?php
session_start(); // 세션을 시작합니다.

$host = "localhost";
$user = "root";
$pw = "";

// 데이터베이스에 연결합니다.
$dbcon = mysqli_connect($host, $user, $pw);
mysqli_select_db($dbcon, "bdguide");
$dbcon->set_charset("utf8");

// 로그인 상태 유지 쿠키가 존재하는 경우
if (isset($_COOKIE['staylogin'])) {
    // 쿠키를 삭제합니다.
    setcookie('staylogin', '', time() - 3600, "/");

    // 현재 로그인한 사용자의 ID를 가져옵니다.
    $user_id = $_SESSION['user_id'];

    // 데이터베이스에서 해당 사용자의 토큰 정보를 초기화합니다.
    $query = "UPDATE `member` SET `user_token` = NULL, `token_expiry` = NULL WHERE `user_id` = '$user_id'";
    mysqli_query($dbcon, $query);
}

session_destroy(); // 모든 세션 변수를 제거하고 세션을 종료합니다.
header("Location: ../index.php"); // 사용자를 홈페이지로 리다이렉트합니다.
exit;
?>