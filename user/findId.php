<?php
$host = "localhost";
$user = "root";
$pw = "";
$dbname = "bdguide";

// 데이터베이스에 연결합니다.
$dbcon = mysqli_connect($host, $user, $pw, $dbname);

$response = ['status' => 'error'];

if (isset($_POST['email'])) {
    // mysqli_real_escape_string SQL 인젝션 공격을 방지용
    // 사용자 입력값에 따라 SQL 쿼리가 의도치 않게 변경을 막고자 씀
    $email = mysqli_real_escape_string($dbcon, $_POST['email']);
    $query = "SELECT user_id FROM member WHERE useremail = '$email'";
    $result = mysqli_query($dbcon, $query);

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $response = ['status' => 'success', 'user_id' => $row['user_id']];
    }
}

echo json_encode($response);
mysqli_close($dbcon);
?>
