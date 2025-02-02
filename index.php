<?php
include "common/dbconnect.php";

// 게임 데이터 가져오기
$get_games = "select * from games order by likes desc limit 6";
$result_games = mysqli_query($dbcon, $get_games);

// 게시글 가져오기(가장 최근 글 6개)
$get_article = "select ac.post_type, a.title from article a, article_category ac where ac.post_type_id=a.post_type_id order by article_id desc limit 5";
$result_article = mysqli_query($dbcon, $get_article);
$get_last_article = "select ac.post_type, a.title from article a, article_category ac where ac.post_type_id=a.post_type_id order by article_id desc limit 5, 1";
$result_last_article = mysqli_query($dbcon, $get_last_article);

// 공지사항 가져오기(가장 최근 글 6개)
$get_notice = "select title from notice order by post_time desc limit 5";
$result_notice = mysqli_query($dbcon, $get_notice);
$get_last_notice = "select title from notice order by post_time desc limit 5, 1";
$result_last_notice = mysqli_query($dbcon, $get_last_notice);
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
    <link rel="stylesheet" href="css/modal.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <!-- <script src="js/post.js" defer="defer" type="text/javascript"></script> -->
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

        <div class="clear"></div>

        <!-- 광고 배너 -->

        <div id="ads" class="wrap">
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/cardbanner1.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/valorant.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/cardbanner3.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/cardbanner4.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/cardbanner1.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/zero.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/dnflrmadbd.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/cat.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/kopoImg.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <div class="flip">
                <div class="ads_card">
                    <!-- 앞면 -->
                    <div class="ads_front">
                        <img src="img/cardfront.jpg" alt="no" class="img_ad">
                    </div>
                    <!-- 뒷면 -->
                    <div class="ads_back">
                        <img src="img/kopoImgsam.jpg" alt="no" class="img_ad">
                    </div>
                </div>
            </div>
            <!-- X 아이콘 추가 -->
            <span class="close-all">
                <i class="fas fa-times"></i>
            </span>
        </div>

        <div class="clear"></div>

        <main class="wrap">
            <div class="bigpicture">
                <div class="rank">
                    <div id="ranktitle">
                        인기 순위
                        <a class="arrow-link tw-text-xs tw-uppercase" href="game_all_rank.php">
                            전체보기
                            <fa-icon class="ng-fa-icon">
                                <svg role="img" aria-hidden="true" focusable="false" data-prefix="fas"
                                    data-icon="chevron-right" class="svg-inline--fa fa-chevron-right"
                                    xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                    <path fill="currentColor"
                                        d="M310.6 233.4c12.5 12.5 12.5 32.8 0 45.3l-192 192c-12.5 12.5-32.8 12.5-45.3 0s-12.5-32.8 0-45.3L242.7 256 73.4 86.6c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0l192 192z">
                                    </path>
                                </svg>
                            </fa-icon>
                        </a>
                    </div>
                    <div class="ranktoday-wrapper-main">
                        <div class="main-game-listing">
                            <!-- 인기 순위 -->
                            <?php
                            $rank = 1;
                            while ($row = mysqli_fetch_array($result_games)) {
                                $image = $row["image"];
                                $gameId = $row["id"];
                                echo "<a class='game-listing-wrapper' href='gamedata.php?id=$gameId'>
                                <div class='game-listing'>
                                <div class='game-listing-thumb'style='background-image:url($image)'>
                                </div>
                                <div class='flex'>
                                <div class='board-listing-rank'>$rank</div>
                                <div class='text-wrapper'>  
                                <div class='game-listing-title new-ellip'>$row[name]</div>
                                <div class='game-listing-info new-ellip'>$row[english_name]</div>
                                </div>
                                </div>
                                </div>
                                </a>";
                                $rank++;
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <!-- 게시판 영역 -->
                <div class="ranktoday-wrapper-main" style="height: 330px;">
                    <section class="section">
                        <table>
                            <tr>
                                <td class="title" colspan="2" height="50px"
                                    style="border-bottom: 1px solid #6e6e6ee3; border-top: 1px solid #000;">
                                    <a href="board.php" target="_self" style="margin: 0px 140px 0px 10px;">정보 공유
                                        게시판</a>
                                    <a href="board.php">더보기+</a>
                                </td>
                            </tr>

                            <?php
                            while ($row = mysqli_fetch_array($result_article)) {
                                echo "<tr align='left'>
                                <td class='wt'>
                                    <a href='board.php'> $row[post_type] </a>
                                </td>
                                <td class='writing'>
                                    <a href='board.php'> $row[title] </a>
                                </td>
                                </tr>";
                            }
                            while ($row = mysqli_fetch_array($result_last_article)) {
                                echo "<tr align='left'>
                                <td style='width: 120px; padding: 12px 12px;'>
                                <a href='board.php' style='color: #3d85c6; text-decoration: none;'> $row[post_type] </a>
                                </td>
                                <td style='padding: 12px 12px;'>
                                <a href='board.php' style='text-decoration: none; color: #000;'> $row[title] </a>
                                </td>
                                </tr>";
                            }
                            ?>
                        </table>
                    </section>
                    <!-- 이미지 슬라이드 -->
                    <div id="img_slide">
                        <div class="slide">
                            <img src="img/imgslide1.jpg" alt="no">
                            <img src="img/imgslide2.jpg" alt="no">
                        </div>
                    </div>
                    <!-- 공지사항 영역-->
                    <section class="aside">
                        <table align="center">
                            <tr align="left">
                                <td class="title" colspan="2" height="50px"
                                    style="border-bottom: 1px solid #6e6e6ee3; border-top: 1px solid #000;">
                                    <a href="notice.php" target="_self" style="margin: 0px 210px 0px 10px;">공지사항</a>
                                    <a href="notice.php">더보기+</a>
                                </td>
                            </tr>
                            <?php
                            while ($row = mysqli_fetch_array($result_notice)) {
                                echo "<tr align='left'>
                                <td class='writing'>
                                    <a href='notice.php'> $row[title] </a>
                                </td>
                                </tr>";
                            }
                            while ($row = mysqli_fetch_array($result_last_notice)) {
                                echo "<tr align='left'>
                                <td style='padding: 12px 12px;'>
                                <a href='notice.php' style='text-decoration: none; color: #000;'> $row[title] </a>
                                </td>
                                </tr>";
                            }
                            ?>
                        </table>
                    </section>
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