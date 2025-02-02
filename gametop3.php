<?php
include "common/dbconnect.php";
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="google" content="notranslate">
    <title>BDGuide : 게임 추천 TOP 3</title>
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
    <link rel="stylesheet" href="css/gametop3.css?after">
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

    if (isset($_SESSION['user_id'])) {
        $user_id = $_SESSION['user_id'];

        // 사용자 선호 테마 가져오기
        $get_user_theme = "SELECT user_settings FROM member WHERE user_id = '$user_id'";
        $result_user_theme = mysqli_query($dbcon, $get_user_theme);
        $row = mysqli_fetch_assoc($result_user_theme);
        $user_themes = explode(" ", $row['user_settings']); // 테마를 공백으로 분리
        
        if (empty($user_themes[0])) {
            // 유저의 user_settings 값이 없는 경우
            die("<script>alert('마이페이지에서 게임 취향을 골라주세요.'); history.back();</script>");
        }
    
    } else {
        // 로그인이 필요한 경우 대체 처리를 여기에 추가
        die("<script>alert('로그인이 필요합니다.'); history.back();</script>");
    }
    
    ?>

    <!-- 화면시작 -->
    <div class="all">
        <?php
        include "common/header.php";
        ?>

        <div class="clear"></div>

        <!-- 광고 배너 -->
        <!-- 탑3에는 광고 배너 넣을 생각 없음 넣지마셈 -->
        <div class="clear"></div>
        <!------------- 탑3 시작 -------------------------------->
        <main class="wrap" style="height: 600px;">
            <div class="bigpicture_gametop3">
                <div class="bigborder_gametop3">
                    <div class="content-container">
                        <h2 class="top3_title2">TOP 3 게임 추천 <img src="img/crown.png" class="crown_img4" alt="crown">
                        </h2>
                    </div>
                    <div class="center_img">
                    <?php
                        $medals = array('img/gold.png', 'img/silver.png', 'img/bronze.png');

                        // 모든 게임 데이터 가져오기
                        $get_all_games = "SELECT * FROM games";
                        $result_all_games = mysqli_query($dbcon, $get_all_games);

                        $matched_games = array();
                        while ($row = mysqli_fetch_assoc($result_all_games)) {
                            // 코드에서 중복된 부분 제거
                            foreach ($user_themes as $user_theme) {
                                $game_themes = explode("/", $row['category']);
                                if (in_array($user_theme, $game_themes)) {
                                    $gameId = $row['id'];
                                    $likes_query = "SELECT COUNT(*) AS like_count FROM game_likes WHERE game_id = $gameId";
                                    $likes_result = mysqli_query($dbcon, $likes_query);
                                    $likes_data = mysqli_fetch_assoc($likes_result);
                                    $likes = $likes_data['like_count'];
                                    $row['likes'] = $likes;
                                    $matched_games[] = $row;
                                    break; // 하나의 테마에 대해 일치하는 경우에만 추가하고 루프 종료
                                }
                            }
                        }

                        // 일치하는 게임 중 좋아요 수가 가장 높은 상위 3개의 게임을 선택
                        usort($matched_games, function ($a, $b) {
                            return $b['likes'] - $a['likes'];
                        });
                        $top_games = array_slice($matched_games, 0, 3);

                        $top_games = array($top_games[1], $top_games[0], $top_games[2]);
                        
                        $i = 1;
                        foreach ($top_games as $game) {
                            $image = $game["image"];
                            $gameId = $game["id"];
                            $medal = $i < 3 ? $medals[$i] : 'img/other.png';
                            echo "
                                <div class='game-card'>
                                <a href='gamedata.php?id=$gameId'>
                                    <img class='medal' src='$medal' alt='$i 등'>
                                    <img class='img_gm' src=$image>
                                    <h1>$game[name]</h1>
                                </a></div>";
                            $i = $i == 0 ? 2 : $i - 1;
                        }
                        ?>
                    </div>
                </div>
            </div>
    </div>
    </main>

    <div class="clear"></div>
    <?php
    include "common/footer.php";
    ?>
    </div>
</body>

</html>