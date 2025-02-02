<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $host = "localhost";
    $user = "root";
    $pw = "";
    $dbname = "bdguide";

    $dbcon = mysqli_connect($host, $user, $pw, $dbname);
    // $dbcon = new mysqli($host, $user, $pw, $dbname);

    if ($dbcon->connect_error) {
        die("데이터베이스 연결 실패: " . $dbcon->connect_error);
    }

    $userEmail = $_POST['email'];
    $userId = $_POST['id'];

    $sql = "SELECT * FROM member WHERE useremail='$userEmail' AND user_id='$userId'";
    $result = $dbcon->query($sql);

    if ($result->num_rows > 0) {
        // 사용자 정보가 일치하는 경우
        $_SESSION['username'] = $userId; // 여기에 세션에 사용자 아이디 저장
        // require 'C:/Users/sung/vendor/autoload.php'; //내 집
        require 'C:/Users/user16/vendor/autoload.php'; //학교

        // 사용자가 재설정 요청을 했을 때 reset_completed를 0으로 설정합니다.
        $stmt = $dbcon->prepare("UPDATE member SET reset_completed = 0 WHERE useremail = ? AND user_id = ?");
        $stmt->bind_param("ss", $userEmail, $userId);
        $stmt->execute();
        $stmt->close(); // 항상 실행한 후에는 statement를 닫아줍니다.

        // 이메일 받는 사람 주소
        $toEmail = $userEmail;

        // 이메일 제목
        $subject = "=?UTF-8?B?" . base64_encode("BDGuide: 비밀번호 재설정 이메일") . "?=";

        // 재설정 링크 생성 (임의로 생성하거나 원하는 방식으로 변경 가능)
        $resetLink = "http://localhost/BDGUIDE_UPDATE/newpassword.php?id=$userId&email=$userEmail";

        // 이메일 내용 (재설정 링크를 포함)
        $message = "안녕하세요. 비밀번호를 재설정하려면 다음 링크를 클릭하세요: $resetLink";

        // 이메일 발송자 주소 (Gmail 주소)
        $fromEmail = "10hmsm1@gmail.com";

        // 이메일 발송자 이름 (선택 사항)
        $fromName = "BDGuide_admin";

        // Gmail SMTP 설정
        $smtpServer = "smtp.gmail.com";
        $smtpUsername = "10hmsm1@gmail.com";
        $smtpPassword = "gctq pyxx rpzh xkhw"; // Gmail 계정 비밀번호

        // Gmail SMTP 설정
        $mail = new PHPMailer\PHPMailer\PHPMailer;
        $mail->CharSet = 'UTF-8';
        $mail->ContentType = 'text/html; charset=UTF-8'; // 이 부분 추가
        $mail->isSMTP(true);
        $mail->Host = $smtpServer;
        $mail->SMTPAuth = true;
        $mail->Username = $smtpUsername;
        $mail->Password = $smtpPassword;
        $mail->SMTPSecure = 'tls'; // 또는 'ssl'로 설정 가능
        $mail->Port = 587; // 587 포트 사용

        $mail->setFrom($fromEmail, $fromName);
        $mail->addAddress($toEmail);
        $mail->Subject = $subject;
        $mail->Body = '
        <html>
        <head>
        <title>비밀번호 재설정 요청</title>
        </head>
        <body style="font-family: Arial, sans-serif; background-color: #eeeeee; margin: 0; padding: 0;">
        <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border-collapse: collapse; border: 1px solid #cccccc; background-color: #ffffff;">
            <tr>
                <td align="center" style="padding: 40px 0 30px 0;">
                    <img src="https://i.postimg.cc/43Qy8vvS/bdguide.png" alt="BDGuide Logo" width="60%" height="50%" style="display: block;">
                </td>
            </tr>
            <tr>
                <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td align="center" style="color: #153643; font-size: 24px;">
                                <b>비밀번호 재설정 요청</b>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" style="padding: 20px 0 30px 0; color: #153643; font-size: 16px; line-height: 20px;">
                                안녕하세요, 비밀번호를 재설정하려면 아래 버튼을 클릭하세요.
                            </td>
                        </tr>
                        <tr>
                            <td align="center">
                                <a href="' . $resetLink . '" style="background-color: #4CAF50; color: white; padding: 15px 25px; border: none; text-decoration: none; display: inline-block;">비밀번호 재설정</a>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td bgcolor="#ee4c50" style="padding: 30px 30px;">
                    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse;">
                        <tr>
                            <td style="color: #ffffff; font-size: 14px;" align="center">
                                © BDGuide 2023. All rights reserved.
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
        </body>
        </html>
        ';
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        // 이메일 보내기
        if ($mail->send()) {
            // 이메일이 성공적으로 전송되었음을 처리
            // echo json_encode(array("status" => "success")); 
            // alert('비밀번호 재설정 이메일을 전송하였습니다. 이메일을 확인해 주세요.');
            echo "<script>
                    alert('비밀번호 재설정 이메일을 전송하였습니다. 이메일을 확인해 주세요.');
                    window.location.href = '../index.php';
                </script>";
            exit;
        } else {
            // echo json_encode(array("status" => "error", "message" => "이메일 전송에 실패했습니다. 오류 메시지: " . $mail->ErrorInfo));
            echo "<script>
                    alert('이메일 전송에 실패했습니다. 오류 메시지: " . addslashes($mail->ErrorInfo) . "');
                    window.location.href = '../index.php';
                </script>";
            exit;
        }
    } else {
        // echo json_encode(array("status" => "error", "message" => "입력한 아이디와 이메일이 일치하지 않습니다."));
        echo "<script>
                alert('아이디와 이메일이 일치하는 사용자를 찾을 수 없습니다.');
                window.location.href = '../index.php';
            </script>";
        exit;
    }

    $dbcon->close();
}
?>