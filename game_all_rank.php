<?php
include "common/dbconnect.php";

// 전체 게임 수 가져오기
$get_all_games = "select * from games";
$result_all_games = mysqli_query($dbcon, $get_all_games);
$total_games = mysqli_num_rows($result_all_games);

// 인기도순 정렬
$sort_by_popularity = "desc";
if (isset($_GET["sort_by_popularity"])) {
    $sort_by_popularity = $_GET['sort_by_popularity'];
}

// 인원수로 검색
$personCount = "";
if (isset($_GET["personCount"])) {
    $personCount = $_GET['personCount'];
}

// 게임 이름으로 검색
$gameTitle = "";
if (isset($_GET["gameTitle"])) {
    $gameTitle = $_GET['gameTitle'];
}

// 난이도로 검색
$difficulty = "";
if (isset($_GET["difficulty"])) {
    $difficulty = $_GET['difficulty'];
}

// 데이터베이스에서 게임 테이블의 모든 고유 카테고리를 선택
$get_unique_categories = "SELECT DISTINCT category FROM games ORDER BY category";
$result_unique_categories = mysqli_query($dbcon, $get_unique_categories);

// 카테고리를 저장할 배열을 초기화
$categories = array();

// 데이터베이스 결과 집합을 반복하여 각 행을 처리
while ($row = mysqli_fetch_assoc($result_unique_categories)) {
    // '/'를 기준으로 카테고리를 분리
    $split_categories = explode('/', $row['category']);

    // 분리된 각 카테고리에 대해 반복
    foreach ($split_categories as $category) {
        // 각 카테고리에서 앞뒤 공백 제거
        $clean_category = trim($category);
        // 이미 배열에 없는 경우에만 해당 카테고리 추가
        if (!in_array($clean_category, $categories)) {
            $categories[] = $clean_category;
        }
    }
}

sort($categories);

// 테마로 검색
$selectedThemes = array();
if (isset($_GET["theme"])) {
    $selectedThemes = $_GET['theme'];
}

$search_query = "";

if ($personCount != "" || $gameTitle != "" || $difficulty != "" || !empty($selectedThemes)) {
    $search_query .= " WHERE ";

    $conditions = array();
    if ($personCount != "") {
        $conditions[] = "players_min <= $personCount AND players_max >= $personCount";
    }
    if ($gameTitle != "") {
        $conditions[] = "name LIKE '%" . $gameTitle . "%'";
    }
    if ($difficulty != "") {
        $conditions[] = "difficulty = '" . $difficulty . "'";
    }
    if (!empty($selectedThemes)) {
        $themeConditions = array();
        foreach ($selectedThemes as $theme) {
            $themeConditions[] = "category LIKE '%" . $theme . "%'";
        }
        $conditions[] = '(' . implode(' OR ', $themeConditions) . ')';
    }
    $search_query .= implode(" AND ", $conditions);
}

// 검색 조건이 적용된 게임 수 가져오기
$get_filtered_games_count = "SELECT COUNT(*) AS count FROM games" . $search_query;
$result_filtered_games_count = mysqli_query($dbcon, $get_filtered_games_count);
$row = mysqli_fetch_assoc($result_filtered_games_count);
$total_filtered_games = $row['count'];

// 페이지 수 계산
$games_per_page = 10;
$pages = ceil($total_filtered_games / $games_per_page); // 검색 조건이 반영된 게임 수를 사용

// 현재 페이지
$current_page = 1;
if (isset($_GET["page"])) {
    $current_page = $_GET['page'];
}

// 페이지 넘길 때 필터링을 유지 할려면 사용자가 선택한 필터 값을 페이지 URL에 포함
// 그러고나서 각 페이지 링크를 클릭 시 필터링이 유지
// 현재 설정된 필터값을 쿼리 매개변수로 유지하기 위한 배열 생성
$filter_params = array();
if ($personCount != "") {
    $filter_params['personCount'] = $personCount;
}
if ($sort_by_popularity != "") {
    $filter_params['sort_by_popularity'] = $sort_by_popularity;
}
if ($gameTitle != "") {
    $filter_params['gameTitle'] = $gameTitle;
}
if ($difficulty != "") {
    $filter_params['difficulty'] = $difficulty;
}

