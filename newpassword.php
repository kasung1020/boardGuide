<?php
include "common/dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide</title>
    <!-- Font Awesome 5 라이브러리 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- 폰트스타일 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">
    <!-- 스타일시트 -->
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/modal.css?after">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <!-- 모달 -->
    <?php
    include "common/modal.php";
    ?>
    <!-- 화면시작 -->
    <div class="all">
        <!-- 헤더 -->
        <?php
        include "common/header.php";
        ?>
        <!--시작-->
        <!-- 비밀번호 찾기 인증 창  -->
        <div id="findpasswordemail">
            <div class="modal_content in_fixed_btn on">
                <div class="login_logo">
                    <img src="img/bdguide.png" alt="로고 이미지">
                </div>
                <?php
                    $username = isset($_SESSION['username']) ? $_SESSION['username'] : 'Unknown'; 
                ?>
                <!-- 탭 메뉴 시작 -->
                <div class="findpassword_label">
                    <!-- htmlspecialchars 아이디에 특수문자 처리 방지 -->
                    <h1><?= htmlspecialchars($username) ?> 사용자님의 비밀번호 변경</h1>
                </div>
                <!-- 탭 메뉴 끝 -->
                <?php
                // URL에서 사용자 ID와 이메일을 가져옵니다.
                $userId = $_GET['id'] ?? null;
                $userEmail = $_GET['email'] ?? null;

                // 사용자의 재설정 완료 상태를 확인합니다.
                $stmt = $dbcon->prepare("SELECT reset_completed FROM member WHERE useremail = ? AND user_id = ?");
                $stmt->bind_param("ss", $userEmail, $userId);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                // 이미 재설정이 완료되었다면 사용자를 리디렉션합니다.
                if ($user && (int)$user['reset_completed'] === 1) {
                    echo "<script>
                            alert('비밀번호 재설정이 이미 완료되었습니다.');
                            window.close(); // 에러 메시지 후 창을 닫음
                        </script>";
                    exit;
                } 
                ?>
                <!-- 비밀번호 탭 컨텐츠 시작 -->
                <form id="newfindpasswordForm" action="./user/resetpassword.php" method="post">
                    <label for="newfindpassword">새 비밀번호</label>
                    <input type="password" id="newfindpassword" name="newpassword" required><br>
                    <span id="passwordError" class="signUperror">8 ~ 16자의 영문 대/소문자, 숫자를 사용해주세요.</span>
                    <label for="newfindpassword-confirm">새 비밀번호 확인</label>
                    <input type="password" id="newfindpassword-confirm" name="newpassword-confirm" required><br>
                    <span id="confirmError" class="signUperror">비밀번호가 일치하지 않습니다.</span>
                    <button type="submit" id="pwFindBtn">비밀번호 변경</button>
                </form>
            </div>
        </div>
        <div class="clear"></div>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>