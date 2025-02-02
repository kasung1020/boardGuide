    <?php
    session_start();

    $host = "localhost";
    $user = "root";
    $pw = "";
    $dbname = "bdguide";

    $dbcon = mysqli_connect($host, $user, $pw, $dbname);

    if (isset($_SESSION['username'], $_POST['newpassword'], $_POST['newpassword-confirm'])) {
        $username = $_SESSION['username'];
        // 먼저 사용자의 현재 비밀번호를 데이터베이스에서 가져옵니다.
        $stmt = $dbcon->prepare("SELECT userpassword FROM member WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();
        
        if ($user && password_verify($_POST['newpassword'], $user['userpassword'])) {
            // 새 비밀번호가 기존 비밀번호와 같으면 오류 메시지를 출력합니다.
            echo "<script>
                    alert('새 비밀번호가 기존 비밀번호와 동일합니다.');
                    window.history.back();
                  </script>";
            exit;
        }
    
        if ($_POST['newpassword'] === $_POST['newpassword-confirm']) {
            $new_password = password_hash($_POST['newpassword'], PASSWORD_DEFAULT); // 새 비밀번호를 해싱
    
            // 준비된 문을 사용하여 비밀번호를 데이터베이스에 업데이트합니다.
            $stmt = $dbcon->prepare("UPDATE member SET userpassword = ?, reset_completed = 1 WHERE username = ?");
            $stmt->bind_param("ss", $new_password, $username);
    
            if ($stmt->execute()) {
                echo "<script>
                        alert('비밀번호가 성공적으로 변경되었습니다.');
                        window.location.href = '../index.php';    
                      </script>";
            } else {
                echo "비밀번호 변경에 실패하였습니다.";
                exit; // 스크립트 종료
            }
            $stmt->close(); // 준비된 문 닫기
        } else {
            // 비밀번호가 일치하지 않을 경우
            echo "<script>
                    alert('입력한 비밀번호가 일치하지 않습니다.');
                    window.history.back(); // 사용자를 이전 페이지로 이동
                  </script>";
            exit; // 스크립트 종료
        }
    } else {
        // 필수 데이터가 제공되지 않았을 경우
        echo "필수 정보가 누락되었습니다.";
        exit; // 스크립트 종료
    }
    
    $dbcon->close();
    ?>