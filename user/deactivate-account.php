<?php
session_start();

$host = "localhost";
$user = "root";
$pw = "";
$database = "bdguide";

$dbcon = new mysqli($host, $user, $pw, $database);

$dbcon->set_charset("utf8");

if (isset($_SESSION['user_id']) && $_SESSION['user_id'] != '') {
    $user_id = $_SESSION['user_id'];

    // 데이터베이스에서 회원 정보 삭제 쿼리를 준비합니다.
    $sql = "UPDATE member SET account_status = 'N' WHERE user_id = ?";

    // 쿼리를 준비하고 파라미터를 바인딩합니다.
    if($stmt = $dbcon->prepare($sql)) {
        $stmt->bind_param('s', $user_id); // 's'는 변수 타입이 문자열

        // 쿼리를 실행합니다.
        if($stmt->execute()) {
            // 세션과 쿠키를 파괴합니다.
            session_destroy();
            if(isset($_COOKIE['staylogin'])) {
                setcookie('staylogin', '', time() - 3600, '/'); // 쿠키 삭제
            }
            // 회원 탈퇴 처리 완료 응답을 보냅니다.
            echo json_encode(array('status' => 'success'));
        } else {
            // 쿼리 실행에 실패했을 경우 오류 응답을 보냅니다.
            echo json_encode(array('status' => 'error', 'message' => 'Could not execute the query.'));
        }
        $stmt->close();
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Could not prepare statement.'));
    }
} else {
    echo json_encode(array('status' => 'session_not_set'));
}
$dbcon->close();
exit;
?>
