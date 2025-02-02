<?php
include "common/dbconnect.php";

// 전체 게시글 수 가져오기
$get_all_article = "select * from article";
$result_all_article = mysqli_query($dbcon, $get_all_article);
$total_article = mysqli_num_rows($result_all_article);

// 페이지 수 계산
$article_per_page = 8;
$pages = ceil($total_article / $article_per_page);

// 현재 페이지
$current_page = 1;
if (isset($_GET["page"])) {
    $current_page = $_GET['page'];
}

// 공지사항 가져오기
$get_notice = "select * from notice order by post_time desc limit 2";

$category = "";
$select_category = "";
if (isset($_GET["category"])) {
    $category = $_GET['category'];
    if ($category != '')
        $select_category = " and a.post_type_id = '" . $category . "' ";
}
// 검색 결과
$search_type = "";
$keyword = "";
$search_query = "";
if (isset($_GET["search_type"]) && isset($_GET["keyword"])) {
    $search_type = $_GET["search_type"];
    $keyword = $_GET["keyword"];
    if ($search_type != '') {
        if ($search_type == 1) {
            $search_query = " and a.title like '%" . $keyword . "%' ";
        } else if ($search_type == 2) {
            $search_query = " and m.username like '%" . $keyword . "%' ";
        }
    }
}

$get_article = "select a.article_id, c.post_type, a.title, m.username, a.post_time from article a, member m, article_category c where a.user_id = m.user_id and a.post_type_id = c.post_type_id " . $select_category . $search_query . "order by a.article_id desc limit " . (($current_page - 1) * $article_per_page) . ", " . $article_per_page;

$result_notice = mysqli_query($dbcon, $get_notice);
$result_article = mysqli_query($dbcon, $get_article);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BDGuide : 정보 공유 게시판</title>
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
    <link rel="stylesheet" href="css/board.css">
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

        <main id="board">
            <table>
                <tr>
                    <td class="article_title" colspan="7" height="70px" style="border-bottom: 1px solid #000;">
                        <div align="right">
                            <a href="#" class="newtitle" target="_self"
                                style="color:#20124d; font-weight: bold; text-decoration: none; float: left;">정보 공유
                                게시판</a>
                            <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                                <select name="category" onChange="this.form.submit();"
                                    style="border: 1px solid #424242; border-radius: 2px; height: 25px;">
                                    <option value="" <?php if ($category == '')
                                        echo "selected"; ?>>카테고리</option>
                                    <option value="cat_1" <?php if ($category == 'cat_1')
                                        echo "selected"; ?>>팁과 노하우
                                    </option>
                                    <option value="cat_2" <?php if ($category == 'cat_2')
                                        echo "selected"; ?>>협력</option>
                                    <option value="cat_3" <?php if ($category == 'cat_3')
                                        echo "selected"; ?>>경쟁</option>
                                    <option value="cat_4" <?php if ($category == 'cat_4')
                                        echo "selected"; ?>>카드 게임</option>
                                    <option value="cat_5" <?php if ($category == 'cat_5')
                                        echo "selected"; ?>>경제</option>
                                    <option value="cat_6" <?php if ($category == 'cat_6')
                                        echo "selected"; ?>>마피아</option>
                                    <option value="cat_7" <?php if ($category == 'cat_7')
                                        echo "selected"; ?>>블러핑</option>
                                    <option value="cat_8" <?php if ($category == 'cat_8')
                                        echo "selected"; ?>>추상 전략</option>
                                    <option value="cat_9" <?php if ($category == 'cat_9')
                                        echo "selected"; ?>>방탈출</option>
                                    <option value="cat_10" <?php if ($category == 'cat_10')
                                        echo "selected"; ?>>추리</option>
                                </select>

                                <?php
                                if (isset($_SESSION['user_id'])) {
                                    echo "<a href='rmf.php' class='top_buttons' width='20px' height='30px'>글쓰기</a>";
                                }
                                ?>
                            </form>
                        </div>
                    </td>
                </tr>
                <tr align="center">
                    <td class="wt">번호</td>
                    <td class="wt">말머리</td>
                    <td class="wt">제목</td>
                    <td class="wt">글쓴이</td>
                    <td class="wt2">등록일</td>
                    <td class="wt">조회수</td>
                    <td class="wt">추천</td>
                </tr>

                <!-- 글 가져오는 부분 -->
                <?php
                //공지
                while ($row = mysqli_fetch_array($result_notice)) {
                    echo "<tr>
                <td class='article' style='font-weight: bold'>공지</td>
                <td class='article_title' colspan='6' style='font-weight: bold'><a href='post.php?notice_no=$row[notice_id]'> $row[title] </a></td>
                </tr>";
                }

                // 일반 게시글
                while ($row = mysqli_fetch_array($result_article)) {
                    $post_date = date("Y-m-d", strtotime($row['post_time']));
                    $get_views = "select * from article_watched where article_id = " . $row['article_id'];
                    $result_views = mysqli_query($dbcon, $get_views);
                    if ($result_views && mysqli_num_rows($result_views)) {
                        $views = mysqli_num_rows($result_views);
                    } else {
                        $views = 0;
                    }
                    $like = 0;
                    echo "<tr>
                <td class='article'> $row[article_id] </td>
                <td class='article'> $row[post_type] </td>
                <td class='article_title'><a href='post.php?post_no=$row[article_id]'> $row[title] </a></td>
                <td class='article'> $row[username] </td>
                <td class='article'> $post_date </td>
                <td class='article'> $views </td>
                <td class='article'> $like </td>
                </tr>";
                }
                echo
                "</table>
                <form class='pages' align='center' style='margin-top: 10px;' action=$_SERVER[PHP_SELF] method='get'>"; ?>
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
                </form>
                <?php 
                // DB 연결 종료
                mysqli_close($dbcon);
                ?>
                <br>

                <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="get">
                    <table class="search" style="border: 1px solid #888888">
                        <tr>
                            <td>
                                <select name="search_type">
                                    <option value="1">제목+내용</option>
                                    <option value="2">글쓴이</option>
                                    <option value="3">댓글</option>
                                </select>
                            </td>
                            <td>
                                <input name="keyword" type="text"
                                    style="border-left: 1px solid #888888; border-right: 1px solid #888888">
                            </td>
                            <td>
                                <button type="submit" class="search_btn">
                                    <i class="fas fa-search"></i>
                                    <span class="sr-only">검색</span>
                                </button>
                            </td>
                        </tr>
                    </table>
                </form>
        </main>
        <!-- 푸터 -->
        <?php
        include "common/footer.php";
        ?>
    </div>
</body>

</html>