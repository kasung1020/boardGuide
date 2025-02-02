<?php
include "common/dbconnect.php";

$gameId = $_GET['id'];

// 해당 게임의 상세 정보를 데이터베이스에서 검색
$query = "SELECT * FROM games WHERE id = $gameId";
$result = mysqli_query($dbcon, $query);
$game = mysqli_fetch_assoc($result);

if (!$game) {
    echo "게임을 찾을 수 없습니다.";
    exit;
}

// 게임 데이터를 변수에 저장
$image = $game['image'];
$name = $game['name'];
$tip = $game['tip'];
$rules = $game['rules'];
$category = explode('/', $game['category']); // 카테고리를 '/'로 분리
$players = $game['players_min'] . '~' . $game['players_max'] . '명';
$difficulty = $game['difficulty'];
$playtime = $game['playtime'];

// 게임의 좋아요 수 가져오기
$likes_query = "SELECT COUNT(*) AS like_count FROM game_likes WHERE game_id = $gameId";
$likes_result = mysqli_query($dbcon, $likes_query);
$likes_data = mysqli_fetch_assoc($likes_result);
$likes = $likes_data['like_count'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>보드게임 상세정보</title>
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
    <link rel="stylesheet" href="css/game_all_rank.css?after">
    <link rel="stylesheet" href="css/gamedata.css">
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
        <!------------- 메인 시작 -------------------------------->
        <main class="wrap" id="game_all_rank_main">
            <div class="bigpicture_gamedata">
                <div class="bigborder_gamedata">
                    <!------------- 게임테이블 시작 -------------------------------->
                    <div class="gamedata_content">
                        <div class="game_detail_maincontent">
                            <div class="game_detail_wrapper">
                                <div class="game_detail_title">
                                    <div class="game-thumb">
                                        <a class="game-thumb-link" href="#" target="_blank">
                                            <img src="<?php echo $image; ?>" alt="<?php echo $name; ?>">
                                        </a>
                                    </div>
                                    <div class="game-data-box">
                                        <div class="game-data-box-title">
                                            <div class="edit-btn">
                                                <div><a href='#' class="contact-form-btn">공유</a></div>
                                            </div>
                                        </div>
                                        <div class="game-rate">
                                            <div class="game-rate-box">
                                                <div class="game-rate-title">
                                                    <h1 class="boardgame-title">
                                                        <?php echo $name; ?>
                                                    </h1>
                                                </div>
                                            </div>
                                            <?php
                                            $wrappedTip = wordwrap($tip, 170, "<br>\n", true);
                                            ?>
                                            <div class="game-rate-tip">
                                                <div class="game-rate-tip-box">
                                                    <p class="boardgame-tip">
                                                        <?php echo $wrappedTip; ?>
                                                    </p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="display-inline">
                                            <div class="flex">
                                                <div class="genre-buttons">
                                                    <?php foreach ($category as $cat) { ?>
                                                        <button class="genre-btn">
                                                            <?php echo $cat; ?>
                                                        </button>
                                                    <?php } ?>
                                                    <!-- 좋아요 버튼 -->
                                                    <?php
                                                    echo "<form action='./gamedata/gameliked.php' method='post' style='display: inline-block;'>
                                                        <input type='hidden' name='game_id' value='$gameId'>
                                                        <button class='like-btn'>
                                                            <i class='fa fa-thumbs-up'></i> " . $likes . "
                                                        </button>
                                                    </form>";
                                                    ?>
                                                    <!-- 구매 링크 버튼 -->
                                                    <a href="https://www.gmarket.co.kr/" target="_blank"
                                                        class="purchase-btn">
                                                        구매<i class="fa fa-shopping-cart"></i>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="display-inline">
                                            <div class="flex">
                                                <div class="game-info-div">
                                                    <div class="data-value">인원수:
                                                        <?php echo $players; ?>
                                                    </div>
                                                </div>
                                                <div class="game-info-div">
                                                    <div class="data-value">난이도:
                                                        <?php echo $difficulty; ?>
                                                    </div>
                                                </div>
                                                <div class="game-info-div">
                                                    <div class="data-value">플레이시간:
                                                        <?php echo $playtime; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                $wrappedrules = str_replace('.', '.<br>', $rules);
                                ?>
                                <div class="game-rules-box">
                                    <h2 class="game-rules-title">게임 룰</h2>
                                    <p class="game-rules-content">
                                        <?php echo $wrappedrules; ?>
                                    </p>
                                </div>
                            </div>
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