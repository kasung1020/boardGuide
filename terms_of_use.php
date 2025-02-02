<?php
include "common/dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 서비스 이용 약관 및 개인정보 보호 정책</title>
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
        <main class="wrap" style="height: 640px;">
            <div id="eula" class="eula_font_black">
                <h1>BDGuide 서비스 이용 약관 및 개인정보 보호 정책</h1>
                <br>
                <h2>약관 동의</h2>
                <p>BDGuide 에서 제공하는 인증 서비스에 액세스하거나 이를 사용함으로써 귀하는 본 인증 이용 약관("약관")을 준수하고 이에 구속된다는 데 동의합니다. 본 약관에 동의하지 않는
                    경우 인증 서비스를 이용하지 마십시오.</p>
                <br>
                <h2>계정 등록</h2>
                <p>귀하는 계정 등록 과정에서 정확하고 완전한 정보를 제공해야 합니다.<br>
                귀하는 사용자 이름과 비밀번호를 포함하여 인증 자격 증명의 기밀성을 유지할 책임이 있습니다. 귀하의 인증 자격 증명을 사용하여 수행된 모든 활동이나 조치에 대한 책임은 전적으로
                귀하에게 있습니다.</p>
                <br>
                <h2>접속 및 이용</h2>
                <p>귀하는 합법적인 목적으로 그리고 모든 관련 법률 및 규정을 준수하는 경우에만 인증 서비스를 사용할 수 있습니다.</p>
                <p>귀하는 인증 자격 증명을 제3자에게 공유, 양도 또는 판매할 수 없습니다.</p>
                <br>
                <h2>개인정보 보호 및 데이터 보호</h2>
                <p>귀하의 인증 서비스 사용에는 당사가 귀하의 개인 정보를 수집, 사용 및 보호하는 방법을 설명하는 개인 정보 보호 정책이 적용됩니다.</p>
                <br>
                <h2>약관 수정</h2>
                <p>당사는 수시로 본 약관을 업데이트하거나 수정할 수 있습니다. 모든 변경 사항은 웹사이트에 게시된 시점부터 효력이 발생합니다. 그러한 변경 후에도 인증 서비스를 계속 사용하면 수정된
                약관에 동의하는 것으로 간주됩니다.</p>
                <br>
                <h2>책임의 제한</h2>
                <p>어떤 경우에도 당사는 귀하의 인증 서비스 사용과 관련하여 발생하는 간접적, 결과적, 특별 또는 징벌적 손해에 대해 책임을 지지 않습니다.</p>
            </div>
        </main>
        <!-- 푸터 -->
        <?php
            include "common/footer.php";
        ?>
    </div>
</body>

</html>