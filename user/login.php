<?php
session_start();

$name = $_POST['username'];
$password = $_POST['password'];
$staylogin = isset($_POST['stayLoggedIn']) ? $_POST['stayLoggedIn'] : '';

$host = "localhost";
$user = "root";
$pw = "";

$dbcon = mysqli_connect($host, $user, $pw);
mysqli_select_db($dbcon, "bdguide");
$dbcon->set_charset("utf8");

if (mysqli_connect_errno()) {
    echo mysqli_connect_errno();
}

$sql = "select user_id, userpassword, account_status, admin from member where user_id='$name'"; //아이디 검색
$result = mysqli_query($dbcon, $sql);

$row = mysqli_fetch_array($result);
$encrypted_password = $row['userpassword'];
$account_status = $row['account_status'];

$isAdmin = false;
if ($row['admin'] == 1) {
    $isAdmin = true;
}

if ($account_status === 'N') {
    echo "<script>alert('이 계정은 비활성화되었습니다.\\n일정기간 동안 같은 회원정보로는 재가입이 불가능하니\\n관리자에게 문의하세요.'); history.back();</script>";
    exit;
}

if (password_verify($password, $encrypted_password)) {
    $_SESSION['user_id'] = $name;
    $_SESSION['isAdmin'] = $isAdmin;

    if ($staylogin === 'on') {
        $token = bin2hex(random_bytes(32));
        setcookie('staylogin', $token, time() + 86400, "/");
        
        // 토큰과 사용자 ID를 데이터베이스에 저장
        $expiry_date = date('Y-m-d H:i:s', time() + 86400);
        $update_token_query = "UPDATE `member` SET `user_token` = '$token', `token_expiry` = '$expiry_date' WHERE `user_id` = '$name'";
        mysqli_query($dbcon, $update_token_query);
    }

    echo "<script>alert('". ($isAdmin ? '관리자' : $_SESSION['user_id'])."님 환영합니다.'); location.href='../index.php';</script>";
    exit;
} else {
    echo "<script>alert('아이디 및 비밀번호가 틀렸습니다.'); history.back();</script>";
}

mysqli_close($dbcon);
?>