// 게임 데이터 가져오기
$get_games = "SELECT * FROM games" . $search_query . " ORDER BY likes " . $sort_by_popularity . " LIMIT " . (($current_page - 1) * $games_per_page) . ", " . $games_per_page;
$result_games = mysqli_query($dbcon, $get_games);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 게임 인기순위</title>
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
    <!-- 자바스크립트 -->
    <script src="js/jquery-1.12.3 - .js" type="text/javascript"></script>
    <script src="js/menu.js" defer="defer" type="text/javascript"></script>
    <script src="https://code.jquery.com/jquery-3.x.x.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="js/game_all_rank.js" defer="defer" type="text/javascript"></script>
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
        <!-- 게임순위에는 광고 배너 넣을 생각 없음 넣지마셈 -->

        <div class="clear"></div>
        <!------------- 메인 시작 -------------------------------->

        <main class="wrap" id="game_all_rank_main">
            <div class="bigpicture2">
                <div class="bigborder">
                    <div class="sortcontent">
                        <div class="filter_panel_card_close">
                            <div class="filter_name">
                                <h2>정렬</h2>
                                <i class="fas fa-angle-down"></i>
                            </div>
                            <div class="filter">
                                <div class="widget dropdown_widget full_width font_size_1">
                                    <div class="dropdown_wrap state_default">
                                        <span role="option" class="input">인기도 내림차순</span>
                                        <span class="select_icon">
                                            <span class="arrow_icon"></span>
                                        </span>
                                    </div>
                                    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                        <select id="sort_by" name="sort_by_popularity" onChange="this.form.submit();"
                                            class="full_width font_size_1">
                                            <option value="desc" <?php if ($sort_by_popularity == 'desc')
                                                echo "selected"; ?>>인기도 내림차순</option>
                                            <option value="asc" <?php if ($sort_by_popularity == 'asc')
                                                echo "selected"; ?>>
                                                인기도 오름차순</option>
                                        </select>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                            <div class="filter_panel_card">
                                <div class="filter_name" data-group="mainFilter">
                                    <h2>필터</h2>
                                    <i class="fas fa-angle-down"></i>
                                </div>
                                <div class="filter" data-group="mainFilter">
                                    <h3>인원수 설정</h3>
                                    <div class="person_count">
                                        <label for="personCount">인원수 :</label>
                                        <input type="number" id="personCount" name="personCount" min="1" max="6">
                                    </div>
                                </div>
                                <div class="filter" data-group="mainFilter">
                                    <h3>게임 검색</h3>
                                    <div class="title_search">
                                        <input type="text" name="gameTitle" id="gameTitle" placeholder="게임 제목을 입력하세요">
                                    </div>
                                </div>
                                <div class="filter" data-group="mainFilter">
                                    <h3>난이도</h3>
                                    <div class="difficulty_selection">
                                        <label class="difficulty_option">
                                            <input type="radio" name="difficulty" value="Easy">
                                            <span class="difficulty_label">Easy</span>
                                        </label>
                                        <label class="difficulty_option">
                                            <input type="radio" name="difficulty" value="Normal">
                                            <span class="difficulty_label">Normal</span>
                                        </label>
                                        <label class="difficulty_option">
                                            <input type="radio" name="difficulty" value="Hard">
                                            <span class="difficulty_label">Hard</span>
                                        </label>
                                    </div>
                                </div>
                                <div class="filter" data-group="mainFilter">
                                    <h3>테마 선택</h3>
                                    <div class="theme_selection">
                                        <?php foreach ($categories as $category): ?>
                                            <label class="theme_option">
                                                <input type="checkbox" name="theme[]"
                                                    value="<?php echo htmlspecialchars($category); ?>">
                                                <?php echo htmlspecialchars($category); ?>
                                            </label>
                                        <?php endforeach; ?>
                                    </div>
                                </div>
                            </div>
                            <!-- 검색 버튼 -->
                            <div class="apply small background_color light_blue disabled no_click">
                                <button type="submit">
                                    <div class="loading_wrapper hide">
                                        <div class="ball-scale-multiple white loader">
                                            <div></div>
                                            <div></div>
                                            <div></div>
                                        </div>
                                    </div>
                                    <p class="load_more">
                                        <a class="load_more" data-next-page="2" data-current-page="1"
                                            data-partial="">검색</a>
                                    </p>
                                </button>
                            </div>
                        </form>
                    </div>
                    <!------------- 게임테이블 시작 -------------------------------->
                    <div class="game_rank_content">
                        <div id="game_rank_container">
                            <div class="game_rank_maincontent">
                                <!-- 페이지 맨 아래에도 해야함 -->
                                <div class="pagingbox">
                                    <ul class="paging" align="right">
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
                                            echo "<li>
                                            <a href='?page=$i' " . $args . ">$i</a>
                                            </li>";
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
                                <div id="board-game-rank-container">
                                    <table>
                                        <tr id="border_none_tr">
                                            <th style="border: none; width: 110px;">보드게임순위</th>
                                            <th style="border: none; width: 120px;">이미지</th>
                                            <th style="border: none; width: 450px;">제목</th>
                                            <th style="border: none; width: 100px;">난이도</th>
                                            <th style="border: none; width: 100px;">인원수</th>
                                            <th style="border: none; width: 100px;">추천</th>
                                        </tr>
                                        <?php
                                        $rank = 1 + ($current_page - 1) * 10;
                                        while ($row = mysqli_fetch_array($result_games)) {
                                            $image = $row["image"];
                                            $gameId = $row["id"]; // 게임 ID
                                            echo "<tr>
                                            <td>$rank</td>
                                            <td><a href='gamedata.php?id=$gameId'><img src=$image alt='{$row['name']}' /></a></td>
                                            <td><a href='gamedata.php?id=$gameId'>{$row['name']}</a></td>
                                            <td>$row[difficulty]</td>
                                            <td>$row[players_min]~$row[players_max]</td>
                                            <td>$row[likes]</td>
                                            </tr>";
                                            $rank++;
                                        }
                                        ?>
                                    </table>
                                </div>
                                <!-- 게임 테이블 박스종료-----------  -->
                                <!-- 아래 pagingbox 는 다음 페이지로 넘기는코드 -->
                                <div class="pagingbox">
                                    <ul class="paging2" align="right">
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
                                            // 현재 페이지 번호를 필터 매개변수 배열에 추가합니다.
                                            $filter_params['page'] = $i;
                                            // http_build_query() 함수를 사용해 매개변수 배열을 URL 쿼리 문자열로 변환합니다.
                                            $query_string = http_build_query($filter_params);
                                            echo "<li><a href='?" . $query_string . "' " . $args . ">$i</a></li>";
                                        }
                                        ?>
                                        <li>
                                            <?php
                                            // 다음 페이지 링크
                                            // 현재 페이지가 마지막 페이지보다 작으면 다음 페이지 링크 표시
                                            if ($current_page < $pages) {
                                                $next_page = $current_page + 1;
                                                $filter_params['page'] = $next_page;
                                                $next_query_string = http_build_query($filter_params);
                                                echo "<a href='?" . $next_query_string . "' class='next-btn' title='다음 페이지로 이동합니다'>다음 <i class='fas fa-angle-right'></i></a>";
                                            }
                                            // 마지막 페이지에서는 다음 링크를 표시하지 않음
                                            ?>
                                        </li>
                                    </ul>
                                </div>
                                <!-- 여기까지가 다음페이지  -->
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