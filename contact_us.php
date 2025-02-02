<?php
include "common/dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 문의하기</title>
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
    <link rel="stylesheet" href="css/modal.css">
    <link rel="stylesheet" href="css/contact us.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
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

        <div class="clear"></div>
        <main class="wrap" id="contact_autoheight">
            <div id="contact-main-box">
                <div class="contact-main">
                    <div class="left-container">
                        <div class="contact-left_left">
                            <div class="contact_box">
                                <h1>Contact us</h1>
                                <p>문의 사항이 있으신가요?  문의 양식을 작성해주세요.<br>
                                    <p>&nbsp;</p>
                                    <span>
                                        문의하기 전에
                                        <span>
                                            <a href="faq.php" id="contact_us_link" target="_blank">자주 묻는 질문</a>
                                            도 참고해보세요.
                                        </span>
                                    </span>
                                </p>
                            </div>
                        </div>
                    </div>
                    <script>
                    // 페이지가 로드 되었을 때 함수를 실행
                    $(document).ready(function(){
                        // '#contact-form'이라는 ID를 가진 요소에서 submit 이벤트가 발생하면 실행.
                        $('#contact-form').on('submit', function(e){
                            e.preventDefault(); // 기본 제출 이벤트 방지

                            $.ajax({
                                type: 'POST', // HTTP 요청 방식을 POST로 설정
                                url: $(this).attr('action'), // 요청을 보낼 URL을 form의 action 속성 값으로 설정
                                data: $(this).serialize(), // form의 데이터를 직렬화하여 요청에 포함

                                // 요청이 성공적으로 완료되면 다음의 함수를 실행합니다.
                                success: function(response){
                                    alert('문의가 성공적으로 제출되었습니다.');
                                },
                                error: function(){
                                    alert('문의 제출에 실패했습니다.');
                                }
                            });
                        });
                    });
                    </script>
                    <div class="right-container">
                        <div id="contact-form-box">
                            <h1>문의하기</h1>
                            <form class="contact-form" action="./user/send_inquiry.php" method="post" enctype="multipart/form-data">
                                <label for="subject">제목</label>
                                <input type="text" class="contact-form-text" name="subject" placeholder="제목을 입력해주세요." require>
                                <label for="email">Email</label>
                                <input type="email" class="contact-form-text" name="email" require>
                                <label for="message">내용</label>
                                <div>
                                    <textarea class="contact-form-text" style="height: 100px" name="message" required></textarea>
                                </div>
                                <input class="dd1" type="file" name="userfile" style="color: black; margin-top: 20px;"></input>
                                <div class="button-container">
                                    <input type="submit" class="contact-form-btn" value="보내기">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </main>
        <div class="clear"></div>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>