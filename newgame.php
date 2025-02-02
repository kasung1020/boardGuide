<?php
include "common/dbconnect.php";

// 전체 게임 수 가져오기
$get_all_games = "select * from games";
$result_all_games = mysqli_query($dbcon, $get_all_games);
$total_games = mysqli_num_rows($result_all_games);

// 페이지 수 계산
$games_per_page = 9;
$pages = ceil($total_games / $games_per_page);

// 현재 페이지
$current_page = 1;
if (isset($_GET["page"])) {
    $current_page = $_GET['page'];
}

// 게임 데이터 가져오기
$get_games = "select * from games order by released desc limit " . (($current_page - 1) * $games_per_page) . ", " . $games_per_page;
$result_games = mysqli_query($dbcon, $get_games);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 신규 보드게임</title>
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
    <link rel="stylesheet" href="css/newgame.css">
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
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
        <div id="big_box_1">
            <h2 style="margin-left: 505px;">신규 보드게임</h2>
            <br>
            <ul class="box_2">
                <?php
                while ($row = mysqli_fetch_array($result_games)) {
                    $image = $row["image"];
                    $gameId = $row["id"];
                    echo "<li>
                    <a href='gamedata.php?id=$gameId'>
                        <div class='box ongoing_line'>
                            <div class='img'>
                                <div class='prding'>
                                    <img src=$image width='320' height='320'>
                                    <div class='info preorder'>
                                        <p style='font-size: 20px;'>$row[name]</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </a>
                    </li>";
                }
                ?>
            </ul>
            <div class="paging_box">
                <ul class="paging_1" align="right">
                    <li>
                        <?php
                        // 이전 페이지 링크
                        // 현재 페이지가 1보다 크면 이전 페이지 링크 활성화
                        if ($current_page > 1) {
                            $prev_page = $current_page - 1;
                            $filter_params['page'] = $prev_page;
                            $prev_query_string = http_build_query($filter_params);
                            echo "<a href='?" . $prev_query_string . "' class='pre-btn' title='이전 페이지로 이동합니다'>이전</a>";
                        }
                        ?>
                    </li>
                    <?php
                    for ($i = 1; $i <= $pages; $i++) {
                        $args = "";
                        if ($current_page == $i) {
                            $args = "class='on'";
                        }
                        echo "<li><a href='?page=$i' " . $args . ">$i</a></li>";
                    }
                    ?>
                    <li>
                        <?php
                        // 다음 페이지 링크
                        // 현재 페이지가 마지막 페이지보다 작으면 다음 페이지 링크 활성화
                        if ($current_page < $pages) {
                            $next_page = $current_page + 1;
                            $filter_params['page'] = $next_page;
                            $next_query_string = http_build_query($filter_params);
                            echo "<a href='?" . $next_query_string . "' class='next-btn' title='다음 페이지로 이동합니다'>다음 <i class='fas fa-angle-right'></i></a>";
                        }
                        ?>
                    </li>
                </ul>
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