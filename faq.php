<?php
include "common/dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 자주 묻는 질문</title>
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
        <main class="wrap" style="height: 900px;">
            <div id="eula" class="eula_font_black">
                <h1>자주 묻는 질문(FAQ)</h1>
                <br>
                <h2>BDGuide</h2>
                <br>
                <h3>BDGuide는 무엇인가요?</h3>
                <p>BordGuide는 전통적인 보드 게임에 관한 데이터와 정보를 모은 데이터베이스입니다. 이곳에 저장된 게임 정보는 미래를 위한 자료, 역사 연구, 그리고 사용자 평가를 위한 것으로
                    사용됩니다.
                    당사 데이터베이스 내의 모든 정보는 소중한 사용자 분들의 노고 덕분에 게임 별로 철저하게 정리되고 수동으로 기록되었습니다.
                    이 정보는 유연한 쿼리 및 "데이터 마이닝"을 통해 자유롭게 활용할 수 있도록 제공됩니다.</p>
                <br>
                <h3>회원가입이 필요한가요?</h3>
                <p>이 사이트는 기본적으로 회원가입을 할 필요가 없으며, 원한다면 익명으로 BDGuide 페이지를 모두 둘러볼 수 있습니다. 그러나 게시판에 글을 쓰기 위해서는 회원가입이 필요합니다.
                </p>
                <p>회원가입은 무료이며 회원 정보는 타 기관에 전달되지 않습니다.</p>
                <br>
                <h3>하나 이상의 계정을 가질 수 있나요?</h3>
                <p>네, 서비스를 악의적으로 이용하지 않고, 서비스 약관 및 커뮤니티 규칙을 준수한다면 가능합니다. 대부분의 사용자는 하나는 개인 계정으로, 다른 하나는 비즈니스 계정으로 사용하여 여러
                    계정을 관리합니다.
                    사용자분들은 자신의 계정을 통해 발생하는 모든 활동에 대한 책임을 져야 하며, 부적절한 사용으로 인한 손실에 대해 귀하에게 책임을 물을 수 있습니다.</p>
                <br>
                <h3>내 계정을 삭제할 수 있나요?</h3>
                <p>당사에서는 언제든지 귀하의 계정을 삭제할 수 있는 옵션을 제공합니다. 그러나 이 작업은 영구적이며 취소할 수 없습니다.
                    이미지, 비디오 및 기타 형식으로 제출한 모든 콘텐츠는 수동으로 삭제하지 않는 한 "해당자에 의해 제출됨"으로 유지됩니다.
                    귀하가 시작한 스레드는 계정 삭제 후에도 남아 있지만 귀하의 기여는 사라지게 됩니다.</p>
                <br>
                <h3>어떻게 도움을 요청하나요?</h3>
                <p>도움말 및 방법 포럼에 질문을 게시하여 친절한 커뮤니티 멤버들로부터 도움을 요청할 수 있습니다.
                    관리자와 대화해야 하는 경우, BDGuide 문의하기를 이용하여 주십시요. 저희 BDGuide는 기꺼이 도움을 드리겠습니다.</p>
                <br>
                <h3>게임 룰을 어떻게 이해하나요?</h3>
                <p>하고싶은 게임을 클릭하여 들어가면 자세한 룰 설명을 보실 수 있습니다. 저희 BDGuide는 인원수와 자세한 룰 설명 그리고 난이도의 정보를 제공합니다.</p>
                <br>
                <h3>어떤 종류의 보드 게임이 있나요?</h3>
                <p>BDGuide는 다양한 보드 게임을 소개하는 플랫폼으로, 추리, 경쟁, 마피아, 블러핑, 탐험, 협력, 경제, 추상전략, 타일놓기, 방탈출, 카드게임
                    그리고 심지어 테트리스와 같은 다양한 게임 카테고리를 포함하고 있습니다.</p>
                <br>
                <h3>초보자들이 할 만한 게임은 뭐가 있나요?</h3>
                <p>초보자들을 위한 게임으로는 "할리갈리," "스플렌더," "코드네임," "루미큐브," 그리고 "블루마블"과 같은 게임들이 훌륭한 선택입니다.
                    이러한 게임들은 규칙이 간단하고 빠르게 배울 수 있으며, 즐거운 게임 경험을 제공합니다.</p>
            </div>
        </main>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>