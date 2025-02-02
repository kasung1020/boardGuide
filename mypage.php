<?php
include "common/dbconnect.php";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 게시물 내용</title>
    <!-- Font Awesome 5 라이브러리 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
        integrity="sha512-9usAa10IRO0HhonpyAIVpjrylPvoDwiPUiKdWk5t3PyolY1cOd4DSE0Ga+ri4AuTroPR5aQvXU9xC6qOPnzFeg=="
        crossorigin="anonymous" referrerpolicy="no-referrer">
    <!-- 폰트스타일 -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Noto+Sans+KR:wght@400;700&display=swap">
    <link href="https://fonts.googleapis.com/css2?family=Pathway+Gothic+One&display=swap" rel="stylesheet">
    <!-- 스타일시트 -->
    <link rel="stylesheet" href="css/mypage.css">
    <link rel="stylesheet" href="css/header.css">
    <link rel="stylesheet" href="css/menu.css">
    <link rel="stylesheet" href="css/main.css">
    <link rel="stylesheet" href="css/modal.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body>
    <!-- 모달 -->
    <?php
    include "common/modal.php";

    if (!isset($_SESSION['user_id'])) {
        echo "<script>alert('로그인이 필요합니다.'); history.back();</script>";
    }

    // 유저 정보 가져오기
    $user_id = $_SESSION['user_id'];
    $get_user_info_query = "SELECT userpassword, useremail FROM member WHERE user_id = '$user_id'";
    $result_user_info = mysqli_query($dbcon, $get_user_info_query);
    $row_user_info = mysqli_fetch_assoc($result_user_info);
    $userpassword = $row_user_info['userpassword'];
    $useremail = $row_user_info['useremail'];
    ?>
    <!-- 상단 로고 및 로그인 -->
    <div class="all">
        <!-- 헤더 -->
        <?php
        include "common/header.php";
        ?>
        <div class="clear"></div>
        <!-- 마이페이지 메인시작 -->
        <div class="mypage-container">
            <div class="board_write12">
                <h3
                    style="color: #444; font-size: 21px; text-align: center; font-family: 'Noto Sans KR', 'Montserrat', 'GmarketSans', 'sans-serif';">
                    나의 정보 변경하기
                </h3>
                <div class="user-info">
                    <form class="contact-form1" action="./user/update_user_info.php" method="post">
                        <div class="input-group">
                            <img src="img/id.png" class="mypage_icon">
                            <input type="id" class="contact-form-text1" value="<?php echo $user_id; ?>" readonly>
                        </div>
                        <div class="input-group">
                            <img src="img/password.png" class="mypage_icon">
                            <input id="change-password" type="password" class="contact-form-text1" name="new_password"
                                value="" readonly>
                            <button class="custom-button"
                                onclick="event.preventDefault(); toggleEditable('change-password', event)">변경</button><br>
                        </div>
                        <div class="input-group">
                            <img src="img/mail.png" class="mypage_icon">
                            <input id="change-email" type="text" class="contact-form-text1" name="new_email"
                                value="<?php echo $useremail; ?>" readonly>
                            <button class="custom-button"
                                onclick="event.preventDefault(); toggleEditable('change-email', event)">변경</button>
                            <input type="hidden" name="email_changed" id="email_changed" value="0">
                        </div>
                    </form>
                    <label for="join-id"
                        style=" color: black; font-family: 'Noto Sans KR', 'Montserrat', 'GmarketSans', 'sans-serif';">내 취향
                        테마</label>
                    <button class="custom-button1" onclick="showModal()">수정</button>
                </div>
                <div class="bt_wrap12">
                    <input type="button" class="on" value="완료"
                        style="font-size: 17px; background-color: #007BFF; border: 0px; border-radius: 5px;"
                        onclick="goTo()">
                </div>
            </div>
        </div>
        <script>
            function showModal() {
                var modal = document.getElementById('preferenceModal');
                modal.style.display = "block";
                var form = modal.querySelector('form'); // 모달 내 form 요소를 가져오기
                form.action = './user/update_user_info.php'; // form의 action 속성을 './user/update_user_info.php'로 설정 
                //form 내의 'user_settings' 이름을 가진 input 요소를 찾아서 그 value 값을 '현재 사용자 취향 테마 값'으로 설정
                form.querySelector('input[name="user_settings"]').value = '현재 사용자 취향 테마 값';
            }

            function goTo() {
                location.href = 'index.php';
            }

            function toggleEditable(id, event) {
                var inputField = document.getElementById(id);
                if (inputField) {
                    if (inputField.readOnly) {  // 읽기 전용 상태인 경우
                        // '변경 하시겠습니까?'라는 메시지와 함께 확인 대화상자를 보여줌
                        var isConfirmed = confirm('변경 하시겠습니까?');
                        // 사용자가 '확인'을 클릭했을 때만 필드를 편집 가능하게 함
                        if (isConfirmed) {
                            inputField.readOnly = false;
                            event.target.textContent = '제출';
                            if (id === 'change-email') {
                                document.getElementById('email_changed').value = '1';
                            }
                        }
                    } else {  // 편집 가능 상태인 경우
                        // '제출 하시겠습니까?'라는 메시지와 함께 확인 대화상자를 보여줌
                        var isConfirmed = confirm('제출 하시겠습니까?');
                        // 사용자가 '확인'을 클릭했을 때만 form을 제출함
                        if (isConfirmed) {
                            submitChange(event);
                        } else {
                            inputField.readOnly = true;
                            event.target.textContent = '변경';
                            if (id === 'change-email') {
                                document.getElementById('email_changed').value = '0';
                            }
                        }
                    }
                }
            }


            function submitChange(event) {
                event.target.form.submit();
            }
        </script>
        <div class="clear"></div>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>