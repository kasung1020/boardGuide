<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // 서버 측 유효성 검사 (데이터 검증)
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_SPECIAL_CHARS);
    $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_SPECIAL_CHARS);

    if (!$email) {
        die("유효하지 않은 이메일 주소입니다.");
    }

    require 'C:/Users/sung/vendor/autoload.php';
    // require 'C:/Users/user16/vendor/autoload.php';
    $toEmail = "10hmsm1@gmail.com"; // 사이트 관리자 이메일로 변경

    // 비속어 필터링 리스트
    $badWords = ['욕', '바보', '멍청이', '죽어', '나가', '병신', '장애', '시발', '음란', '자살'];

    // 제목과 메시지 내용 검사 (대소문자 구분 없이)
    $lowerSubject = mb_strtolower($subject, 'UTF-8');
    $lowerMessage = mb_strtolower($message, 'UTF-8');

    foreach ($badWords as $word) {
        if (strpos($lowerSubject, $word) !== false || strpos($lowerMessage, $word) !== false) {
            echo "<script>
                alert('비속어나 부적절한 내용이 포함되어 있습니다.');
                window.location.href = '../contact_us.php';
            </script>";
            exit;
        }
    }
    // 이메일 제목
    $subject = "=?UTF-8?B?" . base64_encode($subject) . "?=";

    $fromEmail = $email;

    // 이메일 내용
    $message = "문의한 사용자의 이메일: " . $email . "<br><br>" . $message;

    // PHPMailer 설정
    $mail = new PHPMailer\PHPMailer\PHPMailer;
    $mail->CharSet = 'UTF-8';
    $mail->ContentType = 'text/html; charset=UTF-8';
    $mail->isSMTP(true);
    $mail->Host = "smtp.gmail.com";
    $mail->SMTPAuth = true;
    $mail->Username = "10hmsm1@gmail.com";
    $mail->Password = "gctq pyxx rpzh xkhw";
    $mail->SMTPSecure = 'tls';
    $mail->Port = 587;

    $mail->setFrom($fromEmail);
    $mail->addAddress($toEmail);
    $mail->Subject = $subject;
    $mail->Body = $message;

    // 파일 첨부 처리
    // $_FILES['userfile']이 설정되어 있고, 파일 업로드가 정상적으로 완료되었는지 확인
    if (isset($_FILES['userfile']) && $_FILES['userfile']['error'] == UPLOAD_ERR_OK) {
        // 'tmp_name' 키는 PHP가 파일을 임시로 저장하는 곳의 경로
        $uploadfile = $_FILES['userfile']['tmp_name'];
        // 'name' 키는 원래 파일의 이름
        $filename = $_FILES['userfile']['name'];
        // addAttachment 메서드를 사용하여 이메일에 파일을 첨부
        // 첫 번째 인자 파일의 임시 경로, 두 번째 인자 파일의 원래 이름
        $mail->addAttachment($uploadfile, $filename);
    }

    // 이메일 보내기
    if ($mail->send()) {
        echo "<script>
                alert('문의사항 이메일을 전송하였습니다.');
                window.location.href = '../contact_us.php';
            </script>";
        exit;
    } else {
        echo "<script>
                alert('이메일 전송에 실패했습니다. 오류 메시지: " . addslashes($mail->ErrorInfo) . "');
                window.location.href = '../contact_us.php';
            </script>";
        exit;
    }

    $dbcon->close();
}
?>