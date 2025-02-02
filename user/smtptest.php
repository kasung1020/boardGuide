<?php

require 'C:/Users/sung/vendor/autoload.php';
require 'C:/Users/sung/vendor/PHPMailer/PHPMailer/src/PHPMailer.php';
require 'C:/Users/sung/vendor/PHPMailer/PHPMailer/src/SMTP.php';

// 이메일 받는 사람 주소
$to_email = "10hmsjd15@gmail.com";

// 이메일 제목
$subject = "테스트 이메일";

// 이메일 내용
$message = "안녕하세요. 이것은 테스트 이메일입니다.";

// 이메일 발송자 주소 (Gmail 주소)
$from_email = "10hmsm1@gmail.com";

// 이메일 발송자 이름 (선택 사항)
$from_name = "bgduide_password";

// Gmail SMTP 설정
$smtp_server = "smtp.gmail.com";
$smtp_username = "10hmsm1@gmail.com";
$smtp_password = "gctq pyxx rpzh xkhw"; // Gmail 계정 비밀번호

// Gmail SMTP 설정
$mail = new PHPMailer\PHPMailer\PHPMailer;
$mail->isSMTP();
$mail->Host = $smtp_server;
$mail->SMTPAuth = true;
$mail->Username = $smtp_username;
$mail->Password = $smtp_password;
$mail->SMTPSecure = 'tls'; // 또는 'ssl'로 설정 가능
$mail->Port = 587; // 587 포트 사용

$mail->setFrom($from_email, $from_name);
$mail->addAddress($to_email);
$mail->Subject = $subject;
$mail->Body = $message;

if ($mail->send()) {
    echo "이메일이 성공적으로 보내졌습니다.";
} else {
    echo "이메일 전송에 실패했습니다. 오류 메시지: " . $mail->ErrorInfo;
}
?>

<?php
// POST 요청인 경우에만 실행
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["id"];
    $email = $_POST["email"];

    if ($id === $_POST["id"] && $email === $_POST["email"]) {
        require 'C:/Users/sung/vendor/autoload.php';

        // 이메일 받는 사람 주소
        $to_email = $email;

        // 이메일 제목
        $subject = "BDGuide : password reset email";

        // 이메일 내용 (여기에서 임시 비밀번호를 생성하거나 재설정 링크를 포함시킬 수 있습니다.)
        $message = "안녕하세요. 비밀번호를 재설정하려면 이 링크를 클릭하세요: https://example.com/reset_password";

        // 이메일 발송자 주소 (Gmail 주소)
        $from_email = "10hmsm1@gmail.com";

        // 이메일 발송자 이름 (선택 사항)
        $from_name = "BDGuide_admin";

        // Gmail SMTP 설정
        $smtp_server = "smtp.gmail.com";
        $smtp_username = "10hmsm1@gmail.com";
        $smtp_password = "gctq pyxx rpzh xkhw"; // Gmail 계정 비밀번호

        // Gmail SMTP 설정
        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->isSMTP();
        $mail->Host = $smtp_server;
        $mail->SMTPAuth = true;
        $mail->Username = $smtp_username;
        $mail->Password = $smtp_password;
        $mail->SMTPSecure = 'tls'; // 또는 'ssl'로 설정 가능
        $mail->Port = 587; // 587 포트 사용

        $mail->setFrom($from_email, $from_name);
        $mail->addAddress($to_email);
        $mail->Subject = $subject;
        $mail->Body = $message;

        if ($mail->send()) {
            echo "(이메일이 성공적으로 보내졌습니다. 이메일을 확인해주세요.)";
        } else {
            echo "이메일 전송에 실패했습니다. 오류 메시지: " . $mail->ErrorInfo;
        }
    } else {
        echo "입력한 아이디와 이메일이 일치하지 않습니다.";
    }
}
?>