<?php
session_start();
header('Content-Type: application/json');

$host = "localhost";
$user = "root";
$pw = "";

$dbcon = mysqli_connect($host, $user, $pw);
mysqli_select_db($dbcon, "bdguide");
$dbcon->set_charset("utf8");

$response = array("isCorrect" => false);

// 비밀번호와 세션의 유저 ID 확인
if (isset($_POST['password']) && isset($_SESSION['user_id'])) {
    $userId = $_SESSION['user_id'];
    $password = $_POST['password'];
    
    $query = "SELECT userpassword FROM member WHERE user_id = '$userId'";
    $result = mysqli_query($dbcon, $query);
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        // 비밀번호 검증
        if (password_verify($password, $row['userpassword'])) {
            $response["isCorrect"] = true;
        }
    }
}

echo json_encode($response);
mysqli_close($dbcon);
?>
