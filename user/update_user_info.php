<?php
session_start();

// 데이터베이스 연결 설정
$host = "localhost";
$user = "root";
$pw = "";
$dbname = "bdguide";

$dbcon = mysqli_connect($host, $user, $pw, $dbname);
mysqli_set_charset($dbcon, "utf8");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
}

// 세션에서 사용자 아이디를 가져옴
$user_id = $_SESSION['user_id'];

// 사용자의 기존 정보를 가져옴
$get_user_info_query = "SELECT userpassword FROM member WHERE user_id = '$user_id'";

$get_user_info_query2 = "SELECT useremail FROM member WHERE user_id = '$user_id'";

$result_user_info = mysqli_query($dbcon, $get_user_info_query);
$row_user_info = mysqli_fetch_assoc($result_user_info);

$result_user_info2 = mysqli_query($dbcon, $get_user_info_query2);
$row_user_info2 = mysqli_fetch_assoc($result_user_info2);

$userpassword = $row_user_info['userpassword'];
$useremail = $row_user_info2['useremail'];

// POST로 전송된 새로운 비밀번호와 이메일 값을 가져옴
$new_password = isset($_POST['new_password']) ? $_POST['new_password'] : '';
$new_email = isset($_POST['new_email']) ? $_POST['new_email'] : '';

// 비밀번호가 변경되었을 경우, 비밀번호 해싱 처리
if (!empty($new_password)) {
    // 사용자가 입력한 새로운 비밀번호와 기존의 해시된 비밀번호 비교
    if (password_verify($new_password, $userpassword)) {
        echo "<script>alert('기존의 비밀번호와 동일합니다. 새로운 비밀번호를 입력해주세요.'); history.back();</script>";
        exit();
    } else {
        $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
        $update_password_query = "UPDATE member SET userpassword = '$hashed_password' WHERE user_id = '$user_id'";
        mysqli_query($dbcon, $update_password_query);
    }
}

// 이메일이 변경되었을 경우, 이메일 업데이트
$email_changed = isset($_POST['email_changed']) ? $_POST['email_changed'] : '0';

if (!empty($new_email) && $new_email !== $useremail && $email_changed === '1') {
    $update_email_query = "UPDATE member SET useremail = '$new_email' WHERE user_id = '$user_id'";
    mysqli_query($dbcon, $update_email_query);
} else if ($new_email === $useremail && $email_changed === '1') {
    echo "<script>alert('기존의 이메일과 동일합니다. 새로운 이메일을 입력해주세요.'); history.back();</script>";
    exit();
}


$new_user_settings = isset($_POST['user_settings']) ? $_POST['user_settings'] : '';

if (!empty($new_user_settings)) {
    $update_user_settings_query = "UPDATE member SET user_settings = '$new_user_settings' WHERE user_id = '$user_id'";
    mysqli_query($dbcon, $update_user_settings_query);
}

// 데이터베이스 연결 종료
mysqli_close($dbcon);

// 완료 메시지
echo "<script>alert('정보가 성공적으로 업데이트되었습니다.'); history.back();</script>";
?>
